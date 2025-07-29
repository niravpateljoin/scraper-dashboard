# 🕷️ Data Scraping System

This Symfony project supports multiple web scraping strategies, including Shopify product scrapers. One of the strategies implemented is `pdpjsonv4`, specifically designed to scrape product data from Shopify-based product pages like **mintandlily.com**.

---

## 📁 Directory Structure

```
src/
├── DataScrapingStrategy/
│   ├── AbstractScrapingStrategy.php
│   └── PdpJsonV4Strategy.php
├── Command/
│   └── TestPdpJsonv4Command.php
├── ScrapingStrategy/
│   └── ScrapingStrategyResolver.php
```

---

## 🧰 Requirements

Make sure the following dependencies are installed in your Symfony project:

```bash
composer require symfony/dom-crawler symfony/http-client
```

---

## 🛠️ Strategy: `pdpjsonv4`

### 🔍 What it does

The `pdpjsonv4` strategy scrapes product page content by:

- Searching for the JavaScript block containing `AMConfig.product = {...}`
- Parsing that JSON to extract:
  - Product title
  - Product handle
  - Variants
  - Inventory quantity (from `_AM.variants`)

It is designed to work with Shopify pages structured similarly to [mintandlily.com](https://mintandlily.com).

---

## ▶️ Running Locally

### 1. Clone the repo and set up the environment:

```bash
git clone https://github.com/niravpateljoin/scraper-dashboard.git
cd scraper-dashboard
composer install
```

### 2. Switch to your feature branch:

> ⚠️ Branch naming convention:  
> Use: `yourgithubusername-taskname`  
> Example:  
> `niravpateljoin-pdpjsonv4`

```bash
git checkout -b niravpateljoin-pdpjsonv4
```

### 3. Run the test command:

```bash
php bin/console test:pdpjsonv4
```

This command is defined in `src/Command/TestPdpJsonv4Command.php`.

---

## 🧪 Example Output

```json
{
  "title": "Personalized Name Ring",
  "handle": "personalized-name-ring",
  "variants": [
    {
      "id": 12345,
      "title": "Silver / 6"
    }
  ],
  "inventory": 42
}
```