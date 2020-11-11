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

use Justmd5\TencentAi\Ai;

class TencentAI extends Service
{
    /**
     * @var null|Ai
     */
    protected $app;

    public function getApp(): Ai
    {
        if ($this->app instanceof Ai) {
            return $this->app;
        }

        $config = [
            'appKey' => $this->config->get('tencent.app_id'),
            'appSecret' => $this->config->get('tencent.app_key'),
            'debug' => true,
        ];

        $app = new Ai($config);
        $app['guzzle_handler'] = function () {
            return $this->handler;
        };

        return $this->app = $app;
    }
}
