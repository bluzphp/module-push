<?php
/**
 * @namespace
 */
namespace Application\Push;

use Bluz\Grid\Source\SelectSource;

/**
 * Grid based on Table
 *
 * @package  Application\Push
 *
 * @author   Anton Shevchuk
 * @created  2018-11-07 18:34:22
 */
class Grid extends \Bluz\Grid\Grid
{
    /**
     * @var string
     */
    protected $uid = 'push';

    /**
     * @return void
     * @throws \Bluz\Grid\GridException
     */
    public function init() : void
    {
        $select = Table::select();
        $select
            ->addSelect('users.login AS login')
            ->leftJoin('push', 'users', 'users', 'push.userId = users.id');

        // Current table as source of grid
        $adapter = new SelectSource();
        $adapter->setSource($select);

        $this->setAdapter($adapter);
        $this->setDefaultLimit(25);
        $this->setAllowFilters([
            'id',
            'userId',
            'authToken',
            'contentEncoding',
            'endpoint',
            'publicKey',
            'created',
            'updated',
        ]);
        $this->setAllowOrders([
            'id',
            'userId',
            'authToken',
            'contentEncoding',
            'endpoint',
            'publicKey',
            'created',
            'updated',
        ]);
    }
}
