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
        return ['detail', 'detail.user', 'detail.product'];
    }

    public function index(Request $reqeust)
    {
        return static::_index($reqeust);
    }

    public function show(Request $request, MainModel $id)
    {
        return static::_show($request, $id);
    }

    public function create(Request $request)
    {
        $config = static::config();
        $config['detail']['hasMany']['tag'] = 'ul';
        return Inertia::render(static::viewDir().'Create', [
            'config' => $config,
            'formConfig' => static::formConfig(),

            'projectConfigs' => config('blu.project'),
            'productConfigs' => config('blu.product'),
            'userConfigs' => config('blu.user'),
        ]);
    }

    public function edit(Request $request, MainModel $id)
    {
        $id->load(static::mainModelWith());
        $config = static::config();
        $config['detail']['hasMany']['tag'] = 'ul';
        return Inertia::render(static::viewDir().'Edit', [
            'config' => $config,
            'formConfig' => static::formConfig(),
            'item' => $id,

            'projectConfigs' => config('blu.project'),
            'productConfigs' => config('blu.product'),
            'userConfigs' => config('blu.user'),
        ]);
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
