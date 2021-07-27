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

require_once 'TSApiWrapperAbstract.php';

/**
 * @desc: API Client of Trusted Shops
 */
class TSApiWrapperShops extends TSApiWrapperAbstract implements TSApiWrapperInterface
{

    protected $uri = '/rest/restricted/v2/retailers/shops.json';

    /**
     * @desc: check if wrapper is correctly configurated
     *
     * @return boolean
     */
    public function check()
    {
        if ($this->credentials == null) {
            return false;
        }

        return true;
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
        $response->setContent($data['response']['data']);

        return $this;
    }
}
