# Laravel Web Scraper – Product Catalog

A Laravel-based web scraping and product catalog system that extracts product data from a remote e-commerce website and stores it in a structured database with a clean frontend interface.


This project demonstrates backend automation, HTML parsing, data persistence, and frontend rendering using modern Laravel tooling.

## 🚀 Features

**Scrapes product data from an external website**

Extracts:
- Title
- Category
- Description
- Image
- Price


**Stores all products in a MySQL database**

**Displays products in a responsive UI**

**Fully automated via Artisan command**

**Clean MVC architecture**

## 🧱 Tech Stack

| Layer | Technology |
|-------|-----------|
| Backend | Laravel 12 |
| Scraping | Symfony DomCrawler |
| HTTP | Laravel HTTP Client |
| Database | MySQL |
| Frontend | Blade + Tailwind |
| Components | Livewire |
| Build Tool | Vite |

## 📂 Project Structure

```
app/
 ├── Models/Product.php
 ├── Models/Image.php
 ├── Console/Commands/ScrapeProducts.php
 ├── Jobs/ImportProductJob.php
 ├── Service/ServiceCrawler.php
resources/
 ├── views/products.blade.php
 ├── views/components/layouts/app.blade.php
database/
 ├── migrations/create_products_table.php
 ├── migrations/create_images_table.php
routes/
 ├── web.php
```

## 🛠 Installation

```bash
git clone https://github.com/yuby41/Laravel-web-scraping.git
cd Laravel-web-scraping
composer install
cp .env.example .env
php artisan key:generate
```

**Configure database in .env**

```bash
php artisan migrate
npm install
npm run build
php artisan serve
```

## 🕷 Run the Scraper

```bash
php artisan crawl:products
```

This will fetch products from the remote website and store them in the database.

## 🌐 View Products

Open:

```
http://localhost:8000/view/products
```

## 📸 Sample Output

Each product card shows:
- Product image
- Title
- Category
- Rating
- Description
- Price
- Stock status

All data is dynamically scraped and stored.

## 🎯 Purpose

This project was built as a portfolio project to demonstrate:
- Web scraping
- Data normalization
- Laravel backend development
- Frontend rendering
- Real-world automation

## 👤 Author

**Yualbert Luis**
Backend Developer – Laravel & PHP
GitHub: [https://github.com/yuby41](https://github.com/yuby41)
