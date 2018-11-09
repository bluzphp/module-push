<?php
/**
 * Generated controller
 *
 * @author   dev
 * @created  2018-11-07 18:44:11
 */
namespace Application;

use Application\Push\Gateway;
use Application\Push\Row;
use Application\Push\Table;
use Bluz\Controller\Controller;
use Bluz\Proxy\Messages;
use Bluz\Proxy\Request;

/**
 * @privilege Management
 *
 * @param int $id
 * @param string $message
 *
 * @return mixed
 */
return function ($id, $message = null) {
    /**
     * @var Controller $this
     * @var Row $push
     */
    $push = Table::findRow($id);

    if (!$push) {
        Messages::addError('Invalid record');
    }

    $this->assign('id', $id);
    $this->assign('message', $message);

    if (Request::isPost()) {
        $result = Gateway::sendByPushId($id, $message);

        if ($result) {
            Messages::addSuccess('Message was send');
        } else {
            Messages::addError('Internal server error');
        }
    }
};
