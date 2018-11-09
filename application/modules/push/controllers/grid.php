<?php
/**
 * Grid controller for Push model
 *
 * @author   dev
 * @created  2018-11-07 18:34:22
 */

/**
 * @namespace
 */
namespace Application;

use Bluz\Controller\Controller;
use Bluz\Proxy\Layout;

/**
 * @privilege Management
 *
 * @return mixed
 */
return function () {
    /**
     * @var Controller $this
     */
    Layout::setTemplate('dashboard.phtml');
    Layout::breadCrumbs(
        [
            Layout::ahref('Dashboard', ['dashboard', 'index']),
            __('Media')
        ]
    );
    $grid = new Push\Grid();
    $this->assign('grid', $grid);
};
