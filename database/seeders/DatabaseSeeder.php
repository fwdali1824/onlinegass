<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash; 
use Spatie\Permission\Models\Permission;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::create([
            'name' => 'Admin',
            'email' => 'admin@email.com',
            'password' => Hash::make('admin@123'),
            'role' => "admin",
        ]);

        



        //   $permissions = [
        //     'fcmGenerate',
        //     'store.fcm.token',
        //     'send.notification',
        //     'index',
        //     'about',
        //     'services',
        //     'contact',
        //     'shop',
        //     'cart',
        //     'checkout',
        //     'single.Product',
        //     'single.Product.checkout',
        //     'checkout.store',
        //     'shop.store',
        //     'user.forget.password',
        //     'user.login',
        //     'user.register',
        //     'user.dashboard',
        //     'user.orders',
        //     'user.wallet',
        //     'user.track.order',
        //     'user.profile',
        //     'user.referal',
        //     'user.notification',
        //     'user.chat',
        //     'users.pos',
        //     'user.pos.invoice',
        //     'users.orders.list.pending',
        //     'users.orders.list.progress',
        //     'users.orders.list.complete',
        //     'login',
        //     'logout',
        //     'user.logout',
        //     'admin.dashboard',
        //     'admin.stock.purchase',
        //     'admin.customers',
        //     'admin.notification',
        //     'notifications.store',
        //     'admin.sales.reports',
        //     'admin.sales.purchase.reports',
        //     'admin.sales.profit.reports',
        //     'admin.sales.customer.reports',
        //     'admin.sales.daily.reports',
        //     'sales.export',
        //     'sales.purchase.export',
        //     'sales.daily.export',
        //     'sales.orderreport.export',
        //     'admin.create.employee',
        //     'admin.edit.employee',
        //     'admin.employee',
        //     'admin.product.category',
        //     'admin.list.product',
        //     'admin.manage.role',
        //     'admin.add.role',
        //     'admin.manage.chat',
        //     'admin.manage.shops',
        //     'admin.manage.shops.create',
        //     'admin.manage.shops.update',
        //     'delivery.dashboard',
        //     'delivery.order.orderlist',
        //     'delivery.profile',
        //     'delivery.track',
        //     'sales.dashboard',
        //     'sales.orderList',
        //     'sales.reports',
        //     'sales.profile',
        // ];

        foreach ($permissions as $name) {
            Permission::firstOrCreate([
                'name' => $name,
                'guard_name' => 'web',
            ]);
        }

        $this->command->info(count($permissions) . ' permissions inserted.');

    }
}
