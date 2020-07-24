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
namespace App\Listener;

use Hanson\Foundation\Http;
use Hyperf\Event\Annotation\Listener;
use Hyperf\Event\Contract\ListenerInterface;
use Hyperf\Guzzle\HandlerStackFactory;
use Hyperf\Server\Event\MainCoroutineServerStart;
use Psr\Container\ContainerInterface;

/**
 * @Listener
 */
class RegisterTencentAIListener implements ListenerInterface
{
    /**
     * @var ContainerInterface
     */
    private $container;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    public function listen(): array
    {
        return [
            MainCoroutineServerStart::class,
        ];
    }

    public function process(object $event)
    {
        Http::setDefaultOptions([
            'handler' => $this->container->get(HandlerStackFactory::class)->create(),
        ]);
    }
}
