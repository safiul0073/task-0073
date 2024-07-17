<?php

namespace App\Console\Commands;

use App\Jobs\SendBirthdayEmailJob;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Console\Command;

class SendBirthdayEmails extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'emails:send-birthday';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send birthday emails to users';

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $today = Carbon::today()->format('m-d');
        $users = User::whereRaw('DATE_FORMAT(birthday, "%m-%d") = ?', [$today])->get();
        foreach ($users as $user) {
            SendBirthdayEmailJob::dispatch($user);
        }

        $this->info('Birthday emails dispatched.');
    }
}
