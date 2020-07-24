<?php

declare(strict_types=1);
/**
 * This file is part of Hyperf.
 *
 * @link     https://www.hyperf.io
 * @document https://doc.hyperf.io
 * @contact  group@hyperf.io
 * @license  https://github.com/hyperf/hyperf/blob/master/LICENSE
 */
namespace App\Service;

use EasyWeChat\Factory;
use EasyWeChat\OfficialAccount\Application;
use Hyperf\Guzzle\CoroutineHandler;

class WeChat extends Service
{
    public function getApp(): Application
    {
        $config = array_merge($this->config->get('wechat', []), [
            'response_type' => 'array',
        ]);

        $app = Factory::officialAccount($config);

        // 重写 Handler
        $app['guzzle_handler'] = new CoroutineHandler();

        return $app;
    }
}
