<?php
namespace NYPL\Services\Model\Response\SuccessResponse;

use NYPL\Services\Model\DataModel\BasePatron\Patron;
use NYPL\Starter\Model\Response\SuccessResponse;

/**
 * @SWG\Definition(title="PatronsResponse", type="object")
 */
class PatronsResponse extends SuccessResponse
{
    /**
     * @SWG\Property
     * @var Patron[]
     */
    public $data;
}
