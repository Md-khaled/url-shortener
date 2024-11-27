# URL Shortener Service

A Laravel-based URL shortener service that converts long URLs into short, unique URLs. The short URLs redirect users to the original URLs and provide a list of generated short URLs.

---

## Features

- Accepts long URLs and generates short, unique URLs.
- Short URLs redirect users to their corresponding original URLs.
- Lists all generated short URLs.
- Supports configurable short URL length.
- Validates URLs to ensure correctness.
- Handles errors gracefully for invalid input and conflicts.

---

## Technologies

- **PHP**: ^8.2
- **Laravel Framework**: ^11.31
- **MySQL**: Used for storing URL mappings.

---

## Installation

1. Clone the repository:
    ```bash
    git clone https://github.com/Md-khaled/url-shortener.git
    cd url-shortener
    ```

2. Install dependencies:
    ```bash
    composer install
    ```

3. Set up environment variables:
    ```bash
    cp .env.example .env
    ```

4. Generate the application key:
    ```bash
    php artisan key:generate
    ```

5. Configure the database in `.env`:
    ```env
    DB_CONNECTION=mysql
    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_DATABASE=your_database_name
    DB_USERNAME=your_username
    DB_PASSWORD=your_password
    ```

6. Set `SHORT_CODE_LENGTH` in `.env`:
    - Example:
      ```env
      SHORT_CODE_LENGTH=6
      ```
      If left empty, the service will default to generating ULID-based short URLs.

7. Run migrations:
    ```bash
    php artisan migrate
    ```

8. Start the development server:
    ```bash
    php artisan serve
    ```

9. Access the application at:
    ```
    http://localhost:8000/api
    ```

---

## Routes

### 1. Create Short URL
**POST** `/shorten`

### 2. Redirect to Original URL
**GET** `/{shortCode}`

### 3. List All Short URLs
**GET** `/url/list`
