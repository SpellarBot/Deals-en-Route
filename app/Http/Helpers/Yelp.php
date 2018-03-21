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
    
    public function getBusinessResult($data){
           
        if(isset($data['start'])){
            $offset=$data['start']+1;
        }else {
            $offset=1;
        }
        $parameters = [
            'term' => $data['vendor_name'],
            'location' => $data['vendor_address'],
            'sort_by' => 'best_match',
            'limit' => 10,
            'offset' => $offset,
        ];
        // Perform a request to a public resource
        $results = $this->client->getBusinessesSearchResults($parameters);
        return $results;
    }


}
