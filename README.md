# Slim assignment

The project to demonstrate how to integrate Doctrine 2.x, develop rest api and jwt authentication into Slim. The project created under the guideline 
of Slim official documentation [Using Doctrine with Slim].

## Requirements

- PHP 8.1+
- PHP SQLite extension
- [Composer] 2.4+

## Overview

The slim_assignment project is a small REST API that allows its authorize clients to
create and retrieve lists of movies.

- GET /movies    -> Retrieves a list of all movies created.
- GET /movies/{uuid}    -> Retrieves the specific movie against given uuid.
- POST /movies   -> Creates a new movie (name, casts, release_date, director, ratings).

At its core, Doctrine's `EntityManager` is used to persist and retrieve these
users from an SQLite database.

## Project structure

```
slim_assignment
│
├── config
│   └── bootstrap.php         -- HTTP front controller (requires ../bootstrap.php)
│   └── contaoner.php         -- HTTP front controller (requires ../bootstrap.php)
│   └── dependencies.php      -- HTTP front controller (requires ../bootstrap.php)
│   └── middleware.php        -- HTTP front controller (requires ../bootstrap.php)
│   └── routes.php            -- HTTP front controller (requires ../bootstrap.php)
│   └── setting.php           -- HTTP front controller (requires ../bootstrap.php)
│
├── public
│   └── index.php           -- HTTP front controller (requires ../bootstrap.php)
│   └── .htaccess           -- Redirection file
│
├── src
│   ├── Action              -- Slim request handlers
│   │   ├── CreateMovie.php
│   │   └── ListMovie.php
│   │   └── LoginAction.php
│   └── Model              -- Annotated entity classes
│   │   └── Generator
│   │      └── UuidGenerator.php -- Uuid genrator 
│   │   └── User.php             -- User entity 
│   │   └── Movie.php            -- Movie entity  
│   └── Service
│       ├── MovieService          -- Movie serrice 
│       └── UserService           -- User service
│
├── cli-config.php          -- Configuration file for the vendor/bin/doctrine development tool
├── composer.json
├── composer.lock
└── README.md             
```

## Running the app
Strep 1:
`composer install`

Strep 2:
`composer serve`

You can access this route to make API call `http://localhost:8000`
Make sure there is no process running on `8000` port into your local machine.

NOTE: Please find the API collection : https://www.getpostman.com/collections/30511949eb450242fab6

```bash
$ curl -X POST localhost:8000/login   // get jwt access token
{
    "email": "noman.ilyas.software@gmail.com",
    "username": "Noman.ilyas",
    "token": "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJlbWFpbCI6Im5vbWFuLmlseWFzLnNvZnR3YXJlQGdtYWlsLmNvbSIsInVzZXJuYW1lIjoiTm9tYW4uaWx5YXMiLCJ0b2tlbiI6ImM4MzNhYzk0N2QzMDZkMDkifQ.Ktd0VcRfROrAyUVmpyTxp1ehMLZDAYAzPQ2HYepo-bc"
}
```

```bash
$ curl -X POST localhost:8000/movie   //create new movie
{
    "id": "cad8a578-023e-4493-bb05-2ea72502c518",
    "name": "The Titanic",
    "cast": [
        "DiCaprio",
        "Kate Winslet"
    ],
    "released_date": "18-01-1998",
    "director": "James Cameron",
    "rating": {
        "imdb": "7.8",
        "rotten_tomatto": "8.2"
    }
} 
```