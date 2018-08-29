<?php
namespace NYPL\Services\Model\DataModel\Query;

use NYPL\Services\Model\DataModel\BasePatron\Patron;
use NYPL\Services\Model\DataModel\Query;

class PatronEmailQuery extends Query
{
    const DEFAULT_LIMIT = 20;

    /**
     * @var string
     */
    protected $email = '';

    /**
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param string $email
     */
    public function setEmail($email = '')
    {
        $this->email = $email;
    }

    /**
     * @return string
     */
    public function getBody()
    {
        return '';
    }

    /**
     * @param string $id
     *
     * @return string
     */
    public function getSierraPath($id = '')
    {
        $query = [
            'varFieldTag' => 'z',
            'varFieldContent' => $this->getEmail(),
            'offset' => 0,
            'limit' => self::DEFAULT_LIMIT,
            'fields' => Patron::FIELDS
        ];

        return 'patrons/find?' . http_build_query($query);
    }
}
