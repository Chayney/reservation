<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Reservation;
use App\Mail\ReservationReminder;
use Illuminate\Support\Facades\Mail;

class Reminder extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'reminder:send';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $reservations = Reservation::whereDate('date', today())->get();
        foreach ($reservations as $reservation) {
            Mail::to($reservation->reserveUser->email)->send(new ReservationReminder($reservation));
        }
    }
}
