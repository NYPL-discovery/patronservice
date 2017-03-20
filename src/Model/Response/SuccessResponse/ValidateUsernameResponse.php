<?php
namespace NYPL\Services\Model\Response\SuccessResponse;

use NYPL\Services\Model\DataModel\BaseCardCreator\ValidateUsername;
use NYPL\Starter\Model\Response\SuccessResponse;

/**
 * @SWG\Definition(title="ValidateUsername", type="object")
 */
class ValidateUsernameResponse extends SuccessResponse
{
    /**
     * @SWG\Property
     * @var ValidateUsername
     */
    public $data;
}
