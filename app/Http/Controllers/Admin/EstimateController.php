<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Admin\Base\Crud;
use App\Models\Estimate as MainModel;
use Inertia\Inertia;
use App\Models\Project;


class EstimateController extends Crud
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
        
        // $config['detail']['hasMany']['tag'] = 'ul';

        return Inertia::render(static::viewDir(), [
            'configs' => static::configs(),
            'productConfigs' => config('blu.product'),
            'materialConfigs' => config('blu.material'),
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
