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
9. Before use endpoint search make sure config at .env is rajaongkir or database
   ```bash
    SEARCH_PROVIDER=rajaongkir
    ```

## Login
1. Login using account from seeder
   ```bash
    email : user@gmail.com
    password : password
    ```
2. Hit endpoint for login with body email and password
   ```bash
    localhost:8000/api/login
    ```
3. After logging in, save the access token to use when searching for a province or city

## Search Province & City
1. Endpoint search province
   ```bash
    localhost:8000/api/search/provinces?id=1
    ```
2. Endpoint search city
   ```bash
    localhost:8000/api/search/cities?id=1
    ```
3. Make sure the access token from the login has been entered into the authorization bearer header

## Test
To run the feature test use this command
```bash
php artisan test --testsuite=Feature --stop-on-failure
```
