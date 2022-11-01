# QLS Labels Assessment
This project interacts with the QLS API. 

## Features
* Fetch shipping products.
* Create shipping labels.
* Create packing slips.

## Requirements
* Docker (for Laravel Sail).

## Running locally
1. Clone the repo.
2. Run `./vendor/bin/sail up -d` in the root directory.
3. Run `npm install && npm  run dev` also in the root directory.
4. run `php artisan migrate:refresh --seed` to create the database and seed it with dummy data.