<?php

namespace App\Http\Helpers;

class Yelp {

    public $client;

    public function __construct() {
        // create auth 
        $client = new \Stevenmaguire\Yelp\v3\Client(array(
            'accessToken' => \Config::get('constants.YELP_ACCESS_TOKEN'),
            'apiHost' => \Config::get('constants.YELP_API_HOST'), // Optional, default 'api.yelp.com'
        ));
        $this->client = $client;
    }

    public function getBusinessResult($data,$limit='') {
//        if (isset($data['start']) && $data['start'] == 0) {
//            $offset = 0;
//        } else if (isset($data['start'])) {
//            $offset = $data['start'];
//        } else {
            $offset = 0;
      //  }
        $parameters = [
            'term' => $data['vendor_name'],
            'location' => $data['vendor_address'],
            'sort_by' => 'best_match',
            'limit' => (empty($limit)?50:$limit),
            'offset' => $offset,
        ];
        // Perform a request to a public resource
        $results = $this->client->getBusinessesSearchResults($parameters);
        return $results;
    }

}
