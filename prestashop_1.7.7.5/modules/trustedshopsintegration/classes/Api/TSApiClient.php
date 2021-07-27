<?php
/**
* 2016-2021 Trusted Shops GmbH
*
* NOTICE OF LICENSE
*  @author    Trusted Shops GmbH
*  @copyright 2016-2021 Trusted Shops GmbH
*  @license   http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
*
*/

require_once 'TSApiResponse.php';

if (!defined('TSAPI_URL')) {
    define('TSAPI_URL', 'https://api.trustedshops.com');
}
if (!defined('TSAPI_KEY')) {
    define('TSAPI_KEY', 'b7141bb85d47973f2cc6f235a200bb0612a194985def2e549ff7f26e1f0696a0');
}

/**
 * @desc: API Client of Trusted Shops
 */
class TSApiClient
{
    /**
     * @desc: url of the API
     */
    private $url = TSAPI_URL;

    /**
     * @desc: curl resource
     */
    private $ch;


    /**
     * @desc: response
     */
    private $response;

    /**
     * @desc: wrapper of the webservice
     */
    private $wrapper;

    /**
     * @desc: token of the webservice provide by Trusted Shops
     */
    private $token = TSAPI_KEY;

    /**
     * @desc: get an instance of a new wrapper
     * @param: string $wrapper
     *
     * @return this
     */
    public static function getWrapper($wrapper)
    {
        $avalaibleWrapper = array(
            'application',
            'generator',
            'memberships',
            'shops',
            'trigger',
            'reviewcollector',
            'richsnippets'
        );
        if (!in_array($wrapper, $avalaibleWrapper)) {
            throw new Exception('Please set a wrapper in: '. implode(', ', $avalaibleWrapper));
        }

        $wrapperObjectName = 'TSApiWrapper' . Tools::ucfirst($wrapper);
        require_once($wrapperObjectName . '.php');

        $wrapperObject = new $wrapperObjectName;

        return $wrapperObject;
    }

    /**
     * @desc: set API url (prod or qa)
     * @param: string $url
     *
     * @return this
     */
    public function setApiUrl($url)
    {
        $this->url = $url;

        return $this;
    }

    /**
     * @desc: call a webservice
     * @param string $url
     *
     * @return this
     */
    public function call(TSApiWrapperInterface $wrapper)
    {
        $this->wrapper = $wrapper;
        if ($this->wrapper->check()) {
            return $this->send();
        } else {
            throw new Exception(
                'Please verify the configuration of your wrapper. Did you forget to set credential or input data ?'
            );
        }
    }

    /**
     * @desc: Send the cUrl request
     */
    private function send()
    {
        if (!$this->wrapper) {
            throw new Exception('Please set a webservice before calling ');
        }
        $url = $this->url . $this->wrapper->getUri();

        if ($content = $this->wrapper->isCacheExipred() !== true) {
            $this->response = new TSApiResponse('success');
            $this->wrapper->parseReponse($this->response, $this->wrapper->isCacheExipred());
            return true;
        }

        $headers = array();
        $headers[] = 'Content-Type: application/json';
        $this->ch = curl_init();
        curl_setopt($this->ch, CURLOPT_URL, $url);
        curl_setopt($this->ch, CURLOPT_CUSTOMREQUEST, $this->wrapper->getMethod());
        curl_setopt($this->ch, CURLOPT_HEADER, false);
        curl_setopt($this->ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($this->ch, CURLOPT_TIMEOUT, 10);
        $credentials = $this->wrapper->getCredentials();
        if (!empty($credentials)) {
            curl_setopt($this->ch, CURLOPT_USERPWD, "".$credentials."");
            curl_setopt($this->ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
        }

        if ($this->wrapper->getMethod() == 'POST') {
            $headers[] = 'client-token: ' . $this->token;
            curl_setopt($this->ch, CURLOPT_POSTFIELDS, json_encode($this->wrapper->getInput()));
        }
        curl_setopt($this->ch, CURLOPT_HTTPHEADER, $headers);
        $content = curl_exec($this->ch);
        $httpCode = curl_getinfo($this->ch, CURLINFO_HTTP_CODE);
        curl_close($this->ch);

        if ($httpCode == 500 || $httpCode == 0) {
            $this->response = new TSApiResponse('fail');
            $this->response->addError('Internal failed');

            return false;
        }
        if ($httpCode == 401) {
            $this->response = new TSApiResponse('fail');
            $this->response->addError('Authentication failed');

            return false;
        }

        if ($httpCode == 400) {
            $this->response = new TSApiResponse('fail');
            $this->response->addError('Invalid shop URL');

            return false;
        }
        $this->wrapper->saveInCache($content);
       
        $this->response = new TSApiResponse('success');
        $this->wrapper->parseReponse($this->response, $content);

        return true;
    }

    /**
     * @desc: get response
     *
     * @return TSApiResponse
     */
    public function getResponse()
    {
        return $this->response;
    }
}
