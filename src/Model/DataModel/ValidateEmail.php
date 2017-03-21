<?php
namespace NYPL\Services\Model\DataModel;

use NYPL\Services\Model\DataModel;

/**
 * @SWG\Definition(title="ValidateEmail", type="object")
 */
class ValidateEmail extends DataModel
{
    /**
     * @SWG\Property
     * @var bool
     */
    public $valid = false;

    /**
     * @SWG\Property(type="array", @SWG\Items(type="string"))
     * @var array
     */
    public $patronIds = '';

    /**
     * @SWG\Property(example="Email address is valid.")
     * @var string
     */
    public $message = '';

    /**
     * @param bool $valid
     * @param array $patronIds
     * @param string $message
     */
    public function __construct($valid = false, array $patronIds = [], $message = '')
    {
        $this->setValid($valid);
        $this->setPatronIds($patronIds);
        $this->setMessage($message);
    }

    /**
     * @return bool
     */
    public function isValid()
    {
        return $this->valid;
    }

    /**
     * @param bool $valid
     */
    public function setValid($valid)
    {
        $this->valid = $valid;
    }

    /**
     * @return array
     */
    public function getPatronIds()
    {
        return $this->patronIds;
    }

    /**
     * @param array $patronIds
     */
    public function setPatronIds($patronIds)
    {
        $this->patronIds = $patronIds;
    }

    /**
     * @return string
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * @param string $message
     */
    public function setMessage($message)
    {
        $this->message = $message;
    }
}
