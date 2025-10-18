<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\ApiKey;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ApiKeyController extends Controller
{
    public function update(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'openai'         => ['nullable', 'string', 'max:255'],
            'openweathermap' => ['nullable', 'string', 'max:255'],
        ]);

        foreach (['openai', 'openweathermap'] as $type) {
            $value = $validated[$type] ?? null;

            if ($value === null || $value === '') {
                // Se vuoto → elimina eventuale chiave esistente
                ApiKey::where('user_id', $user->id)
                    ->where('type', $type)
                    ->delete();
            } else {
                // Altrimenti crea/aggiorna
                ApiKey::updateOrCreate(
                    ['user_id' => $user->id, 'type' => $type],
                    ['key' => $value]
                );
            }
        }

        return redirect()
            ->route('dashboard.profile')
            ->with('status', __('API keys updated successfully'));
    }
}
