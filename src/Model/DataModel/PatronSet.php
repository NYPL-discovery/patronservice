<?php
namespace NYPL\Services\Model\DataModel;

use NYPL\Starter\Model\ModelTrait\SierraTrait\SierraReadTrait;
use NYPL\Starter\ModelSet;

class PatronSet extends ModelSet
{
    const FIELDS = "id,updatedDate,createdDate,deletedDate,deleted,suppressed,names,barcodes,expirationDate,birthDate,emails,patronType,homeLibraryCode,message,blockInfo,addresses,phones,moneyOwed,fixedFields,varFields";

    use SierraReadTrait;

    /**
     * @return string
     */
    protected function getEndpoint()
    {
        if ($this->getFilters()) {
            foreach ($this->getFilters() as $filter) {
                if ($filter->getFilterColumn() === 'barcode') {
                    return 'patrons/find';
                }
            }
        }

        return 'patrons';
    }

    /**
     * @return string
     */
    public function getSierraPath()
    {
        $query = ["fields" => self::FIELDS];

        if ($this->getFilters()) {
            foreach ($this->getFilters() as $filter) {
                $query[$filter->getFilterColumn()] = $filter->getFilterValue();
            }
        }

        return $this->getEndpoint() . '?' . http_build_query($query);
    }

    public function getIdFields()
    {
        return ["id"];
    }
}
