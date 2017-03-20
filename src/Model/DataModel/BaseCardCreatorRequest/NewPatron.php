<?php
namespace NYPL\Services\Model\DataModel\BaseCardCreatorRequest;

use NYPL\Services\Model\DataModel\BaseCardCreatorRequest;

/**
 * @SWG\Definition(title="NewPatron", type="object")
 */
class NewPatron extends BaseCardCreatorRequest
{
    /**
     * @SWG\Property
     * @var SimplePatron
     */
    public $simplePatron;

    /**
     * @return SimplePatron
     */
    public function getSimplePatron()
    {
        return $this->simplePatron;
    }

    /**
     * @param SimplePatron $simplePatron
     */
    public function setSimplePatron(SimplePatron $simplePatron)
    {
        $this->simplePatron = $simplePatron;
    }

    /**
     * @param array|string $data
     *
     * @return SimplePatron
     */
    public function translateQuickRequest($data)
    {
        if ($data) {
            return new SimplePatron($data, true);
        }
    }
}
