<?php

// Auth.php
#################################################
##
## PHPLicengine
##
#################################################
## Copyright 2009-{current_year} PHPLicengine
## 
## Licensed under the Apache License, Version 2.0 (the "License");
## you may not use this file except in compliance with the License.
## You may obtain a copy of the License at
##
##    http://www.apache.org/licenses/LICENSE-2.0
##
## Unless required by applicable law or agreed to in writing, software
## distributed under the License is distributed on an "AS IS" BASIS,
## WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
## See the License for the specific language governing permissions and
## limitations under the License.
#################################################

namespace PHPLicengine\Service;
use PHPLicengine\Exception\ResponseException;
use PHPLicengine\Exception\CurlException;

class Auth extends \PHPLicengine\Api\Api {
 
      private $url;
      
      public function __construct ($clientid_username, $clientsecret_password)
      {
             parent::__construct(null, true);
             $this->url = 'https://api-ssl.bitly.com/oauth/access_token';    
             $key = base64_encode($clientid_username.":".$clientsecret_password);
             $this->setApiKey($key);
     }
 
      /*
      Exchanging a Username and Password for an Access Token
      https://dev.bitly.com/v4/#section/Exchanging-a-Username-and-Password-for-an-Access-Token
      */
      public function exchangeToken(array $params)
      {
             $params['grant_type'] = 'password';
             $result = $this->post($this->url, $params);
             return json_decode($result->getResponse(), true)['access_token'];
      }

      /*
      HTTP Basic Authentication Flow
      https://dev.bitly.com/v4/#section/HTTP-Basic-Authentication-Flow
      */
      public function basicAuthFlow(array $params)
      {
             $result = $this->post($this->url, $params);
             return json_decode($result->getResponse(), true)['access_token'];
      }
}
