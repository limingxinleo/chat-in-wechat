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
namespace App\Middleware;

use Psr\Http\Message\ServerRequestInterface;

class DebugMiddleware extends \HyperfX\Utils\Middleware\DebugMiddleware
{
    protected function getRequestString(ServerRequestInterface $request): string
    {
        return $request->getBody()->getContents();
    }
}
