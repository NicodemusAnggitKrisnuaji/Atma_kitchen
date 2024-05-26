<?php
use Illuminate\Console\Command;
use App\Models\Produk;

class ResetQuota extends Command
{
    protected $signature = 'quota:reset';
    protected $description = 'Reset product quotas daily';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        Produk::query()->update(['quota' => 10]); // Reset quota to 10 for all products
        $this->info('Product quotas have been reset.');
    }
}