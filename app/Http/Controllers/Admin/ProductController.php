<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Admin\Base\Crud;
use App\Models\Product as MainModel;
use Inertia\Inertia;

use App\Models\User;

class ProductController extends Crud
{
    protected static function configs()
    {
        $configs = parent::configs();
        $user_options = User::supplier()->get()->toArray();

        $configs['config']['user']['options'] = $user_options;

        return $configs;
    }


    public static function mainModel()
    {
        return MainModel::class;
    }

    public static function mainModelWith()
    {
        return ['user'];
    }

    public function index(Request $request)
    {
        return static::_index($request);
    }

    public function show(Request $request, MainModel $id)
    {
        return static::_show($request, $id);
    }

    public function create(Request $request)
    {
        return Inertia::render(static::viewDir().'Create', [
            'config' => static::config(),
            'formConfig' => static::formConfig(),
            'userConfigs' => config('blu.user'),
        ]);
        return static::_create($request);
    }

    public function edit(Request $request, MainModel $id)
    {
        return Inertia::render(static::viewDir().'Edit', [
            'config' => static::config(),
            'formConfig' => static::formConfig(),
            'item' => $id,
            'userConfigs' => config('blu.user'),
        ]);
        return static::_edit($request, $id);
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
