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
use Hyperf\Contract\StdoutLoggerInterface;
use Hyperf\Guzzle\CoroutineHandler;
use Psr\Container\ContainerInterface;

abstract class Service
{
    /**
     * @var ContainerInterface
     */
    protected $container;

    /**
     * @var StdoutLoggerInterface
     */
    protected $logger;

    /**
     * @var ConfigInterface
     */
    protected $config;

    /**
     * @var CoroutineHandler
     */
    protected $handler;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
        $this->logger = $container->get(StdoutLoggerInterface::class);
        $this->config = $container->get(ConfigInterface::class);
        $this->handler = new CoroutineHandler();
    }
}
