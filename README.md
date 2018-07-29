# wptv-sessions-connector
Formular zur Erfassung der Grunddaten, die für die weitere Verarbeitung in OBS, wordpress.tv und Digital Signage genutzt werden. 
Gemäss: https://docs.google.com/document/d/17KLuKEmInxFBMsivDe8ujvOJKVC3zBtSJ9XS7rk3f0I/edit?usp=sharing


Functionality Plugin for WP-Tools

## Version ##

* 1.0.10

## Available Endpoints ##

### Get all event posts ###

```html

http://wptv.dialogo-web.de/wp-json/wptvsc-app-routes/v2/get-event-posts
```

```txt

GET
```

**Response**

*Successfully*


```json
[
    {
        "ID": 35,
        "post_modified_gmt": "2018-07-28 13:42:58",
        "post_title": "WordCamp Würzburg 2018",
        "thumbnail": false,
        "event_date_start": "20180922",
        "event_date_end": "20180922",
        "event_year": "2018",
        "event_city": "Würzburg",
        "producer_name": "Frank Neumann-Staude",
        "producer_username": "f.staude"
    }
]
```

### Get event with sessions ###

```html

http://wptv.dialogo-web.de/wp-json/wptvsc-app-routes/v2/get-event/ID
```

```txt

GET
```

**Response**

*Successfully*


```json
[
    {
        "ID": 35,
        "post_modified_gmt": "2018-07-28 13:42:58",
        "post_title": "WordCamp Würzburg 2018",
        "thumbnail": false,
        "event_date_start": "20180922",
        "event_date_end": "20180922",
        "event_year": "2018",
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
```
