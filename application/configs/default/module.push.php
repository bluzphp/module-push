<?php
/**
 * Configuration of Push module
 *
 * For change module configuration you should create configuration file
 * inside directory of configuration of current environment,
 * i.e. `application/configs/testing/module.push.php`
 *
 * @author   Anton Shevchuk
 * @created  07.11.2018 17:28
 *
 * @readonly
 * @link     https://github.com/bluzphp/skeleton/wiki/Module-Push
 * @return   array
 */
return [
    'VAPID' => [
        'subject' => 'https://github.com/bluzphp/module-push',
        // for generate keys you can use site https://web-push-codelab.glitch.me/
        'publicKey' => 'BIMtOOXkIBAENtP9DwQXr2OAvWMkGowrjHT8GZVEPWnN_kviXX7jqZqlkd7BpPK00112zPvUXnuYNUSwcN5HuqI',
        'privateKey' => 'kbAbcLXqXesG9VLyHQcpaWmquOq2QtnkdfISHF--XVE',
    ],
];
