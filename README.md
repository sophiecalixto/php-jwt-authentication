Study project using JWT authentication with Pure PHP

<img src="https://img.shields.io/static/v1?label=PHP&message=8.3&color=blue&style=for-the-badge&logo=php"/> <img src="https://img.shields.io/static/v1?label=JWT&message=4.1.0&color=blue&style=for-the-badge&logo=JSON+Web+Tokens"/>

## Installation

```bash
git clone https://github.com/sophiecalixto/php-jwt-authentication.git
composer install
```

## Usage

```bash
php -S localhost:8000 -t public/
```

> If you using postgresql, you can use migrations to create tables

```bash
composer migration-users
composer migration-tasks
```