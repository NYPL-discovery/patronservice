<?php
namespace NYPL\Services\Model\DataModel;

use NYPL\Starter\APIException;
use NYPL\Starter\Model;
use NYPL\Starter\Model\ModelTrait;

/**
 * @SWG\Definition(type="object")
 */
class PatronValidation extends Model
{
    use ModelTrait\TranslateTrait, ModelTrait\SierraTrait\SierraReadTrait;

    public function getSierraPath()
    {
        return 'patrons/validate';
    }

    public function getRequestType()
    {
        return 'POST';
    }

    /**
     * @SWG\Property(example="343423492357719")
     * @var string
     */
    public $barcode;

    /**
     * @SWG\Property(example="1235")
     * @var string
     */
    public $pin;

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
    public function isValid()
    {
        $this->setBody(json_encode($this));

        try {
            $this->sendRequest(
                $this->getSierraPath(),
                false,
                ['Content-Type' => 'application/json']
            );

            return true;
        } catch (APIException $exception) {
            return false;
        }
    }
}
