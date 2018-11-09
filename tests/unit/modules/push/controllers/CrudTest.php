<?php
/**
 * @copyright Bluz PHP Team
 * @link https://github.com/bluzphp/skeleton
 */

/**
 * @namespace
 */
namespace Application\Tests\Push;

use Application\Tests\ControllerTestCase;

/**
 * @group    module-push
 * @group    crud
 *
 * @package  Application\Tests\Options
 * @author   Anton Shevchuk
 */
class CrudTest extends ControllerTestCase
{
    /**
     * setUp
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        self::getApp()->useLayout(false);
        self::setupSuperUserIdentity();
    }

    public function testGetCrudForm()
    {
        $this->dispatch('/push/crud/');

        self::assertOk();
        self::assertQueryCount('form[method="POST"]', 1);
    }
}
