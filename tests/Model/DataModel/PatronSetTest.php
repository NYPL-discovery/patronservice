<?php
namespace NYPL\Services\Test\Model\DataModel;

use NYPL\Services\Model\DataModel\BasePatron\Patron;
use NYPL\Services\Model\DataModel\PatronSet;
use PHPUnit\Framework\TestCase;

class PatronSetTest extends TestCase
{
    const FIELDS = "id,updatedDate,createdDate,deletedDate,deleted,suppressed,names,barcodes,expirationDate,birthDate,emails,patronType,patronCodes,homeLibraryCode,message,blockInfo,addresses,phones,moneyOwed,fixedFields,varFields";

    public $patronSet;

    public function setUp()
    {
        $this->patronSet = new PatronSet(new Patron());
    }

    /**
     * @covers NYPL\Services\Model\DataModel\PatronSet::getSierraPath()
     */
    public function testIfPathIncludesAllRetrievableFields()
    {
        $path = $this->patronSet->getSierraPath();

        self::assertContains(urlencode(self::FIELDS), $path);
    }
}
