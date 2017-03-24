<?php
namespace NYPL\Services\Model\Response\ErrorResponse;

use NYPL\Starter\Model\Response\ErrorResponse;

/**
 * @SWG\Definition(title="CreatePatronErrorResponse", type="object")
 */
class CreatePatronErrorResponse extends ErrorResponse
{
    /**
     * @SWG\Property(example="Invalid request.")
     * @var string
     */
    public $debugTitle = '';

    /**
     * @SWG\Property(example="{""username"":[""Username has not been validated.""]}")
     * @var string
     */
    public $debugMessage = '';

    /**
     * @return string
     */
    public function getDebugMessage()
    {
        return $this->debugMessage;
    }

    /**
     * @param string $debugMessage
     */
    public function setDebugMessage($debugMessage)
    {
        $this->debugMessage = $debugMessage;
    }

    /**
     * @return string
     */
    public function getDebugTitle()
    {
        return $this->debugTitle;
    }

    /**
     * @param string $debugTitle
     */
    public function setDebugTitle($debugTitle)
    {
        $this->debugTitle = $debugTitle;
    }
}
