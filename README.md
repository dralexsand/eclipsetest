## About project

### API Articles, Tags

git clone 

php artisan migrate

php artisan db:seed

php artisan serve 

### Entry point: /api/v1

##Methods:

###Get all articles:

Request:
```
/api/v1/articles 
```

Response:

```
{
"status": "SUCCESS",
    "data": [
        {
            "id": 1,
            "title": "Queen, 'Really, my dear, YOU must cross-examine.yuwvs",
            "content": "Mock Turtle. 'And how did you manage to do it?' 'In my youth,' said the sage, as he shook his grey locks, 'I kept all my limbs very supple By the use of a book,' thought Alice 'without pictures or conversations?' So she was considering in her own mind (as well as she could, and soon found herself safe in a thick wood. 'The first thing I've got to do,' said Alice to herself. 'Of the mushroom,' said the Caterpillar, just as if it had come back with the Duchess, it had entirely disappeared; so.fq8ydqjcaw1wipyhsiayjzs",
            "created_at": "2021-12-02T15:31:29.000000Z",
            "updated_at": "2021-12-02T15:31:29.000000Z",
            "tags": [
                {
                    "id": 17,
                    "name": "destinlabadiefybajahqauhw0t0c",
                    "pivot": {
                        "article_id": 1,
                        "tag_id": 17
                    }
                },
                ...
                ],
},    
```
or

```
"status": "ERROR",
"message": "Error request"
```

## Sample Update article:

```
{
    "title": "Article Title for #113AA", 
    "content" : "Article content",
    "method": "add", // available values: add, replace
    "tags": [
        "sdfsdfsdo",
        "12121fsdfsd54fsd"
        ]
}
```

### All methods:

POST      | api/v1/articles
GET|HEAD  | api/v1/articles/{article}
PUT|PATCH | api/v1/articles/{article}
DELETE    | api/v1/articles/{article}

GET|HEAD  | api/v1/tags
GET|HEAD  | api/v1/tags/{id}
PUT       | api/v1/tags/{id}
DELETE    | api/v1/tags/{id}  

