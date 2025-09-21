<?php

namespace App\Http\Controllers\Features;

use App\Contracts\ChatbotService;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ChatbotController extends Controller
{
    /**
     * Render the chat page with the current session-backed history.
     */
    public function index(Request $request)
    {
        $history = $request->session()->get('chat_history', []);
        return view('pages.chatbot', ['history' => $history, 'error' => null]);
    }

    /**
     * Handle a classic form POST and append both user and assistant turns.
     */
    public function send(Request $request, ChatbotService $chatbot)
    {
        $request->validate(
            ['message' => 'required|string|max:500'],
            [
                'message.required' => __('ai.validation.message_required'),
                'message.max'      => __('ai.validation.message_max'),
            ]
        );

        $history = $request->session()->get('chat_history', []);
        $userMsg = trim($request->string('message')->toString());
        $history[] = ['role' => 'user', 'content' => $userMsg];

        try {
            // Prefer with-history to give the model minimal context
            $reply = $chatbot->askWithHistory($history);

            $history[] = ['role' => 'assistant', 'content' => $reply];
            $request->session()->put('chat_history', $history);
            $request->session()->save();

            return redirect()->route('chatbot.index');
        } catch (\RuntimeException $e) {
            // Map exception code to a translated, user-friendly message
            $errorKey = $this->mapErrorKey($e->getCode());
            $errorMsg = __('ai.error.' . $errorKey);

            return view('pages.chatbot', [
                'history' => $history,
                'error'   => $errorMsg,
            ]);
        }
    }

    /**
     * Clear the current conversation stored in the session.
     */
    public function clear(Request $request)
    {
        $request->session()->forget('chat_history');
        $request->session()->save();
        return redirect()->route('chatbot.index');
    }

    /**
     * Translate numeric error codes into ai.php error keys.
     */
    protected function mapErrorKey(int $code): string
    {
        return match ($code) {
            400 => 'bad_request',
            401 => 'unauthorized',
            403 => 'forbidden',
            404 => 'not_found',
            408 => 'timeout',
            429 => 'too_many_requests',
            500 => 'server_error',
            502, 503 => 'unavailable',
            504 => 'timeout',
            700 => 'network',          // custom: network transport (no HTTP code)
            701 => 'invalid_response', // custom: schema/shape invalid
            default => 'generic',
        };
    }
}
