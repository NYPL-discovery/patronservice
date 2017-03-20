<?php
namespace NYPL\Services\Model\DataModel\BaseCardCreatorRequest;

use NYPL\Services\Model\DataModel\BaseCardCreatorRequest;

/**
 * @SWG\Definition(title="ValidateUsernameRequest", type="object")
 */
class ValidateUsernameRequest extends BaseCardCreatorRequest
{
    /**
     * @SWG\Property(example="nypltest1")
     * @var string
     */
    public $username = '';

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
}
