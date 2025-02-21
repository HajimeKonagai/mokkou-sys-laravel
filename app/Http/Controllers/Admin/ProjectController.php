<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Admin\Base\Crud;
use App\Models\Project as MainModel;
use Inertia\Inertia;

use App\Models\User;

class ProjectController extends Crud
{
    public static function mainModel()
    {
        return MainModel::class;
    }

    public static function mainModelWith()
    {
        return [];
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

    public function destroy(Request $request, MainModel $id)
    {
        return static::_destroy($request, $id);
    }
}
