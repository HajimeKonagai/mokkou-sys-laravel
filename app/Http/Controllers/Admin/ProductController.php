<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Admin\Base\Crud;
use App\Models\Product as MainModel;
use App\Models\Product;
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

        return Inertia::render(static::viewDir(), [
            'configs' => static::configs(),
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
