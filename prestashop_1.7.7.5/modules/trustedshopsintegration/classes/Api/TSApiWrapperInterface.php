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

/**
 * @desc: interface wrapper of a webservice
 */
interface TSApiWrapperInterface
{

    /**
     * @desc: set credential
     * @param: string $url
     *
     * @return this
     */
    public function setCredentials($credentials);

    /**
     * @desc: get credential
     * @param: string $url
     *
     * @return this
     */
    public function getCredentials();

    /**
     * @desc: set API url (prod or qa)
     * @param: string $url
     *
     * @return this
     */
    public function getUri();

    /**
     * @desc: set request method
     * @param: string $method
     *
     * @return this
     */
    public function setMethod($method);

    /**
     * @desc: get request method
     *
     * @return this
     */
    public function getMethod();

    /**
     * @desc: set request body
     * @param: string $json
     *
     * @return this
     */
    public function setInput($json);

    /**
     * @desc: get request body
     *
     * @return this
     */
    public function getInput();

    /**
     * @desc: check if wrapper is correctly configurated
     *
     * @return this
     */
    public function check();

    /**
     * @desc: check if cache is expired
     *
     * @return boolean
     */
    public function isCacheExipred();

    /**
     * @desc: save in cache file
     * @param: $data     string        json response
     *
     * @return this
     */
    public function saveInCache($data);
}
