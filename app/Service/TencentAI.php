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

use Hyperf\Contract\ConfigInterface;
use Justmd5\TencentAi\Ai;
use Psr\Container\ContainerInterface;

class TencentAI extends Service
{
    /**
     * @var ConfigInterface
     */
    protected $config;

    /**
     * @var null|Ai
     */
    protected $app;

    public function __construct(ContainerInterface $container)
    {
        parent::__construct($container);
        $this->config = $container->get(ConfigInterface::class);
    }

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
        return $this->app = new Ai($config);
    }
}
