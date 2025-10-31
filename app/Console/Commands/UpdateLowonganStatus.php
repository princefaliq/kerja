<?php

namespace App\Console\Commands;

use App\Models\Lowongan;
use Carbon\Carbon;
use Illuminate\Console\Command;

class UpdateLowonganStatus extends Command
{

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'lowongan:update-status';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update status lowongan jika batas lamaran sudah lewat';

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
        $now = Carbon::now();
        Lowongan::where('batas_lamaran', '<', $now)->update(['status' => false]);

        $this->info('Status lowongan diperbarui.');
    }
}
