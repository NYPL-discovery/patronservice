<?php
namespace NYPL\Services\Model\DataModel\Query;

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
        return json_encode([
            'target' => [
                'record' => [
                    'type' => 'patron'
                ],
                'field' => [
                    'tag' => 'z'
                ]
            ],
            'expr' => [
                'op' => 'equals',
                'operands' => [
                    $this->getEmail()
                ]
            ]
        ]);
    }

    /**
     * @param string $id
     *
     * @return string
     */
    public function getSierraPath($id = '')
    {
        $query = [
            'offset' => 0,
            'limit' => self::DEFAULT_LIMIT
        ];

        return "patrons/query?" . http_build_query($query);
    }
}
