# wptv-sessions-connector
Functionality Plugin for WP-Tools

## Version ##

* 1.0.6

## Available Endpoints ##

### Get all event posts ###

```
#!html

http://wptv.dialogo-web.de/wp-json/wptvsc-app-routes/v2/get-event-posts
```

```
#!txt

GET
```

**Response**

*Successfully*


```
#!json
[
    {
        "ID": 35,
        "post_modified_gmt": "2018-07-28 11:47:38",
        "post_title": "WordCamp Würzburg 2018",
        "thumbnail": false,
        "event_date": "",
        "event_year": "",
        "event_city": "Würzburg",
        "producer_name": "Frank Neumann-Staude",
        "producer_username": "f.staude"
    }
]
```

### Get event with sessions ###

```
#!html

http://wptv.dialogo-web.de/wp-json/wptvsc-app-routes/v2/get-event/ID
```

```
#!txt

GET
```

**Response**

*Successfully*


```
#!json
[
    {
        "ID": 35,
        "post_modified_gmt": "2018-07-28 11:47:38",
        "post_title": "WordCamp Würzburg 2018",
        "thumbnail": false,
        "event_date": "",
        "event_year": "",
        "event_city": "Würzburg",
        "producer_name": "Frank Neumann-Staude",
        "producer_username": "f.staude",
        "sessions": [
            {
                "ID": 32,
                "speaker_name": "Stefan Kramer",
                "sesion_description": "Lorem Ipsum",
                "twitterhandle": "@stkjj",
                "room": "Raum 1",
                "date": "20180922",
                "time": "10:00",
                "sprache": "german"
            }
        ]
    }
]
```
