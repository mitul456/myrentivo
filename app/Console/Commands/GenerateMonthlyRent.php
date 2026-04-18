<?php

namespace App\Console\Commands;

use App\Models\Lease;
use App\Models\Payment;
use Carbon\Carbon;
use Illuminate\Console\Command;

class GenerateMonthlyRent extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'rent:generate';
    
    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate monthly rent for active leases';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $currentMonth = now()->startOfMonth();

        Lease::where('status', 'active')
            ->chunk(100, function ($leases) use ($currentMonth) {

                foreach ($leases as $lease) {

                    $exists = Payment::where('lease_id', $lease->id)
                        ->where('month', $currentMonth)
                        ->exists();

                    if (!$exists) {
                        Payment::create([
                            'user_id' => $lease->user_id,
                            'lease_id' => $lease->id,
                            'amount' => $lease->rent_amount,
                            'payment_date' => now(),
                            'month' => $currentMonth,
                            'status' => 'unpaid',
                        ]);
                    }
                }
            });

        return Command::SUCCESS;
    }
}
