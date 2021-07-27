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

require 'TSApiWrapperInterface.php';

/**
 * @desc: abstract wrapper of a webservice
 */
abstract class TSApiWrapperAbstract implements TSApiWrapperInterface
{
    protected $credentials;

    protected $uri;

    protected $method = 'GET';

    protected $tsId;

    protected $input;

    /**
     * @desc: set credential
     * @param: string $url
     *
     * @return this
     */
    public function setCredentials($credentials)
    {
        $this->credentials = $credentials;

        return $this;
    }

    /**
     * @desc: get credential
     * @param: string $url
     *
     * @return this
     */
    public function getCredentials()
    {
        return Tools::htmlentitiesDecodeUTF8($this->credentials);
    }

    /**
     * @desc: set API url (prod or qa)
     * @param: string $url
     *
     * @return this
     */
    public function getUri()
    {
        return $this->uri;
    }

    /**
     * @desc: set request tsId
     * @param: string $tsId
     *
     * @return this
     */
    public function setTsId($tsId)
    {
        $this->tsId = $tsId;

        return $this;
    }

    /**
     * @desc: set request method
     * @param: string $method
     *
     * @return this
     */
    public function setMethod($method)
    {
        $this->method = $method;

        return $this;
    }

    /**
     * @desc: get request method
     *
     * @return this
     */
    public function getMethod()
    {
        return $this->method;
    }

    /**
     * @desc: set request body
     * @param: string $json
     *
     * @return this
     */
    public function setInput($json)
    {
        $this->input = $json;

        return $this;
    }

    /**
     * @desc: get request body
     *
     * @return this
     */
    public function getInput()
    {
        return $this->input;
    }

    /**
     * @desc: check if wrapper is correctly configurated
     *
     * @return this
     */
    public function check()
    {
        return false;
    }

    /**
     * @desc: check if cache is expired
     *
     * @return boolean
     */
    public function isCacheExipred()
    {
        return true;
    }

    /**
     * @desc: save in cache file
     * @param: $data     string        json response
     *
     * @return this
     */
    public function saveInCache($data)
    {
        return $this;
    }

    /**
     * @desc: check if wrapper is correctly configurated
     * @param: $response TSApiResponse Response object
     * @param: $data     string        json response
     *
     * @return this
     */
    public function parseReponse(TSApiResponse $response, $data)
    {
        $data = json_decode($data, true);
        $response->setContent($data);

        return $this;
    }
}
