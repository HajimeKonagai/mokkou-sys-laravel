<?php

namespace App\Http\Controllers\Admin\Csv;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\User;

class UserController extends Controller
{
    public function __invoke()
    {
        return Inertia::render('Admin/Csv/Customer', [
            'customSetting' => [],
            'toFields' => config('blu.csv.customer'),
        ]);
    }

    public function store(Request $request)
    {
        $live = $request->input('live', false);
        // $create = $request->input('create', false); // create を許すかどうか
        // $update = $request->input('update', false); // update を許すかどうか

        $results = [];

        foreach ($request->posts as $index => $post)
        {
            $is_update = false;
            $result = []; // [ 'message' => [], 'warning' => [], 'error' => [], 'posts' => [], ];
            // save transaction
            try
            {
                if ($live) \DB::beginTransaction();

                // TODO: 仮の Primary key
                $item = Customer::where('name', \Arr::get($post, 'fields.name', false))
                    ->first();
                \Log::info($item);
                $is_update = $item ? true : false;

                if ($live)
                {
                    if (!$item) $item = new Customer;
                    foreach ($post['fields'] as $field => $value)
                    {
                        $item->{$field} = $value;
                    }

                    $item->save();
                    $result[] = ['success', $is_update ? '【更新】しました' : '新規作成しました'];
                    \DB::commit();
                }
                else
                {
                    $result[] = ['success', $is_update ? '【更新】します': '新規作成します'];
                }
            }
            catch (\Throwable $e)
            {
                if ($live)
                {
                    \DB::rollBack();
                }
                $result[] = ['error', $e->getMessage()];
            }

            $results[$index] = $result;

        }
        return $results;
    }
}
