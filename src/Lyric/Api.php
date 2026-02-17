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
 * Accessing lyric data through API
 * @author Ed (duck7000)
 */
class Api
{

    /**
     * @var Config
     */
    private $config;

    /**
     * API constructor.
     * @param Config $config
     */
    public function __construct($config)
    {
        $this->config = $config;
    }

    /**
     * Uncensor lyrics data
     * @param string $inputLyrics input censored lyrics text
     * @return string uncensored lyrics text
     */
    private function removeCensoring($inputLyrics)
    {
        $replace = array(
            'f*ck' => 'fuck',
            'f**ck' => 'fuck',
            'f**k' => 'fuck',
            'F*ck' => 'Fuck',
            'F**ck' => 'Fuck',
            'F**k' => 'Fuck',
            'sh*t' => 'shit',
            's**t' => 'shit',
            'Sh*t' => 'Shit',
            'S**t' => 'Shit'
        );
        if ($this->config->uncensor === true) {
            return strtr(trim($inputLyrics), $replace);
        } else {
            return trim($inputLyrics);
        }
    }

    /**
     * Get and process api call data
     * @param string $url api call url
     * @return string if lyrics data found, false otherwise
     */
    public function exactMatchApiCall($url)
    {
        $data = $this->execRequest($url);
        if (isset($data->plainLyrics) && $data->plainLyrics != '') {
            return $this->removeCensoring($data->plainLyrics);
        } elseif (isset($data->instrumental) && $data->instrumental === true) {
            return 'Instrumental';
        }
        return false;
    }

    /**
     * Get and process api search call data (if there is no exact match)
     * @param string $searchUrl api call search url
     * @return string if lyrics data found, false otherwise
     */
    public function searchApiCall($searchUrl)
    {
        $searchData = $this->execRequest($searchUrl);
        if (is_array($searchData) && count($searchData) > 0) {
            if (isset($searchData[0]->plainLyrics) && $searchData[0]->plainLyrics != '') {
                return $this->removeCensoring($searchData[0]->plainLyrics);
            } elseif (isset($searchData[0]->instrumental) && $searchData[0]->instrumental === true) {
                return 'Instrumental';
            }
        }
        return false;
    }

    /**
     * Execute request
     * @param string $url
     * @return \stdClass
     */
    public function execRequest($url)
    {
        $request = new Request($url, $this->config);
        $request->sendRequest();
        if (200 == $request->getStatus() || 307 == $request->getStatus()) {
            return json_decode($request->getResponseBody());
        } elseif (404 == $request->getStatus()) {
            return false;
        } else {
            if ($this->config->throwHttpExceptions) {
                throw new \Exception("Failed to retrieve query");
            } else {
                return new \StdClass();
            }
        }
    }
}
