<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use App\Models\OrderDetail;
use Illuminate\Console\Command;

class DeleteUnpaidOrders extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:delete-unpaid-orders';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Delete unpaid orders older than two days';

    /**
     * Execute the console command.
     */
    // public function handle()
    // {
    //     $date = Carbon::now()->subDays(2);

    //     // Fetch unpaid orders older than two days
    //     $unpaidOrders = OrderDetail::where('payment_status', '!=', 'paid')
    //         ->where('created_at', '<', $date)
    //         ->with(['orderItems'])
    //         ->get();

    //     foreach ($unpaidOrders as $order) {
    //         // Delete order items
    //         foreach ($order->orderItems as $orderItem) {
    //             $orderItem->delete();
    //         }
    //     }

    //     $this->info('Unpaid orders older than two days have been deleted successfully.');
    // }
}
