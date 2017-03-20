<?php
namespace NYPL\Services\Model\ModelTrait\SierraTrait;

use NYPL\Services\Model\ModelTrait\CardCreatorTrait;
use NYPL\Starter\APIException;

trait CardCreatorCreateTrait
{
    use CardCreatorTrait;

    /**
     * @param bool $ignoreNoRecord
     *
     * @return string
     */
    protected function getResponse($ignoreNoRecord = false)
    {
        return $this->sendCreateRequest(
            $this->getCardCreatorPath(),
            $ignoreNoRecord
        );
    }

    /**
     * @param bool $ignoreNoRecord
     *
     * @return bool
     * @throws APIException
     */
    public function create($ignoreNoRecord = false)
    {
        $response = $this->getResponse($ignoreNoRecord);

        $data = json_decode($response, true);

        $this->translate($data);

        return true;
    }
}
