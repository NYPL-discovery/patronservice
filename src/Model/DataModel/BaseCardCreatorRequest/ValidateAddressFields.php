<?php
namespace NYPL\Services\Model\DataModel\BaseCardCreatorRequest;

use NYPL\Services\Model\DataModel\BaseCardCreatorRequest;

/**
 * @SWG\Definition(title="ValidateAddressFields", type="object")
 */
class ValidateAddressFields extends BaseCardCreatorRequest
{
    /**
     * @SWG\Property(example="123 Fake St")
     * @var string
     */
    public $line_1 = '';

    /**
     * @SWG\Property(example="Apt. 33A")
     * @var string
     */
    public $line_2 = '';

    /**
     * @SWG\Property(example="Springfield")
     * @var string
     */
    public $city = '';

    /**
     * @SWG\Property(example="VT")
     * @var string
     */
    public $state = '';

    /**
     * @SWG\Property(example="05150")
     * @var string
     */
    public $zip = '';

    /**
     * @return string
     */
    public function getLine1()
    {
        return $this->line_1;
    }

    /**
     * @param string $line_1
     */
    public function setLine1($line_1)
    {
        $this->line_1 = $line_1;
    }

    /**
     * @return string
     */
    public function getLine2()
    {
        return $this->line_2;
    }

    /**
     * @param string $line_2
     */
    public function setLine2($line_2)
    {
        $this->line_2 = $line_2;
    }

    /**
     * @return string
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * @param string $city
     */
    public function setCity($city)
    {
        $this->city = $city;
    }

    /**
     * @return string
     */
    public function getState()
    {
        return $this->state;
    }

    /**
     * @param string $state
     */
    public function setState($state)
    {
        $this->state = $state;
    }

    /**
     * @return string
     */
    public function getZip()
    {
        return $this->zip;
    }

    /**
     * @param string $zip
     */
    public function setZip($zip)
    {
        $this->zip = $zip;
    }
}
