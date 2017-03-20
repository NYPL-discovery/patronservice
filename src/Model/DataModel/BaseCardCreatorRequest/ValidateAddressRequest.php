<?php
namespace NYPL\Services\Model\DataModel\BaseCardCreatorRequest;

use NYPL\Services\Model\DataModel\BaseCardCreatorRequest;

/**
 * @SWG\Definition(title="ValidateAddressRequest", type="object")
 */
class ValidateAddressRequest extends BaseCardCreatorRequest
{
    /**
     * @SWG\Property
     * @var ValidateAddressFields
     */
    public $address;

    /**
     * @SWG\Property(example=false)
     * @var bool
     */
    public $is_work_or_school_address = false;

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
     * @return bool
     */
    public function isIsWorkOrSchoolAddress()
    {
        return $this->is_work_or_school_address;
    }

    /**
     * @param bool $is_work_or_school_address
     */
    public function setIsWorkOrSchoolAddress($is_work_or_school_address)
    {
        $this->is_work_or_school_address = (bool) $is_work_or_school_address;
    }
}
