<?php
namespace NYPL\Services\Controller;

use NYPL\Services\Model\DataModel\BaseCardCreator\ValidateAddress;
use NYPL\Services\Model\DataModel\BaseCardCreatorRequest\ValidateAddressRequest;
use NYPL\Services\Model\DataModel\BaseCardCreatorRequest\ValidateUsernameRequest;
use NYPL\Services\Model\Response\SuccessResponse\ValidateAddressResponse;
use NYPL\Services\Model\Response\SuccessResponse\ValidateUsernameResponse;
use NYPL\Starter\Controller;
use NYPL\Services\Model\DataModel\BaseCardCreator\ValidateUsername;

final class ValidationController extends Controller
{
    /**
     * @SWG\Tag(
     *   name="validations",
     *   description="Validation API"
     * )
     */

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
     *     path="/v0.1/validations/username",
     *     summary="Create a Patron username validation",
     *     tags={"validations"},
     *     operationId="validateUsername",
     *     consumes={"application/json"},
     *     produces={"application/json"},
     *     description="See https://github.com/NYPL-Simplified/card-creator/wiki/API#post-v1validateusername for additional documentation.",
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
    public function validateUsername()
    {
        $validateUsername = $this->getValidateUsername($this->getRequest()->getParsedBody());

        return $this->getResponse()->withJson(
            new ValidateUsernameResponse($validateUsername)
        );
    }

    /**
     * @SWG\Post(
     *     path="/v0.1/validations/address",
     *     summary="Create an address validation",
     *     tags={"validations"},
     *     operationId="validateAddress",
     *     consumes={"application/json"},
     *     produces={"application/json"},
     *     description="See https://github.com/NYPL-Simplified/card-creator/wiki/API#post-v1validateaddress for additional documentation.",
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
    public function validateAddress()
    {
        $validateAddress = $this->getValidateAddress($this->getRequest()->getParsedBody());

        return $this->getResponse()->withJson(
            new ValidateAddressResponse($validateAddress)
        );
    }
}
