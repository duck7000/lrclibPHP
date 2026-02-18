TMDbAPIPHP
=======

PHP library for retrieving lyrics from lrclib.net API.<br>


Quick Start
===========

* Clone this repo or download the latest [release zip]
* Include `bootstrap.php`.
* Get some data

Search For lyrics<br><br>

@parameters:<br><br>

string albumTitle<br>
string trackArtist (not the the album artist!)<br>
string trackTitle<br>
string|int trackLength (in seconds)<br>

```php
$result = new \Lyric\Lyric();
print_r($result->getLyric("The Better Life", "3 doors down", "Kryptonite", "234"));
```

Installation
============

Download the latest version or latest git version and extract it to your webserver. Use one of the above methods to get some results

Get the files with one of:
* Git clone. Checkout the latest release tag
* [Zip/Tar download]

### Requirements
* PHP >= works from 8.0 - 8.4
* PHP cURL extension
* PHP json extension

