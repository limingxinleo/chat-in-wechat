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
namespace App\Service\Handler;

use App\Service\TencentAI;
use Hyperf\Di\Annotation\Inject;

class TextHandler implements HandlerInterface
{
    /**
     * @Inject
     * @var TencentAI
     */
    protected $ai;

    public function handle(string $openid, array $message): ?string
    {
        if (isset($message['Content'])) {
            $ret = $this->ai->getApp()->nlp->request('textchat', [
                'question' => $message['Content'],
                'session' => $openid,
            ]);

            if ($ret['ret'] === 0) {
                return $ret['data']['answer'];
            }
        }

        return null;
    }
}
