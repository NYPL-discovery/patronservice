<?php
namespace NYPL\Services\Model\DataModel\BasePatron;

use NYPL\Services\Model\DataModel\BasePatron;
use NYPL\Starter\Filter;
use NYPL\Starter\Model\ModelInterface\MessageInterface;
use NYPL\Starter\Model\ModelInterface\ReadInterface;
use NYPL\Starter\Model\ModelTrait\CreateTrait;
use NYPL\Starter\Model\ModelTrait\SierraTrait\SierraReadTrait;

/**
 * @SWG\Definition(title="Patron", type="object", required={"id"})
 */
class Patron extends BasePatron implements ReadInterface, MessageInterface
{
    const FIELDS = "id,updatedDate,createdDate,deletedDate,deleted,suppressed,names,barcodes,expirationDate,birthDate,emails,patronType,patronCodes,homeLibraryCode,message,blockInfo,addresses,phones,universityId,moneyOwed,fixedFields,varFields";

    use SierraReadTrait, CreateTrait;

    /**
     * @param string|null $id
     *
     * @return string
     */
    public function getSierraPath($id = null)
    {
        if ($this->getFilters()) {
            $filter = current($this->getFilters());

            if ($filter instanceof Filter) {
                $id = $filter->getId();
            }
        }

        return "patrons/{$this->getSierraId($id)}?" . http_build_query(["fields" => self::FIELDS]);
    }

    public function getCardCreatorPath()
    {
        return 'create_patron';
    }

    public function getIdFields()
    {
        return ["id"];
    }

    public function getSchema()
    {
        return
            [
                "name" => "Patron",
                "type" => "record",
                "fields" => [
                    ["name" => "id", "type" => "string"],
                    ["name" => "updatedDate", "type" => ["string", "null"]],
                    ["name" => "createdDate", "type" => ["string", "null"]],
                    ["name" => "deletedDate", "type" => ["string", "null"]],
                    ["name" => "deleted", "type" => "boolean"],
                    ["name" => "suppressed", "type" => "boolean"],
                    ["name" => "names" , "type" => [
                        "null",
                        ["type" => "array", "items" => "string"],
                    ]],
                    ["name" => "barCodes" , "type" => [
                        "null",
                        ["type" => "array", "items" => "string"],
                    ]],
                    ["name" => "expirationDate", "type" => ["string", "null"]],
                    ["name" => "homeLibraryCode", "type" => ["string", "null"]],
                    ["name" => "birthDate", "type" => ["string", "null"]],
                    ["name" => "emails" , "type" => [
                        "null",
                        ["type" => "array", "items" => "string"],
                    ]],
                    ["name" => "fixedFields" , "type" => [
                        "null",
                        ["type" => "map", "values" => [
                            ["name" => "fixedField", "type" => "record", "fields" => [
                                ["name" => "label", "type" => ["string", "null"]],
                                ["name" => "value", "type" => ["string", "int", "null"]],
                                ["name" => "display", "type" => ["string", "null"]],
                            ]]
                        ]],
                    ]],
                    ["name" => "varFields" , "type" => [
                        "null",
                        ["type" => "array", "items" => [
                            ["name" => "varField", "type" => "record", "fields" => [
                                ["name" => "fieldTag", "type" => ["string", "null"]],
                                ["name" => "marcTag", "type" => ["string", "null"]],
                                ["name" => "ind1", "type" => ["string", "null"]],
                                ["name" => "ind2", "type" => ["string", "null"]],
                                ["name" => "content", "type" => ["string", "null"]],
                                ["name" => "subFields" , "type" => [
                                    "null",
                                    ["type" => "array", "items" => [
                                        ["name" => "subField", "type" => "record", "fields" => [
                                            ["name" => "tag", "type" => ["string", "null"]],
                                            ["name" => "content", "type" => ["string", "null"]],
                                        ]]
                                    ]],
                                ]],
                            ]]
                        ]],
                    ]],
                ]
            ];
    }

    public function create($useId = false)
    {
        $this->publishMessage($this->getObjectName(), $this->createMessage());
    }
}
