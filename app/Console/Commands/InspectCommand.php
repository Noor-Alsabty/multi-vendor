<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class InspectCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:inspect-command';

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
        $o = \App\Models\Order::latest()->first();
        echo 'order:' . ($o ? $o->id : 'none') . "\n";
        if ($o) {
            foreach ($o->items as $i) {
                echo 'item ' . $i->id . ' variant ' . $i->variant_id . ' price ' . $i->price . ' qty ' . $i->quantity . ' vendor ' . ($i->variant->product->vendor->id ?? 'no-vendor') . " wallet:" . (($i->variant->product->vendor->wallet->id ?? 'no-wallet') . ' bal:' . ($i->variant->product->vendor->wallet->balance ?? 'na')) . "\n";
            }
        }

        $siteWallet = \App\Models\Wallet::whereHas('vendor', function($q){ $q->where('commission_rate', 1.0); })->first();
        echo 'site wallet: ' . ($siteWallet ? $siteWallet->id . ' bal:' . $siteWallet->balance : 'none') . "\n";
    }
}
