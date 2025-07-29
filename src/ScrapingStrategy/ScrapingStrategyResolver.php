<?php

use App\DataScrapingStrategy\PdpJsonV4Strategy;

$this->strategies = [
    new JsonLDStrategy(),
    new HtmlStrategy(),
    // ✅ Add your new one:
    new PdpJsonV4Strategy(),
];
