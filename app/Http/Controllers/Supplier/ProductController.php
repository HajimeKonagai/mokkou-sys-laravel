<?php

namespace App\Http\Controllers\Supplier;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Product;

class ProductController extends Controller
{
    protected static $perPage = 25;

    public function __invoke(Request $request)
    {
        if ($request->expectsJson())
        {
            $query = Product::query();

            return \Blu\Query::itemsByRequest(
                $request,
                config('blu.order_detail.config'),
                $query,
                static::$perPage
            );
        }

        // assign
        return Inertia::render('Supplier/Dashboard', [
            'configs' => config('blu.order_detail')
        ]);
    }

    public function store(Request $request, Product $item)
    {
        if (!is_numeric($request->input('price')))
        {
            return back()->withErrors('単価を入力してください');
        }
        if (!strtotime($request->input('delivery_at')))
        {
            return back()->withErrors('error', '妥当な日付ではありません');
        }

        $orderDetail->price = $request->input('price');
        $orderDetail->delivery_at = date('Y-m-d', strtotime($request->input('delivery_at')));
        $orderDetail->save();


        return back()->with('success', '単価・納期を設定しました。');
    }
}
