<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Service\ServiceCrawler as CrawlerService;
use App\Jobs\ImportProductsJob;

/**
 * Artisan command to crawl products and queue them for import
 *
 * This command scrapes products from the target website and dispatches
 * a job to import them into the database asynchronously.
 * Can be executed via: php artisan crawl:products
 */
class CrawlerProducts extends Command
{
    /**
     * The name and signature of the console command
     *
     * Command syntax: crawl:products
     *
     * @var string
     */
    protected $signature = 'crawl:products';

    /**
     * The console command description
     *
     * Displayed when running: php artisan list
     *
     * @var string
     */
    protected $description = 'Scans products and queues them for import';

    /**
     * Execute the console command
     *
     * Workflow:
     * 1. Instantiates the crawler service
     * 2. Crawls products from the target website
     * 3. Dispatches an ImportProductsJob to process the data asynchronously
     * 4. Provides feedback on the number of products found
     *
     * @param CrawlerService $crawlerService The service responsible for web scraping
     * @return void
     */
    public function handle(CrawlerService $crawlerService)
    {
        // Display start message to user
        $this->info('Starting product scan...');

        // Initialize crawler service and fetch products
        $crawler = new CrawlerService();
        $products = $crawler->crawl();
        $count = count($products);

        
        // Dispatch job to queue for asynchronous processing
        ImportProductsJob::dispatch($products);

        // Display success message with count
        $this->info("$count products found. Queued for import...");
    }
}
