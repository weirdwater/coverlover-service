# CoverLover Service

**NATSCHOOL REF CODE:** 2369346

CoverLover is a setlist manager designed specifically for coverbands. Currently it will only store one band's repetoire.

Accepted content-types: `JSON`, `x-www-form-urlencoded`, and `XML`. This has to be included in the header. If no content-type specified, the service will return JSON.

The Service provides links to resources in the resource objects, it is reccommended you use these links in your client.

**Root:** [http://145.24.222.220/coverlover/]()

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
		"id": 1,
		"slug": "sharp_dressed_man",
		"title": "Sharp Dressed Man",
		"artist": "ZZ Top",
		"links": {
			"self": "http://145.24.222.220/coverlover/songs/sharp_dressed_man",
			"collection": "http://145.24.222.220/coverlover/songs/"
		}
	},
	{
		"id": 2,
		"slug": "bohemian_like_you",
		"title": "Bohemian Like You",
		"artist": "The Dandy Warholes",
		"links": {
			"self": "http://145.24.222.220/coverlover/songs/sharp_dressed_man",
			"collection": "http://145.24.222.220/coverlover/songs/"
		}
	}
]

```



## Song

*simple resource*

**URI:** `/songs/{ song_id || song_slug } `

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
https://api.example.com/songs/1

{
	"song" : {
		"id": "1",
		"slug": "sharp_dressed_man",
		"title": "Sharp Dressed Man",
		"artist": "ZZ Top",
		"notes": "In the style of the Nickelback (live) cover of this song. After the second chorus another solo and chorus.",
		"key": "C",
		"examples": [
			{
				"title": "Nickelback's versie",
				"type": "youtube",
				"url": "https://www.youtube.com/watch?v=Eh9Q6BGGU50"
			},                    {
				"title": "Originele versie van ZZ Top",
				"type": "Google Play Music",
				"url": "https://play.google.com/music/m/Tcpjys4ihvbkjuvyygae7kkkydi?t=Sharp_Dressed_Man_Live_-_ZZ_Top"
			}
		],
		"added": "2016-01-13 16:23:21"
	},
	"links": [
		{
			"rel": "self",
			"uri": "http://145.24.222.220/coverlover/songs/sharp_dressed_man"
		},
		{
			"rel": "collection",
			"uri": "http://145.24.222.220/coverlover/songs/"
		}
	]
}
```


> **CODE** *Message* - Tip
