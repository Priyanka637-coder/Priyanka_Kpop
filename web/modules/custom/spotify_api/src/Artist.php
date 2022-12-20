<?php

namespace Drupal\spotify_api;

use Drupal\Component\Serialization\Json;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;

define('API_URL', 'https://api.spotify.com');

class Artist {

   public function getArtistById($artistId) 
   {
    try {
        $service1 = \Drupal::service('spotify_api.Access');
        $accessToken =  $service1->requestAccessToken();
        $response_data = Json::decode($accessToken->getContent());
        $base_url = API_URL.'/v1/artists/'.$artistId;
        $client = \Drupal::httpClient()->get($base_url, [
            'headers' => [
                'Accept' => 'application/json',
                'Authorization' => 'Bearer '.$response_data['access_token'],
            ],
        ])->getBody()->getContents();
        $data = new Response($client);
        return $data;
    }catch (HttpExceptionInterface $e){
        throw $e;
    } 

   }


}

