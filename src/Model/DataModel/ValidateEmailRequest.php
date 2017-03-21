<?php
namespace NYPL\Services\Model\DataModel;

use NYPL\Services\Model\DataModel;

/**
 * @SWG\Definition(title="ValidateEmailRequest", type="object")
 */
class ValidateEmailRequest extends DataModel
{
    /**
     * @SWG\Property(example="fred@flintstone.com")
     * @var string
     */
    public $email = '';

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
}
