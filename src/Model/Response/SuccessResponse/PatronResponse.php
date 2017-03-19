<?php
namespace NYPL\Services\Model\Response\SuccessResponse;

use NYPL\Services\Model\DataModel\BasePatron\Patron;
use NYPL\Starter\Model\Response\SuccessResponse;

/**
 * @SWG\Definition(title="PatronResponse", type="object")
 */
class PatronResponse extends SuccessResponse
{
    /**
     * @SWG\Property
     * @var Patron
     */
    public $data;
}
