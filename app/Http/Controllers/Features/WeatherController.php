<?php

namespace App\Http\Controllers\Features;

use App\Exceptions\Weather\MissingApiKeyException;
use App\Http\Controllers\Controller;
use App\Services\Weather\InvalidApiResponseException;
use App\Services\Weather\OpenWeatherService;
use Illuminate\Http\Request;

class WeatherController extends Controller
{
    public function __construct(private OpenWeatherService $owm) {}

    /** Step 1: form semplice */
    public function form(Request $request)
    {
        return view('pages.weather.form', [
            'city'  => (string) $request->query('city', ''),
            'error' => null,
        ]);
    }

    /** Step 2: mostra i possibili match (geocoding) */
    public function search(Request $request)
    {
        $request->validate(['q' => 'required|string|min:2|max:120']);
        $q = $request->string('q');
        $results = [];
        $error = null;

        $userKey = $this->resolveUserApiKey($request);

        try {
            $results = $this->owm->searchCities($q, 10, $userKey);
        } catch (MissingApiKeyException $e) {
            $error = __('weather.errors.missing_key');
        } catch (InvalidApiResponseException $e) {
            $error = __('weather.errors.invalid_response');
        } catch (\Throwable $e) {
            $error = __('weather.errors.generic');
        }

        return view('pages.weather.search', compact('q', 'results', 'error'));
    }

    /** Step 3: mostra meteo per coords scelte */
    public function show(Request $request)
    {
        $request->validate([
            'lat' => 'required|numeric',
            'lon' => 'required|numeric',
            'name' => 'nullable|string|max:120',
            'state' => 'nullable|string|max:120',
            'country' => 'nullable|string|max:2',
        ]);

        $error = null;
        $data = [];

        $userKey = $this->resolveUserApiKey($request);

        try {
            $data = $this->owm->currentByCoords(
                (float) $request->lat,
                (float) $request->lon,
                $userKey
            );
        } catch (MissingApiKeyException $e) {
            $error = __('weather.errors.missing_key');
        } catch (InvalidApiResponseException $e) {
            $error = __('weather.errors.invalid_response');
        } catch (\RuntimeException $e) {
            if ($e->getMessage() === 'OWM_RATE_LIMIT') {
                return response()->view('pages.weather.limited', [], 429);
            }
            $error = __('weather.errors.generic');
        } catch (\Throwable $e) {
            $error = __('weather.errors.generic');
        }

        return view('pages.weather.show', [
            'place' => [
                'name'    => $request->string('name')->toString(),
                'state'   => $request->string('state')->toString(),
                'country' => $request->string('country')->toString(),
            ],
            'data'  => $data,
            'error' => $error,
        ]);
    }

    private function resolveUserApiKey(Request $request): ?string
    {
        $user = $request->user();

        if (!$user) {
            return null;
        }

        $value = $user->apiKeys()
            ->where('type', 'openweathermap')
            ->whereNotNull('key')
            ->value('key');

        if ($value === null) {
            return null;
        }

        $trimmed = trim((string) $value);

        return $trimmed === '' ? null : $trimmed;
    }
}
