<?php
namespace NYPL\Services\Model\Response\SuccessResponse;

use NYPL\Services\Model\DataModel\ValidateEmail;
use NYPL\Starter\Model\Response\SuccessResponse;

/**
 * @SWG\Definition(title="ValidateEmailResponse", type="object")
 */
class ValidateEmailResponse extends SuccessResponse
{
    /**
     * @SWG\Property
     * @var ValidateEmail
     */
    public $data;
}
