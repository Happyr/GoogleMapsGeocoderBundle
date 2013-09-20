<?php


namespace HappyR\Google\GeocoderBundle\Services;


/**
 * Class Scraper
 *
 * @author galen
 * @author Tobias Nyholm
 *
 */
class ScraperService
{

    /**
     * Scrapes a webpage and returns the result
     *
     * @param string $url
     * @return string|boolean Returns a string containing the webpage or false
     */
    public function scrape( $url ) {

        if ( ini_get( 'allow_url_fopen' ) ) {

            return file_get_contents( $url );
        }
        elseif ( function_exists( 'curl_init' ) ) {
            $curl = curl_init();
            curl_setopt( $curl, CURLOPT_URL, $url );
            curl_setopt( $curl, CURLOPT_RETURNTRANSFER, 1 );
            curl_setopt( $curl, CURLOPT_HEADER, 0);

            $result= curl_exec( $curl );

            curl_close( $curl );

            return $result;
        }
        else {

            return false;
        }

    }

}