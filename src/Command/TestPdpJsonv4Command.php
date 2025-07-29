<?php

namespace App\Command;

use App\DataScrapingStrategy\PdpJsonV4Strategy;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

#[AsCommand(
    name: 'test:pdpjsonv4',
    description: 'Test the PdpJsonV4 scraping strategy for mintandlily.com',
)]
class TestPdpJsonv4Command extends Command
{
    public function __construct(
        private readonly HttpClientInterface $httpClient
    ) {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $url = 'https://mintandlily.com/products/433-beaded-bracelet-stack?variant=40833413775433'; // You can change this to any live product URL
        $response = $this->httpClient->request('GET', $url);
       
        $html = $response->getContent();
      
        $strategy = new PdpJsonV4Strategy();
        $result = $strategy->scrape($html, $url);

        if ($result === null) {
            $output->writeln('<error>Scraping failed.</error>');
        } else {
            $output->writeln('<info>Scraped data:</info>');
            $output->writeln(json_encode($result, JSON_PRETTY_PRINT));
        }

        return Command::SUCCESS;
    }
}
