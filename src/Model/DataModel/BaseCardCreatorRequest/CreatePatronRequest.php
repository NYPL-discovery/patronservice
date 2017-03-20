<?php
namespace NYPL\Services\Model\DataModel\BaseCardCreatorRequest;

use NYPL\Services\Model\DataModel\BaseCardCreatorRequest;

/**
 * @SWG\Definition(title="CreatePatronRequest", type="object")
 */
class CreatePatronRequest extends BaseCardCreatorRequest
{
    /**
     * @SWG\Property(example="John Jacob Jingleheimer Schmidt")
     * @var string
     */
    public $name = '';

    /**
     * @SWG\Property(example="jjjs9000@gmail.com")
     * @var string
     */
    public $email = '';

    /**
     * @SWG\Property
     * @var ValidateAddressFields
     */
    public $address = '';

    /**
     * @SWG\Property(example="jjjs9000")
     * @var string
     */
    public $username = '';

    /**
     * @SWG\Property(example="nypltest1")
     * @var 1234
     */
    public $pin = '';

    /**
     * @SWG\Property
     * @var ValidateAddressFields
     */
    public $work_or_school_address;

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param string $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
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
     * @return mixed
     */
    public function getPin()
    {
        return $this->pin;
    }

    /**
     * @param mixed $pin
     */
    public function setPin($pin)
    {
        $this->pin = $pin;
    }

    /**
     * @return ValidateAddressFields
     */
    public function getWorkOrSchoolAddress()
    {
        return $this->work_or_school_address;
    }

    /**
     * @param ValidateAddressFields $work_or_school_address
     */
    public function setWorkOrSchoolAddress(ValidateAddressFields $work_or_school_address)
    {
        $this->work_or_school_address = $work_or_school_address;
    }

    /**
     * @param array|string $data
     *
     * @return ValidateAddressFields
     */
    public function translateWorkOrSchoolAddress($data)
    {
        if ($data) {
            return new ValidateAddressFields($data, true);
        }
    }
}
