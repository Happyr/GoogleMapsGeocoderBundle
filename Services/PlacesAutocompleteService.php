<?php

namespace HappyR\Google\GeocoderBundle\Services;

/**
 * Class PlacesAutocompleteService
 *
 * This service helps you autocomplete with google places
 */
class PlacesAutocompleteService
{
    protected $baseUrl = 'https://maps.googleapis.com/maps/api/place/autocomplete/json?sensor=false';

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
    function __construct(ScraperService $scraper, array $config)
    {
        $this->scraper = $scraper;
        $this->baseUrl .= '&key=' . $config['developer_key'];

        if (isset($config['language']) && $config['language'] != '') {
            $this->baseUrl .= '&language=' . $config['language'];
        }
    }

    /**
     * Autocomplete the location
     *
     *
     * @param string $location
     *
     * @return string the response of a request to google
     */
    public function autocomplete($location)
    {
        $url = $this->baseUrl . '&input=' . urlencode($location);
        $response = $this->scraper->scrape($url);

        $response = json_decode($response);

        if ($response->status != 'OK') {
            return $location;
        }

        return $response->predictions[0]->description;
    }
}
