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

@Windows
```bash
composer migration-tokens-win
composer migration-tasks-win
composer migration-users-win
```
@LInux
```bash
composer migration-users
composer migration-tasks
composer migration-tokens
```

## Request methods

### User

| Method | Endpoint  | Description |
| ------ |-----------| ------ |
| POST | /register | Create a new user |
| POST | /login    | Login user |

In Register use this JSON format:

```json
{
    "name": "Sophie Calixto",
    "email": "sophiecalixto2004@gmail.com",
    "password": "123456"
}
```

![img.png](project-images/img.png)