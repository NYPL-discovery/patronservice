<?php
namespace NYPL\Services\Model\ModelTrait;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use NYPL\Services\Model\DataModel\BaseCardCreatorRequest;
use NYPL\Starter\Config;
use NYPL\Starter\APIException;

trait CardCreatorTrait
{
    protected static $timeoutSeconds = 10;

    protected static $httpAction = 'POST';

    /**
     * @return string
     */
    abstract public function getCardCreatorPath();

    /**
     * @var BaseCardCreatorRequest
     */
    private $request;

    /**
     * @param string $path
     * @param bool $ignoreNoRecord
     * @param array $headers
     *
     * @return string
     * @throws APIException
     */
    protected function sendCreateRequest($path = '', $ignoreNoRecord = false, array $headers = [])
    {
        $client = new Client();

        try {
            $request = $client->request(
                self::$httpAction,
                Config::get('CARD_CREATOR_BASE_API_URL') . '/' . $path,
                [
                    'verify' => false,
                    'timeout' => self::$timeoutSeconds,
                    'auth' => [
                        Config::get('CARD_CREATOR_USERNAME', null, true),
                        Config::get('CARD_CREATOR_PASSWORD', null, true)
                    ],
                    'json' => $this->getRequest()
                ]
            );
        } catch (ClientException $clientException) {
            if (!$ignoreNoRecord) {
                throw $clientException;
            }
        }

        return (string) $request->getBody();
    }

    /**
     * @return BaseCardCreatorRequest
     */
    public function getRequest()
    {
        return $this->request;
    }

    /**
     * @param BaseCardCreatorRequest $request
     */
    public function setRequest(BaseCardCreatorRequest $request)
    {
        $this->request = $request;
    }
}
