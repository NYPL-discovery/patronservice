<?php
namespace NYPL\Services\Model\DataModel\BaseCardCreator;

use NYPL\Services\Model\DataModel\BaseCardCreator;

/**
 * @SWG\Definition(title="ValidateUsername", type="object")
 */
class ValidateUsername extends BaseCardCreator
{
    const VALID_TYPE = 'available-username';

    /**
     * @SWG\Property
     * @var bool
     */
    public $valid = false;

    /**
     * @SWG\Property(example="available-username")
     * @var string
     */
    public $type = '';

    /**
     * @SWG\Property(example="standard")
     * @var string
     */
    public $card_type = '';

    /**
     * @SWG\Property(example="This username is available.")
     * @var string
     */
    public $message = '';

    public function getCardCreatorPath()
    {
        return 'validate/username';
    }

    /**
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param string $type
     */
    public function setType($type)
    {
        if ($type == self::VALID_TYPE) {
            $this->setValid(true);
        }

        $this->type = $type;
    }

    /**
     * @return string
     */
    public function getCardType()
    {
        return $this->card_type;
    }

    /**
     * @param string $card_type
     */
    public function setCardType($card_type)
    {
        $this->card_type = $card_type;
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
}
