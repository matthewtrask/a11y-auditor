<?php

namespace App\Console\Commands;

use App\Repository\RepositoryManager;
use Illuminate\Console\Command;

class GetRepositoriesCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'github:repositories';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Get Github Repositories for user';

    /** @var RepositoryManager */
    private $manager;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(RepositoryManager $manager)
    {
        parent::__construct();
        $this->manager = $manager;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->manager->getRepositories();
    }
}
