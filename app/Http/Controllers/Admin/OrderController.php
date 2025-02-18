<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Admin\Base\Crud;
use App\Models\Order as MainModel;
use App\Models\Product;


class OrderController extends Crud
{
    protected static function configs()
    {
        $configs = parent::configs();
        $product_options = Product::query()->with('user')->get()->toArray();
        $configs['config']['detail']['hasMany']['config']['product']['options'] += $product_options;

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
        return static::_create($request);
    }

    public function edit(Request $request, MainModel $id)
    {
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

    public function destroy(MainModel $id)
    {
        return static::_destroy($id);
    }



    /**
     * API
     */

}
