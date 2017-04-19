<?php
namespace NYPL\Services\Controller;

use GuzzleHttp\Exception\ClientException;
use NYPL\Services\Model\DataModel\BaseCardCreator\CreatePatron;
use NYPL\Services\Model\DataModel\BaseCardCreatorRequest\SimplePatron;
use NYPL\Services\Model\DataModel\PatronSet;
use NYPL\Services\Model\DataModel\Query\PatronEmailQuery;
use NYPL\Services\Model\Response\ErrorResponse\CreatePatronErrorResponse;
use NYPL\Services\Model\Response\SuccessResponse\PatronsResponse;
use NYPL\Starter\APIException;
use NYPL\Starter\Controller;
use NYPL\Starter\Filter;
use NYPL\Starter\Filter\QueryFilter;
use NYPL\Services\Model\DataModel\BasePatron\Patron;
use NYPL\Services\Model\Response\SuccessResponse\PatronResponse;

final class PatronController extends Controller
{
    /**
     * @SWG\Tag(
     *   name="patrons",
     *   description="Patron API"
     * )
     */

    /**
     * @param array $data
     *
     * @return CreatePatron
     * @throws APIException
     */
    protected function getCreatePatron(array $data = [])
    {
        $createPatron = new CreatePatron();

        if (isset($data['simplePatron'])) {
            $createPatron->setRequest(
                new SimplePatron($data['simplePatron'])
            );
        }


        try {
            $createPatron->create();
        } catch (ClientException $exception) {
            $errorResponse = new CreatePatronErrorResponse();

            $responseBody = json_decode($exception->getResponse()->getBody(), true);

            if (isset($responseBody['detail'], $responseBody['debug_message'], $responseBody['title'])) {
                $errorResponse->setDebugTitle($responseBody['title']);
                $errorResponse->setDebugMessage($responseBody['debug_message']);

                throw new APIException(
                    $responseBody['detail'],
                    null,
                    0,
                    null,
                    $exception->getResponse()->getStatusCode(),
                    $errorResponse
                );
            }

            throw new APIException(
                $exception->getMessage(),
                null,
                0,
                null,
                $exception->getResponse()->getStatusCode(),
                $errorResponse
            );
        }

        return $createPatron;
    }

    /**
     * @param CreatePatron $createPatron
     *
     * @return Patron
     */
    protected function getAndCreatePatron(CreatePatron $createPatron)
    {
        $patrons = new PatronSet(new Patron(), true);
        $patrons->addFilter(
            new QueryFilter('barcode', $createPatron->getBarcode())
        );
        $patrons->read();

        /**
         * @var Patron $patron
         */
        $patron = current($patrons->getData());
        $patron->create();

        return $patron;
    }

//    /**
//     * @SWG\Post(
//     *     path="/v0.1/patrons",
//     *     summary="Create a Patron",
//     *     tags={"patrons"},
//     *     operationId="createPatron",
//     *     consumes={"application/json"},
//     *     produces={"application/json"},
//     *     description="See https://github.com/NYPL-Simplified/card-creator/wiki/API#post-v1create_patron for additional documentation.",
//     *     @SWG\Parameter(
//     *         name="NewPatron",
//     *         in="body",
//     *         description="",
//     *         required=true,
//     *         @SWG\Schema(ref="#/definitions/NewPatron"),
//     *     ),
//     *     @SWG\Response(
//     *         response=200,
//     *         description="Successful operation",
//     *         @SWG\Schema(ref="#/definitions/PatronResponse")
//     *     ),
//     *     @SWG\Response(
//     *         response="400",
//     *         description="Bad request",
//     *         @SWG\Schema(ref="#/definitions/CreatePatronErrorResponse")
//     *     ),
//     *     @SWG\Response(
//     *         response="500",
//     *         description="Generic server error",
//     *         @SWG\Schema(ref="#/definitions/ErrorResponse")
//     *     ),
//     *     security={
//     *         {
//     *             "api_auth": {"openid offline_access api"}
//     *         }
//     *     }
//     * )
//     */
//    public function createPatron()
//    {
//        $createPatron = $this->getCreatePatron($this->getRequest()->getParsedBody());
//
//        $patron = $this->getAndCreatePatron($createPatron);
//
//        return $this->getResponse()->withJson(
//            new PatronResponse($patron)
//        );
//    }

    /**
     * @SWG\Get(
     *     path="/v0.1/patrons",
     *     summary="Get Patrons",
     *     tags={"patrons"},
     *     operationId="getPatrons",
     *     consumes={"application/json"},
     *     produces={"application/json"},
     *     @SWG\Parameter(
     *         in="query",
     *         name="id",
     *         required=false,
     *         type="string",
     *         format="string"
     *     ),
     *     @SWG\Parameter(
     *         in="query",
     *         name="barcode",
     *         required=false,
     *         type="string",
     *         format="string"
     *     ),
     *     @SWG\Parameter(
     *         in="query",
     *         name="email",
     *         required=false,
     *         type="string",
     *         format="string"
     *     ),
     *     @SWG\Response(
     *         response=200,
     *         description="Successful operation",
     *         @SWG\Schema(ref="#/definitions/PatronsResponse")
     *     ),
     *     @SWG\Response(
     *         response="404",
     *         description="Not found",
     *         @SWG\Schema(ref="#/definitions/ErrorResponse")
     *     ),
     *     @SWG\Response(
     *         response="500",
     *         description="Generic server error",
     *         @SWG\Schema(ref="#/definitions/ErrorResponse")
     *     ),
     *     security={
     *         {
     *             "api_auth": {"openid offline_access api"}
     *         }
     *     }
     * )
     */
    public function getPatrons()
    {
        if ($email = $this->getRequest()->getQueryParam('email')) {
            $patronQuery = new PatronEmailQuery();
            $patronQuery->setEmail($email);
            $patronQuery->read();

            return $this->getDefaultReadResponse(
                new PatronSet(new Patron(), true),
                new PatronsResponse(),
                new Filter\QueryFilter(
                    'id',
                    implode(',', $patronQuery->getIds())
                )
            );
        }

        return $this->getDefaultReadResponse(
            new PatronSet(new Patron(), true),
            new PatronsResponse(),
            null,
            ['id', 'barcode']
        );
    }

    /**
     * @SWG\Get(
     *     path="/v0.1/patrons/{id}",
     *     summary="Get a Patron",
     *     tags={"patrons"},
     *     operationId="getPatron",
     *     consumes={"application/json"},
     *     produces={"application/json"},
     *     @SWG\Parameter(
     *         description="ID of Patron",
     *         in="path",
     *         name="id",
     *         required=true,
     *         type="string",
     *         format="string"
     *     ),
     *     @SWG\Response(
     *         response=200,
     *         description="Successful operation",
     *         @SWG\Schema(ref="#/definitions/PatronResponse")
     *     ),
     *     @SWG\Response(
     *         response="404",
     *         description="Not found",
     *         @SWG\Schema(ref="#/definitions/ErrorResponse")
     *     ),
     *     @SWG\Response(
     *         response="500",
     *         description="Generic server error",
     *         @SWG\Schema(ref="#/definitions/ErrorResponse")
     *     ),
     *     security={
     *         {
     *             "api_auth": {"openid offline_access api"}
     *         }
     *     }
     * )
     */
    public function getPatron($id)
    {
        return $this->getDefaultReadResponse(
            new Patron(),
            new PatronResponse(),
            new Filter(null, null, false, $id)
        );
    }
}
