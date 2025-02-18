<?php

namespace App\Console\Commands\Dev;

use Illuminate\Console\Command;

use App\Models\Product;
use App\Models\User;
use App\Models\Order;
use App\Models\OrderDetail;

use Illuminate\Support\Facades\Hash;

class CreateDemoData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'dev:create-demo-data';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        Product::truncate();
        Order::truncate();
        OrderDetail::truncate();

        $demo_data = config('swagger.demo_data');

        foreach ($demo_data['user'] as $user)
        {
            User::create([
                'name' =>  $user['name'],
                'email' => uniqid().'@example.com',
                'password' => Hash::make('12121212'),
                'is_admin' => false,
            ]);
        }

        foreach ($demo_data['product'] as $product)
        {
            \Blu\Save::saveTransaction(collect($product), new Product, config('blu.product.config'), $useDefault = true);
        }

        foreach ($demo_data['order'] as $order)
        {
            \Blu\Save::saveTransaction(collect($order), new Order, config('blu.order.config'), $useDefault = true);
        }

        //
    }
}
