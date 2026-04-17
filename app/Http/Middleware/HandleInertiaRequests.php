<?php

namespace App\Http\Middleware;

use Illuminate\Http\Request;
use Inertia\Middleware;

class HandleInertiaRequests extends Middleware
{
    /**
     * The root template that is loaded on the first page visit.
     *
     * @var string
     */
    protected $rootView = 'app';

    /**
     * Determine the current asset version.
     */
    public function version(Request $request): ?string
    {
        return parent::version($request);
    }

    /**
     * Define the props that are shared by default.
     *
     * @return array<string, mixed>
     */
    public function share(Request $request): array
    {
        return [
            ...parent::share($request),
            'auth' => [
                'user' => $request->user(),
            ],
            'company' => [
                'name'        => company('company_name'),
                'short_name'  => company('company_short_name'),
                'tagline'     => company('company_tagline'),
                'address'     => \App\Models\CompanySetting::getAddressFull(),
                'address_short' => company('address_kota') . ', ' . company('address_provinsi'),
                'phone_primary'   => company('phone_primary'),
                'phone_secondary' => company('phone_secondary'),
                'email'       => company('email'),
                'website'     => company('website'),
            ],
        ];
    }
}
