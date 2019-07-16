<?php

namespace App\Console\Commands;

use GuzzleHttp\Client;
use Illuminate\Console\Command;
use Symfony\Component\Yaml\Yaml;

class ImportMilestonesCommand extends Command
{
    private const ENDPOINT = 'https://api.github.com/repos/vavroom/a11y-audit/milestones';

    /** @var string */
    protected $signature = 'import:milestones';

    /** @var string */
    protected $description = 'Import milestones from a11y-audit repo';

    /** @var Client */
    private $client;

    /** @var Yaml */
    private $yaml;

    public function __construct(Client $client, Yaml $yaml)
    {
        parent::__construct();
        $this->client = $client;
        $this->yaml = $yaml;
    }

    public function handle() : void
    {
        $data = $this->client->request('get', self::ENDPOINT);

        $yaml = $this->yaml->dump(json_decode($data->getBody()->getContents(), true));

        file_put_contents(__DIR__ . '/../../../data/milestones.yml', $yaml);
    }
}
