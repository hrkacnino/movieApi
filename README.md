# Movie Api
Application created with Symfony 5.4 framework.
<br>
### Steps to start application:
- composer install (composer v2 is required)
- add db connection to MySqlDB in .env file 
- create DB schema with command *bin/console doctrine:database:create*
- update DB schema with command *bin/console doctrine:schema:update --force*
- start app with *symfony server:start*

### API

#### POST /api/v1/movies

```
POST /api/v1/movies
```

Payload entity:

```
{
    "name": "The Titanic",
    "casts":[
        "DiCaprio",
        "Kate Winslet"
    ],
    "release_date": "18-01-1998",
    "director": "James Cameron",
    "ratings": {
        "imdb": 7.8,
        "rotten_tomatto": 8.2
    }
}
```
#### GET /api/v1/movies/{id}

```
GET /api/v1/movies/{id}
```

Example response:

```
{
    "name": "The Titanic",
    "casts":[
        "DiCaprio",
        "Kate Winslet"
    ],
    "release_date": "18-01-1998",
    "director": "James Cameron",
    "ratings": {
        "imdb": 7.8,
        "rotten_tomatto": 8.2
    }
}
```

#### GET /api/v1/movies

```
GET /api/v1/movies
```

Expected result format:

```
[
    {
        "name": "The Titanic",
        "casts":[
            "DiCaprio",
            "Kate Winslet"
        ],
        "release_date": "18-01-1998",
        "director": "James Cameron",
        "ratings": {
            "imdb": 7.8,
            "rotten_tomatto": 8.2
        }
    }
]
```
