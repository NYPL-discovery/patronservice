<?php
namespace NYPL\Services\Model\DataModel\Query;

use NYPL\Services\Model\DataModel\Query;

class PatronQuery extends Query
{
    /**
     * @var string
     */
    protected $email = '';

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @param string $email
     */
    public function setEmail(string $email)
    {
        $this->email = $email;
    }

    /**
     * @return string
     */
    public function getBody(): string
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
            'limit' => 1
        ];

        return "patrons/query?" . http_build_query($query);
    }
}
