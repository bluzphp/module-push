<?php
/**
 * Generated controller
 *
 * @author   dev
 * @created  2018-11-07 18:44:07
 */
namespace Application;

use Bluz\Controller\Controller;
use Bluz\Http\RequestMethod;
use Bluz\Proxy\Messages;
use Bluz\Proxy\Request;

/**
 * @accept JSON
 *
 * @privilege Subscribe
 *
 * @return mixed
 */
return function () {
    /**
     * @var Controller $this
     */
    $endpoint = Request::getParam('endpoint');
    $authToken = Request::getParam('authToken');
    $publicKey = Request::getParam('publicKey');
    $contentEncoding = Request::getParam('contentEncoding');

    switch (Request::getMethod()) {
        case RequestMethod::GET:
            // show information page
            break;
        case RequestMethod::POST:
        case RequestMethod::PUT:
            // try to find current record
            $push = Push\Table::findRowWhere([
                'userId' => $this->user()->getId(),
                'endpoint' => $endpoint,
            ]);

            if ($push) {
                // update the key and token of subscription corresponding to the endpoint
                // update timestamp
                $push->updated = gmdate('Y-m-d H:i:s');
            } else {
                // create a new subscription entry in your database (endpoint is unique)
                $push = new Push\Row();
                $push->userId = $this->user()->getId();
            }
            $push->endpoint = $endpoint;
            $push->authToken = $authToken;
            $push->publicKey = $publicKey;
            $push->contentEncoding = $contentEncoding;
            $push->save();
            Messages::addSuccess('You are subscribed');
            break;
        case RequestMethod::DELETE:
            // delete the subscription corresponding to the endpoint
            $push = Push\Table::findRowWhere([
                'userId' => $this->user()->getId(),
                'endpoint' => $endpoint,
            ]);
            $push->delete();
            Messages::addSuccess('You are unsubscribed');
            break;
        default:
            Messages::addError('Error: method not handled');
            return;
    }
};
