<?php

namespace App\DataScrapingStrategy;

abstract class AbstractScrapingStrategy
{
    /**
     * Scrapes product data from HTML
     */
    abstract public function scrape(string $html, string $url): ?array;

    /**
     * Returns the name of the strategy
     */
    abstract public function getName(): string;
}
