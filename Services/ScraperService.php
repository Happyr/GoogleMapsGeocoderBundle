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
     *
     * @return string Returns a string containing the webpage or a json string with {"status":"FAIL"}
     */
    public function scrape($url)
    {

        if (ini_get('allow_url_fopen')) {
            $response = @file_get_contents($url);
            if ($response !== false) {
                return $response;
            }
        } elseif (function_exists('curl_init')) {
            $curl = curl_init();
            curl_setopt($curl, CURLOPT_URL, $url);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($curl, CURLOPT_HEADER, 0);

            return curl_exec($curl);
        }

        return '{"status":"FAIL"}';
    }
}