# CoverLover Service

CoverLover is a setlist manager designed specifically for coverbands. Currently it will only store one band's repetoire.

Accepted content-types: `JSON`, `x-www-form-urlencoded`, and `XML`. This has to be included in the header. If no content-type specified, the service will return JSON.

The Service provides links to resources in the resource objects, it is reccommended you use these links in your client.

**Root:** [http://api.example.com/]()

## Songs

*collection resource*

**URI:** `/songs`

### GET

Returns a collection of songs. By default there is no limit to the amount of results.

> **200** *Ok* - All good, resource returned.

> **403** *Bad request* - Check request for discrepancies.

> **50X** *Internal Error* - Server side error, please alert developer of the error.

### POST

Creates a new Song resource. Accepted body types are `JSON`, `x-www-form-urlencoded`, and `XML`.

> **201** *Created* - The data you provided was accepted by the server, the server will automatically snd you the new object back in the body.

> **403** *Bad request* - Check your request for discrepancies.

> **50x** *Internal Error* - Server side error, please alert developer of the error.

### Example Resource

```json
http://api.example.com/songs

[
	{
		"id": 20145,
		"slug": "sharp_dressed_man",
		"title": "Sharp Dressed Man",
		"artist": "ZZ Top",
		"links": {
			"self": "http://api.example.com/songs/sharp_dressed_man",
			"collection": "http://api.example.com/songs"
		}
	},
	{
		"id": 20146,
		"slug": "bohemian_like_you",
		"title": "Bohemian Like You",
		"artist": "The Dandy Warholes",
		"links": {
			"self": "http://api.example.com/songs/sharp_dressed_man",
			"collection": "http://api.example.com/songs"
		}
	}
]

```



## Song

*simple resource*

**URI:** `/songs/{ song_id || song_slug} `

### GET

Returns a single, detailed view of the song object.

> **200** *Ok* - All good, resource returned.

> **404** *Resource not found* - Resource you requested doesn't exist, or is deleted.

> **403** *Bad request* - Check request for discrepancies.

> **50X** *Internal Error* - Server side error, please alert developer of the error.

### PUT

Replaces the old resource with the new, provided, resource. The new resource has to be complete, empty fields will remain empty.

> **201** *Created* - The data you provided was accepted by the server, the server will automatically send you the new object back in the body.

> **404** *Resource not found* - Resource you requested doesn't exist, or is deleted.

> **403** *Bad request* - Check your request for discrepancies.

> **50x** *Internal Error* - Server side error, please alert developer of the error.> 

### DELETE

Deletes the resource permanently.

> **204** *Deleted* - The specified resource was successfully removed.

> **404** *Resource not found* - Resource you requested doesn't exist, or is deleted.

> **403** *Bad request* - Check your request for discrepancies.

> **50x** *Internal Error* - Server side error, please alert developer of the error.

### Sample Resource

```json
https://api.example.com/songs/sharp_dressed_man

{
	"id": 20145,
	"slug": "sharp_dressed_man",
	"title": "Sharp Dressed Man",
	"artist": "ZZ Top",
	"examples": [
		{
		 	"type": "youtube",
		 	"url": "https://www.youtube.com/watch?v=Eh9Q6BGGU50"
		}
	],
	"notes": "In the style of the Nickelback (live) cover of this song. After the second chorus another solo and chorus.",
	"key": "C",
	"date_added": "2014-09-20 21:48:42",
	"links": {
		"self": "https://api.example.com/songs/sharp_dressed_man",
		"next": "https://api.example.com/songs/bohemian_like_you",
		"collection": "https://api.example.com/songs"
	}
}
```


> **CODE** *Message* - Tip