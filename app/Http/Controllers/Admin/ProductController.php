<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Admin\Base\Crud;
use App\Models\Product as MainModel;
use Inertia\Inertia;
use App\Models\Project;


class ProductController extends Crud
{
    protected static function configs()
    {
        $configs = parent::configs();
        return $configs;
    }

    public static function mainModel()
    {
        return MainModel::class;
    }

    public static function mainModelWith()
    {
        return [];
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
        $createConfigs['config']['product_material']['hasMany']['tag'] = 'ul';
        $editConfigs = $createConfigs;
        $indexConfigs = static::configs();

        return Inertia::render(static::viewDir(), [
            'configs' => static::configs(),
            'materialConfigs' => config('blu.material'),

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
