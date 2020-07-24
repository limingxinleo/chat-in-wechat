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
use Symfony\Component\HttpFoundation\Request;

class WeChat extends Service
{
    public function getApp(Request $request): Application
    {
        $config = array_merge($this->config->get('wechat', []), [
            'response_type' => 'array',
        ]);

        $app = Factory::officialAccount($config);

        // 重写 Handler
        $app['guzzle_handler'] = new CoroutineHandler();
        $app['request'] = $request;

        $app->server->push(function ($message) {
            var_dump($message);
            switch ($message['MsgType']) {
                case 'event':
                    return '收到事件消息';
                case 'text':
                    return '收到文字消息';
                case 'image':
                    return '收到图片消息';
                case 'voice':
                    return '收到语音消息';
                case 'video':
                    return '收到视频消息';
                case 'location':
                    return '收到坐标消息';
                case 'link':
                    return '收到链接消息';
                case 'file':
                    return '收到文件消息';
                default:
                    return '收到其它消息';
            }
        });

        return $app;
    }
}
