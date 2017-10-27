<?php
namespace NYPL\Services\Controller;

use NYPL\Services\Model\DataModel\PatronSet;
use NYPL\Services\Model\DataModel\Query\PatronEmailQuery;
use NYPL\Services\Model\Response\SuccessResponse\PatronsResponse;
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
     *             "api_auth": {"openid offline_access api read:patron readwrite:patron"}
     *         }
     *     }
     * )
     */
    public function getPatrons()
    {
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
     *             "api_auth": {"openid offline_access api read:patron readwrite:patron"}
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
