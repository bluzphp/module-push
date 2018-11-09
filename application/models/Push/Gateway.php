<?php
/**
 * @namespace
 */
namespace Application\Push;

use Application\Exception;
use Bluz\Db\Exception\DbException;
use Bluz\Db\Exception\InvalidPrimaryKeyException;
use Bluz\Proxy\Config;
use Bluz\Proxy\Router;
use Minishlink\WebPush\WebPush;
use Minishlink\WebPush\Subscription;

/**
 * Gateway
 *
 * @package  Application\Push
 * @author   Anton Shevchuk
 */
class Gateway
{
    /**
     * Send push notification
     *
     * @param Row    $push
     * @param string $message
     *
     * @return array|bool
     * @throws \ErrorException
     */
    public static function sendPush(Row $push, $message)
    {
        $subscription = Subscription::create([
            'contentEncoding' => $push->contentEncoding,
            'endpoint' => $push->endpoint,
            'authToken' => $push->authToken,
            'publicKey' => $push->publicKey,
        ]);

        $auth = Config::get('module.push');

        $webPush = new WebPush($auth);

        return $webPush->sendNotification(
            $subscription,
            json_encode([
                'icon' => Router::getBaseUrl() . 'img/icon-512x512.png',
                'badge' => Router::getBaseUrl() . 'img/icon-128x128.png',
                'body' => $message,
            ]),
            true
        );
    }

    /**
     * Send notification by push Id
     *
     * @param integer $pushId
     * @param string  $message
     *
     * @return array|bool
     * @throws DbException
     * @throws Exception
     * @throws InvalidPrimaryKeyException
     * @throws \ErrorException
     */
    public static function sendByPushId($pushId, $message)
    {
        /** @var Row $push */
        $push = Table::findRow($pushId);

        if (!$push) {
            throw new Exception('Invalid push ID');
        }

        return self::sendPush($push, $message);
    }

    /**
     * Send notifications by user Id
     *
     * @param $userId
     * @param $message
     *
     * @return void
     * @throws DbException
     * @throws \ErrorException
     */
    public static function sendByUserId($userId, $message): void
    {
        $pushes = Table::findWhere(['userId' => $userId]);

        foreach ($pushes as $push) {
            self::sendPush($push, $message);
        }
    }
}
