<?php
namespace NYPL\Services\Controller;

use NYPL\Services\Model\DataModel\PatronSet;
use NYPL\Services\Model\DataModel\PatronValidation;
use NYPL\Services\Model\DataModel\Query\PatronEmailQuery;
use NYPL\Services\Model\DataModel\Query\PatronUsernameQuery;
use NYPL\Services\Model\Response\SuccessResponse\PatronsResponse;
use NYPL\Services\Model\Response\PatronValidationResponse;
use NYPL\Starter\APIException;
use NYPL\Starter\Controller;
use NYPL\Starter\Filter;
use NYPL\Services\Model\DataModel\BasePatron\Patron;
use NYPL\Services\Model\Response\SuccessResponse\PatronResponse;

class PatronController extends Controller
{
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
     *         name="username",
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
     *             "api_auth": {"openid read:patron"}
     *         }
     *     }
     * )
     * @throws APIException
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

        if ($username = $this->getRequest()->getQueryParam('username')) {
            $patronQuery = new PatronUsernameQuery();
            $patronQuery->setUsername($username);
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
     *             "api_auth": {"openid read:patron"}
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

    /**
     * @SWG\Post(
     *     path="/v0.1/patrons/validate",
     *     summary="Validate a Patron by barcode and pin",
     *     tags={"patrons"},
     *     operationId="validatePatron",
     *     consumes={"application/json"},
     *     @SWG\Parameter(
     *         name="PatronValidation",
     *         in="body",
     *         description="",
     *         required=true,
     *         @SWG\Schema(ref="#/definitions/PatronValidation")
     *     ),
     *     @SWG\Response(
     *         response=200,
     *         description="Successful operation",
     *         @SWG\Schema(ref="#/definitions/PatronValidationResponse")
     *     ),
     *     @SWG\Response(
     *         response="400",
     *         description="Bad request",
     *         @SWG\Schema(ref="#/definitions/ErrorResponse")
     *     ),
     *     @SWG\Response(
     *         response="500",
     *         description="Generic server error",
     *         @SWG\Schema(ref="#/definitions/ErrorResponse")
     *     ),
     *     security={
     *         {
     *             "api_auth": {"openid read:patron"}
     *         }
     *     }
     * )
     * @throws \RuntimeException|APIException
     */
    public function validatePatron()
    {
        $patronValidation = new PatronValidation((string) $this->getRequest()->getBody(), true);

        if (!$patronValidation->getBarcode()) {
            throw new APIException('Invalid barcode provided', null, 0, null, 400);
        }

        if (!$patronValidation->getPin()) {
            throw new APIException('Invalid pin provided', null, 0, null, 400);
        }

        if ($patronValidation->isValid()) {
            return $this->getResponse()->withJson(
                new PatronValidationResponse(
                    true,
                    'Successfully validated patron with barcode ' . $patronValidation->getBarcode()
                )
            );
        }

        return $this->getResponse()->withJson(
            new PatronValidationResponse(false, 'Invalid patron barcode and/or pin')
        );
    }
}
