<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Admin\Base\Crud;
use App\Models\Order as MainModel;
use Inertia\Inertia;
use App\Models\Project;


class OrderController extends Crud
{
    protected static function configs()
    {
        $configs = parent::configs();
        $project_options = Project::query()->get()->toArray();
        $configs['config']['project']['options'] += $project_options;

        $configs['config']['status']['search']['status']['options'] += config('mokkou.order_status');

        return $configs;
    }

    public static function mainModel()
    {
        return MainModel::class;
    }

    public static function mainModelWith()
    {
        return ['detail', 'detail.user', 'detail.material'];
    }

    public function __invoke(Request $request)
    {
        $mainModel = static::mainModel();
        $query = $mainModel::query();
        $query->with(static::mainModelWith());

        if ($request->expectsJson())
        {
            return \Blu\Query::itemsByRequest(
                $request,
                static::config(),
                $query,
                static::$perPage
            );
        }
        
        $createConfigs = static::configs();
        $createConfigs['config']['detail']['hasMany']['tag'] = 'ul';
        $editConfigs = $createConfigs;
        $indexConfigs = static::configs();
        foreach ([
            'code',
            'material',
            'user',
        ] as $hidden)
        {
            $indexConfigs['config']['detail']['hasMany']['config'][$hidden]['type'] = 'hidden';
        }

        return Inertia::render(static::viewDir(), [
            'configs' => static::configs(),
            'projectConfigs' => config('blu.project'),
            'materialConfigs' => config('blu.material'),
            'userConfigs' => config('blu.user'),

            'createConfigs' => $createConfigs,
            'editConfigs' => $editConfigs,
            'indexConfigs' => $indexConfigs,
        ]);

    }

    public function show(Request $request, MainModel $id)
    {
        return static::_show($request, $id);
    }

    public function store(Request $request)
    {
        return static::_store($request);
    }

    public function update(Request $request, MainModel $id)
    {
        return static::_update($request, $id);
        
    }

    public function destroy(Request $request, MainModel $id)
    {
        return static::_destroy($request, $id);
    }
}
