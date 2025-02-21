<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Order;
use App\Models\OrderDetail;

use App\Mail\Order\OrderMail;
use App\Mail\Order\CancelMail;

use App\Events\OrderEvent;

class OrderProcessController extends Controller
{
    public function order(Order $order)
    {
        if ($order->status != 0) // 未発注でない
        {
            return back()->with('error', '未発注の発注ではありません。');
        }

        $ordered_at =  date('Y-m-d H:i:s');

        $mailParams = static::mailParams($order, $ordered_at);
        // ユーザーが設定されていないものがないか
        if (!$mailParams)
        {
            return back()->with('error', '仕入れ先が未設定のアイテムがあります。');
        }


        // メールを送る
        foreach ($mailParams as $user_id => $mailParam)
        {
            \Mail::to($mailParam['user']->email)->send(new OrderMail($mailParam));

            event(new OrderEvent('success', '発注がありました。', $mailParam['order'], $mailParam['user']));
        }

        $order->status = 1; // 発注済
        $order->ordered_at = $ordered_at;
        $order->save();

        return back()->with('success', '発注しました。');
    }

    public function cancel(Order $order)
    {
        if ($order->status != 1) // 発注済でない
        {
            return back()->with('error', '発注済の発注ではありません。');
        }

        $ordered_at = date('Y-m-d H:i:s', strtotime($order->ordered_at));

        $mailParams = static::mailParams($order, $ordered_at);
        // ユーザーが設定されていないものがないか
        if (!$mailParams)
        {
            return back()->with('error', '仕入れ先が未設定のアイテムがあります。');
        }

        // メールを送る
        foreach ($mailParams as $user_id => $mailParam)
        {
            \Mail::to($mailParam['user']->email)->send(new CancelMail($mailParam));
            event(new OrderEvent('warning', '発注がキャンセルされました。', $mailParam['order'], $mailParam['user']));
        }

        $order->status = 0; // 未発注
        $order->ordered_at = null;
        $order->save();

        return back()->with('warning', '発注をキャンセルしました。');
    }



    public function delivered(Order $order)
    {
        \Log::info('delivered');
        if ($order->status != 1) // 発注済でない
        {
            return back()->with('error', '発注済の発注ではありません。');
        }

        $ordered_at = date('Y-m-d H:i:s', strtotime($order->ordered_at));
        $mailParams = static::mailParams($order, $ordered_at);
        // ユーザーが設定されていないものがないか
        if (!$mailParams)
        {
            return back()->with('error', '仕入れ先が未設定のアイテムがあります。');
        }

        // 通知のみ送る
        foreach ($mailParams as $user_id => $mailParam)
        {
            event(new OrderEvent('success', '納品が確認されました。', $mailParam['order'], $mailParam['user']));
        }

        $order->status = 2; // 納品済
        $order->save();

        return back()->with('success', '納品済にしました。');
    }


    protected static function mailParams(Order $order, $ordered_at)
    {
        foreach ($order->detail as $detail)
        {
            if (!$detail->user)
            {
                return null; // error
            }
        }

        $mailParams = [];
        // ユーザー毎に detail を分ける
        foreach ($order->detail as $detail)
        {
            if (!isset($detailsByUser[$detail->user->id]))
            {
                $mailParams[$detail->user->id] = [
                    'order' => $order,
                    'ordered_at' => $ordered_at,
                    'user' => $detail->user,
                    'detail' => []
                ];
            }

            $mailParams[$detail->user->id]['detail'][] = $detail;
        }
        return $mailParams;
    }

}
