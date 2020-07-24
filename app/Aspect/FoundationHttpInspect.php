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

use GuzzleHttp\HandlerStack;
use Hanson\Foundation\Http;
use Hyperf\Di\Annotation\Aspect;
use Hyperf\Di\Aop\AbstractAspect;
use Hyperf\Di\Aop\ProceedingJoinPoint;
use Hyperf\Guzzle\CoroutineHandler;
use Hyperf\Guzzle\HandlerStackFactory;
use Psr\Container\ContainerInterface;

/**
 * @Aspect
 * FIXME: 第三方SDK，这里写的有问题
 */
class FoundationHttpInspect extends AbstractAspect
{
    public $classes = [
        Http::class . '::getHandler',
    ];

    /**
     * @var ContainerInterface
     */
    protected $container;

    /**
     * @var HandlerStack
     */
    protected $stack;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    public function process(ProceedingJoinPoint $proceedingJoinPoint)
    {
        if ($this->stack instanceof HandlerStack) {
            return $this->stack;
        }

        $stack = di()->get(HandlerStackFactory::class)->create();
        $stack->setHandler(new CoroutineHandler());
        return $this->stack = $stack;
    }
}
