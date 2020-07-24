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

use App\Service\Handler\HandlerInterface;
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
            $this->logger->info((string) json_encode($message, JSON_UNESCAPED_UNICODE));
            if (isset($message['FromUserName'], $message['MsgType'])) {
                $openid = $message['FromUserName'];
                $msgType = $message['MsgType'];
                $handlerName = 'handler.' . $msgType;
                if (di()->has($handlerName)) {
                    /** @var HandlerInterface $handler */
                    $handler = di()->get($handlerName);
                    return $handler->handle($openid, $message);
                }

                return null;
            }
        });

        return $app;
    }
}
