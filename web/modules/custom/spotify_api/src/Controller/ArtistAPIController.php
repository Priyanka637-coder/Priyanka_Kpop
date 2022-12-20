<?php

namespace Drupal\spotify_api\Controller;

use Drupal\Component\Serialization\Json;
use Drupal\Core\Controller\ControllerBase;

class ArtistAPIController extends ControllerBase {
    public function getArtist($artistId) {
        $service = \Drupal::service('spotify_api.Artist'); 
        $artists_info = $service->getArtistById($artistId);
        if(!empty($artists_info)){
            $data =  Json::decode($artists_info->getContent());
            return [
                '#theme' => 'artist_info',
                '#name' => $data['name'],
                '#image' => $data['images'][0]['url'],
                '#genres'=> implode(',', $data['genres']),
                '#title' => '',
              ];
        }else{
            return false;
        }
       
    }     
}