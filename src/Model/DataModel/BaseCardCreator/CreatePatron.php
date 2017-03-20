<?php
namespace NYPL\Services\Model\DataModel\BaseCardCreator;

use NYPL\Services\Model\DataModel\BaseCardCreator;

/**
 * @SWG\Definition(title="ValidateUsername", type="object")
 */
class CreatePatron extends BaseCardCreator
{
    /**
     * @var string
     */
    public $type = '';

    /**
     * @var string
     */
    public $username = '';

    /**
     * @var string
     */
    public $barcode = '';

    /**
     * @var string
     */
    public $pin = '';

    /**
     * @var bool
     */
    public $temporary = false;

    /**
     * @var string
     */
    public $message = '';

    public function getCardCreatorPath()
    {
        return 'create_patron';
    }

    /**
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param string $type
     */
    public function setType($type)
    {
        $this->type = $type;
    }

    /**
     * @return string
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * @param string $username
     */
    public function setUsername($username)
    {
        $this->username = $username;
    }

    /**
     * @return string
     */
    public function getBarcode()
    {
        return $this->barcode;
    }

    /**
     * @param string $barcode
     */
    public function setBarcode($barcode)
    {
        $this->barcode = $barcode;
    }

    /**
     * @return string
     */
    public function getPin()
    {
        return $this->pin;
    }

    /**
     * @param string $pin
     */
    public function setPin($pin)
    {
        $this->pin = $pin;
    }

    /**
     * @return bool
     */
    public function isTemporary()
    {
        return $this->temporary;
    }

    /**
     * @param bool $temporary
     */
    public function setTemporary($temporary)
    {
        $this->temporary = (bool) $temporary;
    }

    /**
     * @return string
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * @param string $message
     */
    public function setMessage($message)
    {
        $this->message = $message;
    }
}
