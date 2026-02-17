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
 * Configuration class for lrclibPHP
 * @author ed (github user: duck7000)
 */
class Config
{

    /**
     * Default userAgent to use in request, must be something that identifys program
     * @var string
     */
    public $userAgent = 'programName V1.0 (www.example.com)';
    
    /**
     * Base API url
     * @var string
     */
    public $baseApiUrl = 'https://lrclib.net/api';

    /**
     * Uncensor lyric text in Title class fetchData()
     * @var boolean
     * Default: true
     */
    public $uncensor = true;

    /**
     * Include api search if exaxt api match fails in Title class fetchData()
     * This setting is to include the possibilty to include the search part of the external API
     * Warning: if this is set to true it will increase search time drasticly
     * @var boolean
     * Default: true
     */
    public $apiSearch = true;

    /**
     * Throw Exception if something goes wrong with the api call
     * True: throws Exception, false: returns empty object
     * @var boolean
     */
    public $throwHttpExceptions = false;

}
