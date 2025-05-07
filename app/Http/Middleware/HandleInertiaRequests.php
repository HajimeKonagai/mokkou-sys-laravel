<?php

namespace App\Http\Middleware;

use Illuminate\Http\Request;
use Inertia\Middleware;
use App\Models\Project;

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
            'mokkou' => config('mokkou'),
            'createdId' => $request->session()->get('createdId'),
            'project' => function () use ($request) {
                return Project::find($request->session()->get('project_id'));
            },
            'projectConfigs' => function () {
                $configs = config('blu.project');
                $customer_id_options = \App\Models\Customer::get()->pluck('name', 'id')->toArray();

                $configs['config']['customer_id']['options'] += $customer_id_options;
                $configs['config']['customer_id']['search']['customer_id']['options'] += $customer_id_options;

                return $configs;
            }
        ];
    }
}
