<?php
/**
 * @namespace
 */
namespace Application\Push;

use Bluz\Validator\Traits\Validator;

/**
 * Class Row for `push`
 *
 * @package  Application\Push
 *
 * @property integer $id
 * @property integer $userId
 * @property string $authToken
 * @property string $contentEncoding
 * @property string $endpoint
 * @property string $publicKey
 * @property string $created
 * @property string $updated
 *
 * @author   Anton Shevchuk
 * @created  2018-11-07 18:33:01
 */
class Row extends \Bluz\Db\Row
{
    use Validator;

    /**
     * @return void
     */
    public function beforeInsert(): void
    {
    }

    /**
     * @return void
     */
    public function beforeUpdate(): void
    {
    }

    /**
     * @return void
     */
    public function beforeSave(): void
    {
        $this->addValidator('endpoint')
            ->required()
            ;
        $this->addValidator('authToken')
            ->required()
            ;
        $this->addValidator('publicKey')
            ->required()
            ;
        $this->addValidator('contentEncoding')
            ->required()
            ;
    }
}
