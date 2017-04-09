<?php
namespace NYPL\Services\Model\DataModel\BaseCardCreator;

use NYPL\Services\Model\DataModel\BaseCardCreator;
use NYPL\Services\Model\DataModel\BaseCardCreatorRequest\ValidateAddressFields;

/**
 * @SWG\Definition(title="ValidateAddress", type="object")
 */
class ValidateAddress extends BaseCardCreator
{
    const VALID_TYPE = 'valid-address';

    /**
     * @SWG\Property
     * @var bool
     */
    public $valid = false;

    /**
     * @SWG\Property(example="valid-address")
     * @var string
     */
    public $type = '';

    /**
     * @SWG\Property(example="standard")
     * @var string
     */
    public $card_type = '';

    /**
     * @SWG\Property(example="This valid address will result in a standard library card.")
     * @var string
     */
    public $message = '';

    /**
     * @SWG\Property
     * @var ValidateAddressFields
     */
    public $address;

    /**
     * @SWG\Property
     * @var ValidateAddressFields[]
     */
    public $addresses = [];

    public function getCardCreatorPath()
    {
        return 'validate/address';
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
        if ($type == self::VALID_TYPE) {
            $this->setValid(true);
        }

        $this->type = $type;
    }

    /**
     * @return string
     */
    public function getCardType()
    {
        return $this->card_type;
    }

    /**
     * @param string $card_type
     */
    public function setCardType($card_type)
    {
        $this->card_type = $card_type;
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

    /**
     * @return bool
     */
    public function isValid()
    {
        return $this->valid;
    }

    /**
     * @param bool $valid
     */
    public function setValid($valid)
    {
        $this->valid = (bool) $valid;
    }

    /**
     * @return ValidateAddressFields
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * @param ValidateAddressFields $address
     */
    public function setAddress(ValidateAddressFields $address)
    {
        $this->address = $address;
    }

    /**
     * @param array|string $data
     *
     * @return ValidateAddressFields
     */
    public function translateAddress($data)
    {
        if ($data) {
            return new ValidateAddressFields($data, true);
        }
    }

    /**
     * @return array
     */
    public function getAddresses()
    {
        return $this->addresses;
    }

    /**
     * @param array $addresses
     */
    public function setAddresses(array $addresses = [])
    {
        $this->addresses = $addresses;
    }

    /**
     * @param array|string $data
     *
     * @return ValidateAddressFields[]
     */
    public function translateAddresses($data)
    {
        return $this->translateArray(array_column($data, 'address'), new ValidateAddressFields(), true);
    }

}
