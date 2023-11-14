<?php

namespace App\Http\Middleware;

use Illuminate\Http\Request;
use Inertia\Middleware;

class HandleInertiaRequests extends Middleware
{
    /**
     * The root template that's loaded on the first page visit.
     *
     * @see https://inertiajs.com/server-side-setup#root-template
     * @var string
     */
    protected $rootView = 'app';

    /**
     * Determines the current asset version.
     *
     * @see https://inertiajs.com/asset-versioning
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */
    public function version(Request $request): ?string
    {
        return parent::version($request);
    }

    /**
     * Defines the props that are shared by default.
     *
     * @see https://inertiajs.com/shared-data
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function share(Request $request): array
    {
        /** @var User $user */
        $user = auth()->user();
        if(!empty($user)) {
            $azienda = $user->company()->first();
            $permissions = $user->allPermissions;
            $roles = $user->roles()->get();
            $locale = $user->lang;
        } else {
            $azienda = null;
            $permissions = [];
            $roles = [];
            $locale = "it";
        }

        return array_merge(parent::share($request), [
            "azienda" => $azienda,
            "permissions" => $permissions,
            "roles" => $roles,
            "locale" => $locale,
//            "tenant_logo" => app('currentTenant')->logo,
        ]);
    }
}
