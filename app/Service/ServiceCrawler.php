<?php

namespace App\Service;

use Illuminate\Support\Facades\Http;
use GuzzleHttp\Client;
use Symfony\Component\DomCrawler\Crawler;

/**
 * Web scraping service for extracting product information
 *
 * This class handles scraping products from the Oxylabs sandbox page
 * and structures the information into a usable format.
 */
class ServiceCrawler
{
    /**
     * Crawls products from the target URL
     *
     * Makes an HTTP request to the products page, parses the HTML,
     * and extracts relevant information from each product found on the page.
     *
     * @return array Array of products with their properties (title, price, image_url, description, category)
     */
    public function crawl(): array
    {
        // Create HTTP client to make requests
        $client = new Client();

        // Fetch the complete HTML from the products page
        $html = $client->get('https://sandbox.oxylabs.io/products')->getBody()->getContents();

        // Initialize Symfony crawler with the fetched HTML
        $crawler = new Crawler($html);

        // Array to store extracted products
        $products = [];


        // Iterate over each product card found on the page
        $crawler->filter('.product-card')->each(function (Crawler $node) use (&$products) {

            // Extract product title
            // If element doesn't exist, assign 'No title' as default
            $title = $node->filter('h4.title')->count() ? trim($node->filter('h4.title')->text()) : 'No title';

            // Extract price text
            $priceText = $node->filter('div.price-wrapper')->count() ? trim($node->filter('div.price-wrapper')->text()) : '0';

            // Clean price format: remove euro symbol and spaces
            $priceText = str_replace(['€', ' '], '', $priceText);
            
            // Convert decimal comma to dot for standard format
            $priceText = str_replace(',', '.', $priceText);
            
            // Convert to float number
            $price = (float) $priceText;

            // Extract product image URL
            $image = $node->filter('img.image')->count() ? $node->filter('img.image')->attr('src') : null;
            
            // If URL is relative, convert to absolute by adding base domain
            if ($image && !str_starts_with($image, 'http')) {
                $image = 'https://sandbox.oxylabs.io' . $image;
            }

            // Extract product description
            $description = $node->filter('p.description')->count() ? trim($node->filter('p.description')->text()) : null;

            // Extract all product categories
            $categories = [];
            if ($node->filter('p.category span')->count()) {
                $node->filter('p.category span')->each(function ($span) use (&$categories) {
                    $categories[] = trim($span->text());
                });
            }
            
            // Join categories into comma-separated string, or 'Uncategorized' if none exist
            $category = implode(', ', $categories) ?: 'Uncategorized';

            
            // Add structured product to products array
            $products[] = [
                'title' => $title,
                'price' => $price,
                'image_url' => $image,
                'description' => $description,
                'category' => $category,
            ];
        });

        // Return all extracted products
        return $products;
    }
}
