<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Admin\Base\Crud;
use App\Models\Material as MainModel;
use App\Http\Requests\MaterialRequest;
use App\Models\Material;
use Inertia\Inertia;

use App\Models\User;

class MaterialController extends Crud
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

    public function show(Request $request, MainModel $id)
    {
        return static::_show($request, $id);
    }

    public function store(MaterialRequest $request)
    {
        return static::_store($request);
    }

    public function update(MaterialRequest $request, MainModel $id)
    {
        return static::_update($request, $id);
        
    }

    public function destroy(Request $request, MainModel $id)
    {
        return static::_destroy($request, $id);
    }
}
