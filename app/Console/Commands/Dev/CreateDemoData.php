<?php

namespace App\Console\Commands\Dev;

use Illuminate\Console\Command;

use App\Models\Material;
use App\Models\Project;
use App\Models\User;
use App\Models\Customer;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Product;

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
        Material::truncate();
        Order::truncate();
        OrderDetail::truncate();

        $demo_data = config('swagger.demo_data');

        foreach ($demo_data['user'] as $user)
        {
            User::create([
                'name' =>  $user['name'],
                'email' => $user['email'],
                'password' => Hash::make('12121212'),
                'is_admin' => false,
            ]);
        }

        foreach ($demo_data['material'] as $material)
        {
            \Blu\Save::saveTransaction(collect($material), new Material, config('blu.material.config'), $useDefault = true);
        }

        foreach ($demo_data['customer'] as $customer)
        {
            \Blu\Save::saveTransaction(collect($customer), new Customer, config('blu.customer.config'), $useDefault = true);
        }

        foreach ($demo_data['project'] as $project)
        {
            \Blu\Save::saveTransaction(collect($project), new Project, config('blu.project.config'), $useDefault = true);
        }

        foreach ($demo_data['order'] as $order)
        {
            \Blu\Save::saveTransaction(collect($order), new Order, config('blu.order.config'), $useDefault = true);
        }

        foreach ($demo_data['product'] as $product)
        {
            \Blu\Save::saveTransaction(collect($product), new Product, config('blu.product.config'), $useDefault = true);
        }

        //
    }
}
