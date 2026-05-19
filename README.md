lrclibPHP
=======

PHP library for retrieving lyrics from lrclib.net API.<br>


Quick Start
===========

* Clone this repo or download the latest [release zip]
* Include `bootstrap.php`.
* Get some data

Search For lyrics<br>

@parameters:<br>
@note: trackArtist and trackName are mandatory, rest is optional but will increase matching<br>

string trackArtist (not the the album artist!)<br>
string trackName<br>
string albumTitle<br>
string|int trackLength (in seconds)<br>

```php
$result = new \Lyric\Lyric();
print_r($result->getLyric("3 doors down", "Kryptonite", "The Better Life", "234"));
```

Installation
============

Download the latest version or latest git version and extract it to your webserver. Use one of the above methods to get some results

Get the files with one of:
* Git clone. Checkout the latest release tag
* [Zip/Tar download]

### Requirements
* PHP >= works from 8.0 - 8.5
* PHP cURL extension
* PHP json extension

