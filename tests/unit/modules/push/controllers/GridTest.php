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
 * @group    grid
 *
 * @package  Application\Tests\Options
 * @author   Anton Shevchuk
 */
class GridTest extends ControllerTestCase
{
    /**
     * Dispatch module/controller
     *
     * @todo test functionality
     */
    public function testControllerPage()
    {
        self::setupSuperUserIdentity();

        $this->dispatch('/push/grid/');
        self::assertOk();
    }
}
