<?php
namespace NYPL\Services\Test\Model\DataModel\BasePatron;

use NYPL\Services\Model\DataModel\BasePatron\Patron;
use PHPUnit\Framework\TestCase;

class PatronTest extends TestCase
{
    // Barcodes field altered here slightly to match object and Avro schema definition.
    const FIELDS = "id,updatedDate,createdDate,deletedDate,deleted,suppressed,names,barcodes,expirationDate,birthDate,emails,patronType,patronCodes,homeLibraryCode,message,blockInfo,addresses,phones,moneyOwed,fixedFields,varFields";

    public $patron;
    public $schema;

    public function setUp()
    {
        $this->patron = new Patron();
        $this->schema = $this->patron->getSchema();
    }

    /**
     * @covers NYPL\Services\Model\DataModel\BasePatron\Patron::getSchema()
     */
    public function testIfSchemaHasBaseAvroStructure()
    {
        self::assertTrue(is_array($this->schema));
        self::assertArrayHasKey('name', $this->schema);
        self::assertArrayHasKey('type', $this->schema);
        self::assertArrayHasKey('fields', $this->schema);
    }

    /**
     * @covers NYPL\Services\Model\DataModel\BasePatron::setId()
     * @covers NYPL\Services\Model\DataModel\BasePatron::setUpdatedDate()
     * @covers NYPL\Services\Model\DataModel\BasePatron::setCreatedDate()
     * @covers NYPL\Services\Model\DataModel\BasePatron::setDeletedDate()
     * @covers NYPL\Services\Model\DataModel\BasePatron::setDeleted()
     * @covers NYPL\Services\Model\DataModel\BasePatron::setSuppressed()
     * @covers NYPL\Services\Model\DataModel\BasePatron::setNames()
     * @covers NYPL\Services\Model\DataModel\BasePatron::setBarCodes()
     * @covers NYPL\Services\Model\DataModel\BasePatron::setExpirationDate()
     * @covers NYPL\Services\Model\DataModel\BasePatron::setHomeLibraryCode()
     * @covers NYPL\Services\Model\DataModel\BasePatron::setBirthDate()
     * @covers NYPL\Services\Model\DataModel\BasePatron::setFixedFields()
     * @covers NYPL\Services\Model\DataModel\BasePatron::setVarFields()
     * @covers NYPL\Services\Model\DataModel\FixedField::setLabel()
     * @covers NYPL\Services\Model\DataModel\FixedField::setValue()
     * @covers NYPL\Services\Model\DataModel\FixedField::setDisplay()
     * @covers NYPL\Services\Model\DataModel\SubField::setTag()
     * @covers NYPL\Services\Model\DataModel\SubField::setContent()
     * @covers NYPL\Services\Model\DataModel\VarField::setFieldTag()
     * @covers NYPL\Services\Model\DataModel\VarField::setMarcTag()
     * @covers NYPL\Services\Model\DataModel\VarField::setInd1()
     * @covers NYPL\Services\Model\DataModel\VarField::setInd2()
     * @covers NYPL\Services\Model\DataModel\VarField::setContent()
     * @covers NYPL\Services\Model\DataModel\VarField::setSubfields()
     */
    public function testIfPatronObjectContainsAllDefinedFields()
    {
        $extraFields = ['patronType','patronCodes','message','blockInfo','addresses','phones','moneyOwed'];
        $data = json_decode(file_get_contents(__DIR__ . '/../../../Stubs/sample_patron_sierra.json'), true);
        $patron = new Patron($data);
        $fields = explode(',', self::FIELDS);
        foreach ($fields as $field) {
            if (!in_array($field, $extraFields)) {
                // Reset barcodes to barCodes as per model definition.
                if ($field == 'barcodes') {
                    $field = 'barCodes';
                }
                self::assertClassHasAttribute($field, get_class($patron));
            }
        }
    }
}
