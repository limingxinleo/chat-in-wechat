<?php

declare(strict_types=1);
/**
 * This file is part of Hyperf.
 *
 * @link     https://www.hyperf.io
 * @document https://hyperf.wiki
 * @contact  group@hyperf.io
 * @license  https://github.com/hyperf/hyperf/blob/master/LICENSE
 */
namespace App\Service;

use App\Service\Handler\HandlerInterface;
use EasyWeChat\Factory;
use EasyWeChat\OfficialAccount\Application;
use GuzzleHttp\Client;
use GuzzleHttp\HandlerStack;
use Symfony\Component\HttpFoundation\Request;

class WeChat extends Service
{
    /**
     * @var HandlerStack
     */
    protected $stack;

    public function getApp(Request $request): Application
    {
        $config = array_merge($this->config->get('wechat', []), [
            'response_type' => 'array',
        ]);

        $app = Factory::officialAccount($config);

        // 重写 Request
        $app->rebind('request', $request);

        // 重写 Guzzle Client
        $config = $app['config']->get('http', []);
        $config['handler'] = $this->getStack();
        $app->rebind('http_client', new Client($config));

        // 重写 Handler
        $app['guzzle_handler'] = $this->handler;

        // 重写 Socialite
        $app->oauth->setGuzzleOptions([
            'http_errors' => false,
            'handler' => $this->getStack(),
        ]);

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

    protected function getStack()
    {
        if ($this->stack instanceof HandlerStack) {
            return $this->stack;
        }

        return $this->stack = HandlerStack::create($this->handler);
    }
}
