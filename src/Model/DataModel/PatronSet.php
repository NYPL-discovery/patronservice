<?php
namespace NYPL\Services\Model\DataModel;

use NYPL\Starter\APILogger;
use NYPL\Starter\Filter;
use NYPL\Starter\Model\ModelTrait\SierraTrait\SierraReadTrait;
use NYPL\Starter\ModelSet;

class PatronSet extends ModelSet
{
    const FIELDS = "id,updatedDate,createdDate,deletedDate,deleted,suppressed,names,barcodes,expirationDate,birthDate,emails,patronType,patronCodes,homeLibraryCode,message,blockInfo,addresses,phones,moneyOwed,fixedFields,varFields";

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
                if ($filter->getFilterColumn() === 'username') {
                    return 'patrons/find';
                }
                if ($filter->getFilterColumn() === 'email') {
                    return 'patrons/find';
                }
            }
        }

        return 'patrons';
    }

    /**
     * @param Filter $filter
     *
     * @return array
     */
    protected function getQueryParamter(Filter $filter) {
        if ($filter->getFilterColumn() === 'email') {
            return [
                'varFieldTag' => 'z',
                'varFieldContent' => $filter->getFilterValue()
            ];
        }

        if ($filter->getFilterColumn() === 'username') {
            return [
                'varFieldTag' => 'u',
                'varFieldContent' => $filter->getFilterValue()
            ];
        }

        if ($filter->getFilterColumn() === 'barcode') {
            return [
                'varFieldTag' => 'b',
                'varFieldContent' => $filter->getFilterValue()
            ];
        }

        return [
            $filter->getFilterColumn() => $filter->getFilterValue()
        ];
    }

    /**
     * @return string
     */
    public function getSierraPath()
    {
        $query = ['fields' => self::FIELDS];

        if ($this->getFilters()) {
            foreach ($this->getFilters() as $filter) {
                $query = array_merge($query, $this->getQueryParamter($filter));
            }
        }

        return $this->getEndpoint() . '?' . http_build_query($query);
    }

    public function getIdFields()
    {
        return ['id'];
    }
}
