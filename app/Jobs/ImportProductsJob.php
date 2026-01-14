<?php

namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use App\Models\Product;
use App\Services\ServiceCrawler as CrawlerService;

/**
 * Job for importing products into the database
 *
 * This job is queued and processes a batch of product data,
 * creating or updating products and their associated images in the database.
 * Implements ShouldQueue for asynchronous processing.
 */
class ImportProductsJob implements ShouldQueue
{
    use Queueable;

    /**
     * Number of times the job may be attempted
     *
     * @var int
     */
    public $tries = 3;

    /**
     * Array of product data to import
     *
     * @var array
     */
    private array $products;

    /**
     * Create a new job instance
     *
     * @param array $products Array of product data with keys: title, price, description, category, image_url
     */
    public function __construct(array $products)
    {
        $this->products = $products;
    }

    /**
     * Execute the job
     *
     * Processes each product in the batch:
     * - Creates or updates the product based on title (unique identifier)
     * - Creates associated image record if image URL is provided
     *
     * @return void
     */
    public function handle(): void
    {
        // Process each product in the batch
        foreach ($this->products as $data) {

            // Create or update product using title as unique identifier
            // If product with same title exists, updates its data; otherwise creates new one
            $product = Product::updateOrCreate(
                ['title' => $data['title']],
                [
                    'price' => $data['price'],
                    'description' => $data['description'],
                    'category' => $data['category'],
                ]
            );

            
            // Create image record if URL is provided
            if (!empty($data['image_url'])) {
                $product->images()->create([
                    'url' => $data['image_url'],
                ]);
            }
        }
    }
}
