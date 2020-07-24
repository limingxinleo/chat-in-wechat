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
namespace App\Aspect;

use Hyperf\Contract\StdoutLoggerInterface;
use Hyperf\Di\Annotation\Aspect;
use Hyperf\Di\Aop\AbstractAspect;
use Hyperf\Di\Aop\ProceedingJoinPoint;
use Hyperf\Guzzle\CoroutineHandler;
use Psr\Container\ContainerInterface;

/**
 * @Aspect
 */
class IOAspect extends AbstractAspect
{
    public $classes = [
        CoroutineHandler::class . '::__invoke',
    ];

    /**
     * @var ContainerInterface
     */
    protected $container;

    /**
     * @var StdoutLoggerInterface
     */
    protected $logger;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
        $this->logger = $container->get(StdoutLoggerInterface::class);
    }

    public function process(ProceedingJoinPoint $proceedingJoinPoint)
    {
        $ms = microtime(true);
        $result = $proceedingJoinPoint->process();
        $this->logger->info((string) json_encode([
            'class' => $proceedingJoinPoint->className,
            'method' => $proceedingJoinPoint->methodName,
            'time' => microtime(true) - $ms,
        ], JSON_UNESCAPED_UNICODE));
        return $result;
    }
}
