<?php
namespace NYPL\Services\Model\Response;

/**
 * @SWG\Definition(title="PatronValidationResponse", type="object")
 */
class PatronValidationResponse
{
    /**
     * @SWG\Property(example=false)
     * @var bool
     */
    public $valid = false;

    /**
     * @SWG\Property(example="Invalid patron barcode and/or pin", type="string")
     * @var string
     */
    public $message = '';

    /**
     * @param bool $valid
     * @param string $message
     */
    public function __construct($valid = false, $message = '')
    {
        $this->setValid($valid);

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
        $this->valid = (bool) $valid;
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
