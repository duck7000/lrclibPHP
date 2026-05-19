<?php

#############################################################################
# lrclibPHP                                     ed (github user: duck7000)  #
# written by ed (github user: duck7000)                                     #
# ------------------------------------------------------------------------- #
# This program is free software; you can redistribute and/or modify it      #
# under the terms of the GNU General Public License (see doc/LICENSE)       #
#############################################################################

namespace Lyric;

/**
 * Get lyrics from lrclib for a title track
 * @author ed (github user: duck7000)
 */
class Lyric extends MdbBase
{

    /**
     * @param Config $config OPTIONAL override default config
     */
    public function __construct(?Config $config = null)
    {
        parent::__construct($config);
    }

    /**
     * Get lrclib song lyric data
     * @param string $trackArtist track artist (not the album artist!)
     * @param string $trackName track name
     * @param string $albumTitle release album title
     * @param string $trackLength track length (in seconds)
     * @note: $trackArtist and $trackName are mandatory, other parameters are optional
     * @return string lyric text or false
     */
    public function getLyric(
        $trackArtist,
        $trackName,
        $albumTitle = '',
        $trackLength = '')
    {
        $trackArtist = trim($trackArtist);
        $trackName = trim($trackName);
        $albumTitle = trim($albumTitle);
        $trackLength = trim($trackLength);
        
        if (!empty($trackArtist) && !empty($trackName)) {
            $url = $this->buildUrl($trackArtist, $trackName, "get");
            $urlPart = $this->buildUrlAdition($albumTitle, $trackLength);

            // First API call with all available parameters
            $results = $this->api->exactMatchApiCall($url . $urlPart);
            if ($results !== false) {
                return $results;
            }

            // Second API call with artist and trackname
            $noAlbumResults = $this->api->exactMatchApiCall($url);
            if ($noAlbumResults !== false) {
                return $noAlbumResults;
            }

            // Third API call for a search with artist and trackname
            if ($this->config->apiSearch === true) {
                $noAlbumSearchUrl = $this->buildUrl($trackArtist, $trackName, "search");
                $noAlbumSearchResults = $this->api->searchApiCall($noAlbumSearchUrl);
                if ($noAlbumSearchResults !== false) {
                    return $noAlbumSearchResults;
                }
            }
        }
        return false;
    }

    /**
     * Build first part of api call url
     * @param string $trackArtist track artist (not the album artist!)
     * @param string $trackName track name
     * @param string $method e.g. get (for direct lookup), search (for search)
     * @return string
     */
    private function buildUrl($trackArtist, $trackName, $method)
    {
        $getUrl = $this->config->baseApiUrl;
        $getUrl .= '/';
        $getUrl .= $method;
        $getUrl .= '?';
        $getUrl .= 'artist_name=' . urlencode($trackArtist);
        $getUrl .= '&';
        $getUrl .= 'track_name=' . urlencode($trackName);
        return $getUrl;
    }

    /**
     * Build second part of api call url
     * @param string $albumTitle album title
     * @param string $trackLength track length in seconds
     * @return string
     */
    private function buildUrlAdition($albumTitle, $trackLength)
    {
        $urlPart = '';
        if (!empty($albumTitle)) {
            $urlPart .= '&';
            $urlPart .= 'album_name=' . urlencode($albumTitle);
        }
        if (!empty($trackLength)) {
            $urlPart .= '&';
            $urlPart .= 'duration=' . $trackLength;
        }
        return $urlPart;
    }
}
