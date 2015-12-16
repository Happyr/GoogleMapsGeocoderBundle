<?php

namespace HappyR\Google\GeocoderBundle\Services;

/**
 * Class GeocodeService
 *
 * This service geocodes an address to coords and back
 */
class GeocodeService
{
    protected $baseUrl = 'http://maps.googleapis.com/maps/api/geocode/json?sensor=false';

    /**
     * @var ScraperService $scraper
     *
     *
     */
    private $scraper;

    /**
     * @param ScraperService $scraper
     * @param array $config
     */
    public function __construct(ScraperService $scraper, array $config)
    {
        $this->scraper = $scraper;

        if (isset($config['language']) && $config['language'] != '') {
            $this->baseUrl .= '&language=' . $config['language'];
        }
    }

    /**
     * Geocode an address.
     *
     * @param string $text
     * @param bool $raw
     *
     * @return string|null the response of a request to google
     */
    public function geocodeAddress($text, $raw = false)
    {
        $response = $this->scraper->scrape($this->baseUrl . '&address=' . urlencode($text));

        $response = json_decode($response);

        if ($response->status != 'OK') {
            $this->handleError($response);
        }

        if ($raw) {
            return $response->results;
        }

        return $response->results[0]->geometry->location;
    }

    /**
     * Returns address from a coordinates
     *
     * @param float $lat
     * @param float $lang
     * @param bool $raw
     *
     * @return string|null
     */
    public function reverseGeocodeAddress($lat, $lang, $raw = false)
    {
        $response = $this->scraper->scrape($this->baseUrl . '&latlng=' . $lat . ',' . $lang);

        $response = json_decode($response);

        if ($response->status != 'OK') {
            $this->handleError($response);
        }

        if ($raw) {
            return $response->results;
        }

        return $response->results[0]->formatted_address;
    }

    public function handleError($response){
        if ($response->error_message) {
            $msg = $response->error_message;
        } else {
            $msg = 'There has been an eror while communicating with Google API';
        }
        throw new \Exception($msg);
    }
}
