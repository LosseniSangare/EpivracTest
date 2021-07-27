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
class TSApiWrapperRichsnippets extends TSApiWrapperAbstract implements TSApiWrapperInterface
{

    protected $uri = '/rest/restricted/v2/shops/<TS_ID>/quality/reviews.json';

    /**
     * @desc: uri of the data
     *
     * @return: uri of the api
     */
    public function getUri()
    {
        $uri = str_replace('<TS_ID>', $this->tsId, $this->uri);

        return $uri;
    }


    /**
     * @desc: check if cache is expired
     *
     * @return boolean
     */
    public function isCacheExipred()
    {
        $cacheKey = md5($this->getUri());
        $cacheFile = dirname(__FILE__).'/../../cache/' . $cacheKey .  '.json';
        if (!file_exists($cacheFile)) {
            return true;
        }
        $content = Tools::file_get_contents($cacheFile);
        $data = json_decode($content, true);
        if ($data['expiredate'] < time()) {
            return true;
        }

        return $content;
    }

    /**
     * @desc: check if wrapper is correctly configurated
     *
     * @return boolean
     */
    public function check()
    {
        if ($this->tsId == null) {
            return false;
        }

        return true;
    }

    /**
     * @desc: save in cache file // 1 hour
     * @param: $data     string        json response
     *
     * @return this
     */
    public function saveInCache($data)
    {
        $data = json_decode($data, true);
        $data['expiredate'] = time() + 3600;
        $content = json_encode($data);

        $cacheKey = md5($this->getUri());
        $cacheFile = dirname(__FILE__).'/../../cache/' . $cacheKey .  '.json';
        file_put_contents($cacheFile, $content);

        return $this;
    }
}
