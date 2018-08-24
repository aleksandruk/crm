<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Http\Controllers\Admin\DispositionsController;

class DispositionsUpdate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'dispositions:update';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update list of dispositions from Falcone DB';

    private $create;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(DispositionsController $create)
    {
        parent::__construct();
        $this->create = $create;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->create->create();
    }
}
