<?php

namespace App\DataScrapingStrategy;

use Symfony\Component\DomCrawler\Crawler;

class PdpJsonV4Strategy extends AbstractScrapingStrategy
{
    public function scrape(string $html, string $url): ?array
    {
        $crawler = new Crawler($html);

        // Extract <script> tags and find the one containing AMConfig.product
        $scripts = $crawler->filter('script')->each(function (Crawler $node) {
            $text = $node->text();
            if (str_contains($text, 'AMConfig.product')) {
                return $text;
            }
            return null;
        });

        $json = null;

        foreach ($scripts as $script) {
            if (!$script) continue;

            // Match AMConfig.product = {...};
            if (preg_match('/AMConfig\.product\s*=\s*(\{.*?\});/s', $script, $matches)) {
                $json = $matches[1];
                break;
            }
        }

        if (!$json) {
            return null;
        }

        $productData = json_decode($json, true);

        if (!$productData || !isset($productData['variants'])) {
            return null;
        }

        $inventory = array_sum(array_map(
            fn($v) => $v['inventory_quantity'] ?? 0,
            $productData['variants']
        ));

        return [
            'title' => $productData['title'] ?? 'Unknown',
            'handle' => $productData['handle'] ?? '',
            'variants' => $productData['variants'],
            'inventory' => $inventory,
        ];
    }

    public function getName(): string
    {
        return 'pdpjsonv4';
    }
}
