<?php
/**
 * @namespace
 */
namespace Application\Push;

/**
 * Class Table for `push`
 *
 * @package  Application\Push
 *
 * @author   Anton Shevchuk
 * @created  2018-11-07 18:33:01
 */
class Table extends \Bluz\Db\Table
{
    /**
     * @var string
     */
    protected $name = 'push';

    /**
     * @var string
     */
    protected $rowClass = Row::class;

    /**
     * Primary key(s)
     * @var array
     */
    protected $primary = ['id'];
}
