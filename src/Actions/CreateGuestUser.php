<?php

namespace Lyre\Guest\Actions;

use Lyre\Guest\Models\Guest;
use Illuminate\Auth\Events\Registered;
use Illuminate\Contracts\Auth\StatefulGuard;
use Laravel\Fortify\Contracts\CreatesNewUsers;
use Illuminate\Support\Str;

use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Session;
use Stevebauman\Location\Facades\Location;

class CreateGuestUser
{
    public function __invoke(StatefulGuard $guard, CreatesNewUsers $creator)
    {
        $uuid = Cookie::get('guest_uuid') ?? (string) Str::uuid();

        $guest = Guest::where('guest_uuid', $uuid)->first();

        $position = Location::get(request()->ip());

        $country = $position?->countryName ?? null;
        $city    = $position?->cityName ?? null;

        if ($guest && $guest->user) {
            $guard->login($guest->user, true);
            session()->regenerate();
            $guest->update([
                'country' => $country ?? $guest->country,
                'city' => $city ?? $guest->city,
                'language' => request()->getPreferredLanguage() ?? $guest->language,
                'session_id' => session()->getId(),
                'currency_code' => $position?->currencyCode ?? $guest->currency_code,
                'country_code' => $position?->countryCode ?? $guest->currency_code,
                'region_code' => $position?->regionCode ?? $guest->currency_code,
                'region_name' => $position?->regionName ?? $guest->currency_code,
                'zip_code' => $position?->zipCode ?? $guest->currency_code,
                'iso_code' => $position?->isoCode ?? $guest->currency_code,
                'postal_code' => $position?->postalCode ?? $guest->currency_code,
                'latitude' => $position?->latitude ?? $guest->currency_code,
                'longitude' => $position?->longitude ?? $guest->currency_code,
                'metro_code' => $position?->metroCode ?? $guest->currency_code,
                'area_code' => $position?->areaCode ?? $guest->currency_code,
                'timezone' => $position?->timezone ?? $guest->currency_code
            ]);
            return $guest->user;
        }

        $password = bin2hex(random_bytes(6));
        // $appName = clean_str(config('app.name'));

        $details = [
            'name' => 'Guest_' . Str::random(6),
            'email' => 'guest_' . Str::uuid() . '@aspire.com',
            'password' => $password,
            'password_confirmation' => $password,
        ];

        event(new Registered($user = $creator->create($details)));

        $user->is_guest = true;
        $user->save();

        $guard->login($user, true);

        Cookie::queue(Cookie::make(
            config('session.cookie'),
            Session::getId(),
            525600, // 1 year
            config('session.path'),
            config('session.domain'),
            config('session.secure'),
            config('session.http_only'),
            false,
            config('session.same_site')
        ));

        Cookie::queue(Cookie::make(
            'guest_uuid',
            $uuid,
            525600 // 1 year
        ));


        Guest::create([
            'user_id' => $user->id,
            'ip' => request()->ip(),
            'user_agent' => request()->userAgent(),
            'referrer' => request()->headers->get('referer'),
            'current_url' => request()->fullUrl(),
            'previous_url' => url()->previous(),
            'country' => $country,
            'city' => $city,
            'language' => request()->getPreferredLanguage(),
            'session_id' => session()->getId(),
            'guest_uuid' => $uuid,
            'currency_code' => $position?->currencyCode ?? null,
            'country_code' => $position?->countryCode ?? null,
            'region_code' => $position?->regionCode ?? null,
            'region_name' => $position?->regionName ?? null,
            'zip_code' => $position?->zipCode ?? null,
            'iso_code' => $position?->isoCode ?? null,
            'postal_code' => $position?->postalCode ?? null,
            'latitude' => $position?->latitude ?? null,
            'longitude' => $position?->longitude ?? null,
            'metro_code' => $position?->metroCode ?? null,
            'area_code' => $position?->areaCode ?? null,
            'timezone' => $position?->timezone ?? null
        ]);

        return $user;
    }
}
