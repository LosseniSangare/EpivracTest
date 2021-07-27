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
 * @desc: API Client of Trusted Shops
 */

require_once 'TSApiWrapperAbstract.php';

class TSApiWrapperGenerator extends TSApiWrapperAbstract implements TSApiWrapperInterface
{

    protected $uri = '/rest/restricted/v2/shops/<TS_ID>/templates/reviewCollectorReviewRequest/generator';

    protected $method = 'POST';

    /**
     * @desc: uri of the data
     *
     * @return: uri of the api
     */
    public function getUri()
    {
        $uri = str_replace('<TS_ID>', $this->input['tsId'], $this->uri);

        return $uri;
    }

    /**
     * @desc: check if wrapper is correctly configurated
     *
     * @return boolean
     */
    public function check()
    {
        if ($this->input == null || $this->tsId == null) {
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
        $response->setContent($data);

        return $this;
    }
}
