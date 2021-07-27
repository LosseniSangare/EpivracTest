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
 * @desc: API Response of Trusted Shops
 */
class TSApiResponse
{
    private $status;

    private $errors = array();

    private $content;

    public function __construct($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * @desc: get status
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * @desc: is success
     *
     * @return: boolean
     */
    public function isSuccess()
    {
        if ($this->status == 'success') {
            return true;
        }

        return false;
    }

    /**
     * @desc: get status
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @desc: add error
     */
    public function addError($error)
    {
        $this->errors[] = $error;

        return $this;
    }

    /**
     * @desc: get errors
     */
    public function getErrors()
    {
        return $this->errors;
    }

    /**
     * @desc: set content
     */
    public function setContent($content)
    {
        $this->content = $content;

        return $this;
    }

    /**
     * @desc: get content
     */
    public function getContent()
    {
        return $this->content;
    }
}
