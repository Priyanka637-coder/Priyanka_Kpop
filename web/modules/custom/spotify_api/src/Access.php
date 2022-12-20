<?php

namespace Drupal\spotify_api;

use Drupal\Core\Site\Settings;
use Symfony\Component\HttpFoundation\Response;
use GuzzleHttp\Exception\ClientException;

define('ACCOUNT_URL', 'https://accounts.spotify.com');

class Access {

    protected $accessToken = '';
    protected $clientId = '';
    protected $clientSecret = '';

    public function __construct()
    {
        
        $clientId = Settings::get('client_id', '1111');
        $clientSecret = Settings::get('client_secret', '1111');
        $this->setClientId($clientId);
        $this->setClientSecret($clientSecret);
    }

    /**
     * Get the access token.
     *
     * @return string The access token.
     */
    public function getAccessToken()
    {
        return $this->accessToken;
    }

    /**
     * Get the client ID.
     *
     * @return string The client ID.
     */
    public function getClientId()
    {
        return $this->clientId;
    }

    /**
     * Get the client secret.
     *
     * @return string The client secret.
     */
    public function getClientSecret()
    {
        return $this->clientSecret;
    }

     /**
     * Set the access token.
     *
     * @param string $accessToken The access token
     *
     * @return void
     */
    public function setAccessToken($accessToken)
    {
        $this->accessToken = $accessToken;
    }

    /**
     * Set the client ID.
     *
     * @param string $clientId The client ID.
     *
     * @return void
     */
    public function setClientId($clientId)
    {
        $this->clientId = $clientId;
    }

    /**
     * Set the client secret.
     *
     * @param string $clientSecret The client secret.
     *
     * @return void
     */
    public function setClientSecret($clientSecret)
    {
        $this->clientSecret = $clientSecret;
    }


    public function requestAccessToken(): Response
    {
      try {
        $base_url = ACCOUNT_URL.'/api/token';
        $response = \Drupal::httpClient()->post($base_url, [
            'verify' => true,
            'form_params' => ['grant_type'=> 'client_credentials',
                              'client_id' => $this->getClientId(),
                              'client_secret'=>$this->getClientSecret() ,
                              'scope'=>'',],
              'headers' => [
                'Content-Type' => 'application/x-www-form-urlencoded',
              ],
          ])->getBody()->getContents();
          $data = new Response($response);
          return $data;
        }catch (ClientException $e){
          throw $e;
        }
    }

}