<?php
namespace NYPL\Services\Model\DataModel\Query;

use NYPL\Services\Model\DataModel\Query;

class PatronUsernameQuery extends Query
{
    const DEFAULT_LIMIT = 20;

    /**
     * @var string
     */
    protected $username = '';

    /**
     * @return string
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * @param string $username
     */
    public function setUsername($username = '')
    {
        $this->username = $username;
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
                    'tag' => 'u'
                ]
            ],
            'expr' => [
                'op' => 'equals',
                'operands' => [
                    $this->getUsername()
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
