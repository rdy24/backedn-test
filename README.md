## System Requirements

- PHP : v8.1
- MySQL : v8.0.30
- Framework : Laravel v10.10


## Installation
1. Clone github repository `git clone https://github.com/rdy24/backedn-test.git` or download zip
2. Install dependency, run composer install in terminal
   ```bash
    composer install
    ```
3. Copy .env.example to .env manually or using command in terminal
    ```bash
    copy .env.example .env
    ```
    or
    ```bash
    cp .env.example .env
    ```

4. Set your database in .env edit this line with your database configuration
   ```bash
    DB_PORT=3306
    DB_DATABASE=laravel
    DB_USERNAME=root
    DB_PASSWORD=
    ```

5. Generate App key
    ```bash
    php artisan key:generate
    ```

6. Migrate database and run seeder
    ```bash
    php artisan migrate --seed
    ```

7. Serve the application
    ```bash
    php artisan serve
    ```
8. Fetch province & city with command
   ```bash
    php artisan app:fetch-raja-ongkir-data
    ```

## Search Province & City
1. Endpoint search province
   ```bash
    localhost:8000/api/search/provinces?id=1
    ```
2. Endpoint search city
   ```bash
    localhost:8000/api/search/cities?id=1
    ```
