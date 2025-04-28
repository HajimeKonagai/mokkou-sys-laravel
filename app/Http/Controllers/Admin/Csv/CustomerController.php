<?php

namespace App\Http\Controllers\Admin\Csv;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;

use App\Models\Customer;

class CustomerController extends Controller
{
    public function __invoke($uniqid = null)
    {
        if (! $uniqid)
        {
            return redirect()->route('admin.csv.customer', ['uniqid' => uniqid()]);
        }

        return Inertia::render('Admin/Csv/Customer', [
            'customSetting' => [],
            'toFields' => config('blu.csv.customer'),
            'uniqid' => $uniqid,
        ]);
    }

    public function store(Request $request)
    {
        $live = $request->input('live', false);
        $create = $request->input('create', false); // create を許すかどうか
        $update = $request->input('update', false); // update を許すかどうか

        foreach ($request->posts as $index => $post)
        {


        }

    }

}