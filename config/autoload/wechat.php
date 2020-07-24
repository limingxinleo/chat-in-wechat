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
return [
    'app_id' => env('WECHAT_APP_ID'),
    'secret' => env('WECHAT_APP_SECRET'),
    'token' => env('WECHAT_APP_TOKEN'),
    'aes_key' => env('WECHAT_AES_KEY'),
];
