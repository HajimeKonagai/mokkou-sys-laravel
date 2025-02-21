<?php

namespace App\Http\Controllers\Supplier;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\OrderDetail;

class DashboardController extends Controller
{
    protected static $perPage = 25;

    public function __invoke(Request $request)
    {
        if ($request->expectsJson())
        {
            $query = OrderDetail::supplier();

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

    public function store(Request $request, OrderDetail $orderDetail)
    {
        if (!strtotime($request->input('delivery_at')))
        {
            return back()->with('error', '妥当な日付ではありません');
        }

        $orderDetail->delivery_at = date('Y-m-d', strtotime($request->input('delivery_at')));
        $orderDetail->save();


        return back()->with('success', '納期を設定しました。');
    }
}
