<?php
namespace NYPL\Services\Model\Response\SuccessResponse;

use NYPL\Services\Model\DataModel\BaseCardCreator\ValidateAddress;
use NYPL\Starter\Model\Response\SuccessResponse;

/**
 * @SWG\Definition(title="ValidateAddressResponse", type="object")
 */
class ValidateAddressResponse extends SuccessResponse
{
    /**
     * @SWG\Property
     * @var ValidateAddress
     */
    public $data;
}
