<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Admin\Base\Crud;
use App\Models\Project as MainModel;
use Inertia\Inertia;

use App\Models\Customer;

class ProjectController extends Crud
{

    protected static function configs()
    {
        $configs = parent::configs();
        $customer_id_options = Customer::get()->pluck('name', 'id')->toArray();

        $configs['config']['customer_id']['options'] += $customer_id_options;
        $configs['config']['customer_id']['search']['customer_id']['options'] += $customer_id_options;

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

        return Inertia::render(static::viewDir(), [
            'configs' => static::configs(),
            'orderConfigs' => config('blu.order'),
        ]);
    }

    public function show(Request $request, MainModel $id)
    {
        $id->load( ['order', 'order.detail'] )
            ->append('total_price');
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

    public function to_task(Request $request, MainModel $project)
    {
        $request->session()->put('project_id', $project->id);
        
        return redirect()
            ->route('admin.task');
    }
}
