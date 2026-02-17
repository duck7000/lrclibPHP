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
     * @param string $albumTitle release album title
     * @param string $trackArtist track artist (not the album artist!)
     * @param string $trackName track name
     * @param string $trackLength track length (in seconds)
     * @return string lyric text or false
     */
    public function getLyric(
        $albumTitle,
        $trackArtist,
        $trackName,
        $trackLength)
    {
        if (!empty($trackArtist) && !empty($trackName)) {
            $trackArtist = urlencode($trackArtist);
            $trackName = urlencode($trackName);
            $url = $this->config->baseApiUrl . '/get?';
            $url .= 'artist_name=' . $trackArtist;
            $url .= '&';
            $url .= 'track_name=' . $trackName;
            if (!empty($albumTitle)) {
                $url .= '&';
                $url .= 'album_name=' . urlencode($albumTitle);
            }
            if (!empty($trackLength)) {
                $url .= '&';
                $url .= 'duration=' . $trackLength;
            }

            // First API call with all available parameters
            $results = $this->api->exactMatchApiCall($url);

            if ($results !== false) {
                return $results;
            }

            // If false, second API call with artist and trackname
            $urlNoAlbum = $this->config->baseApiUrl . '/get?';
            $urlNoAlbum .= 'artist_name=' . $trackArtist;
            $urlNoAlbum .= '&';
            $urlNoAlbum .= 'track_name=' . $trackName;
            $resultsNoAlbum = $this->api->exactMatchApiCall($urlNoAlbum);
            if ($resultsNoAlbum !== false) {
                return $resultsNoAlbum;
            }

            // if still false third API call for a search
            if ($this->config->apiSearch === true) {
                $searchUrl = $this->config->baseApiUrl . '/search?';
                $searchUrl .= 'track_name=' . $trackName;
                $searchUrl .= '&';
                $searchUrl .= 'artist_name=' . $trackArtist;
                $searchResults = $this->api->searchApiCall($searchUrl);
                if ($searchResults !== false) {
                    return $searchResults;
                }
            }
        }
        return false;
    }
}
