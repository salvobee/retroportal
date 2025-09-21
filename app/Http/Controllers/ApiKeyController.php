<?php

namespace App\Http\Controllers;

use App\Models\ApiKey;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ApiKeyController extends Controller
{
    public function update(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'openai'        => ['nullable', 'string', 'max:255'],
            'openweathermap'=> ['nullable', 'string', 'max:255'],
        ]);

        foreach (['openai', 'openweathermap'] as $type) {
            if (isset($validated[$type])) {
                ApiKey::updateOrCreate(
                    ['user_id' => $user->id, 'type' => $type],
                    ['key' => $validated[$type]]
                );
            }
        }

        return redirect()->route('dashboard.profile')->with('status', __('API keys updated successfully'));
    }
}
