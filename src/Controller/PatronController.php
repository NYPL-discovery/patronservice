<?php
namespace NYPL\Services\Controller;

use NYPL\Services\Model\DataModel\BaseCardCreator\CreatePatron;
use NYPL\Services\Model\DataModel\BaseCardCreator\ValidateAddress;
use NYPL\Services\Model\DataModel\BaseCardCreatorRequest\CreatePatronRequest;
use NYPL\Services\Model\DataModel\BaseCardCreatorRequest\ValidateAddressRequest;
use NYPL\Services\Model\DataModel\BaseCardCreatorRequest\ValidateUsernameRequest;
use NYPL\Services\Model\DataModel\PatronSet;
use NYPL\Services\Model\DataModel\Query\PatronQuery;
use NYPL\Services\Model\Response\SuccessResponse\PatronsResponse;
use NYPL\Services\Model\Response\SuccessResponse\ValidateAddressResponse;
use NYPL\Services\Model\Response\SuccessResponse\ValidateUsernameResponse;
use NYPL\Starter\Controller;
use NYPL\Starter\Filter;
use NYPL\Starter\Filter\QueryFilter;
use NYPL\Services\Model\DataModel\BasePatron\Patron;
use NYPL\Services\Model\Response\SuccessResponse\PatronResponse;
use NYPL\Services\Model\DataModel\BaseCardCreator\ValidateUsername;

final class PatronController extends Controller
{
    /**
     * @param array $data
     *
     * @return ValidateUsername
     */
    protected function getValidateUsername(array $data = [])
    {
        $model = new ValidateUsername();
        $model->setRequest(new ValidateUsernameRequest($data));
        $model->create();

        return $model;
    }

    /**
     * @param array $data
     *
     * @return ValidateAddress
     */
    protected function getValidateAddress(array $data = [])
    {
        $model = new ValidateAddress();
        $model->setRequest(new ValidateAddressRequest($data));
        $model->create();

        return $model;
    }

    /**
     * @SWG\Post(
     *     path="/v0.1/patrons",
     *     summary="Create a Patron",
     *     tags={"patrons"},
     *     operationId="createPatron",
     *     consumes={"application/json"},
     *     produces={"application/json"},
     *     @SWG\Parameter(
     *         name="CreatePatronRequest",
     *         in="body",
     *         description="",
     *         required=true,
     *         @SWG\Schema(ref="#/definitions/CreatePatronRequest"),
     *     ),
     *     @SWG\Response(
     *         response=200,
     *         description="Successful operation",
     *         @SWG\Schema(ref="#/definitions/PatronResponse")
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
     *             "api_auth": {"openid offline_access api"}
     *         }
     *     }
     * )
     */
    public function createPatron()
    {
        $createPatron = new CreatePatron();
        $createPatron->setRequest(
            new CreatePatronRequest($this->getRequest()->getParsedBody())
        );
        $createPatron->create();

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

        return $this->getResponse()->withJson(
            new PatronResponse($patron)
        );
    }

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
            $patronQuery = new PatronQuery();
            $patronQuery->setEmail($email);
            $patronQuery->read();

            return $this->getDefaultReadResponse(
                new PatronSet(new Patron(), true),
                new PatronsResponse(),
                new Filter\QueryFilter('id', current($patronQuery->getIds()))
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

    /**
     * @SWG\Post(
     *     path="/v0.1/patrons/validate/username",
     *     summary="Create a Patron username validation request",
     *     tags={"patrons"},
     *     operationId="validateUsername",
     *     consumes={"application/json"},
     *     produces={"application/json"},
     *     @SWG\Parameter(
     *         name="ValidateUsernameRequest",
     *         in="body",
     *         description="",
     *         required=true,
     *         @SWG\Schema(ref="#/definitions/ValidateUsernameRequest"),
     *     ),
     *     @SWG\Response(
     *         response=200,
     *         description="Successful operation",
     *         @SWG\Schema(ref="#/definitions/ValidateUsernameResponse")
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
    public function validateUsername()
    {
        $validateUsername = $this->getValidateUsername($this->getRequest()->getParsedBody());

        return $this->getResponse()->withJson(
            new ValidateUsernameResponse($validateUsername)
        );
    }

    /**
     * @SWG\Post(
     *     path="/v0.1/patrons/validate/address",
     *     summary="Create a Patron address validation request",
     *     tags={"patrons"},
     *     operationId="validateAddress",
     *     consumes={"application/json"},
     *     produces={"application/json"},
     *     @SWG\Parameter(
     *         name="ValidateAddressRequest",
     *         in="body",
     *         description="",
     *         required=true,
     *         @SWG\Schema(ref="#/definitions/ValidateAddressRequest"),
     *     ),
     *     @SWG\Response(
     *         response=200,
     *         description="Successful operation",
     *         @SWG\Schema(ref="#/definitions/ValidateAddressResponse")
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
    public function validateAddress()
    {
        $validateAddress = $this->getValidateAddress($this->getRequest()->getParsedBody());

        return $this->getResponse()->withJson(
            new ValidateAddressResponse($validateAddress)
        );
    }
}
