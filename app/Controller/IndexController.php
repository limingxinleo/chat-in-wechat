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
namespace App\Controller;

use App\Service\TencentAI;
use Hyperf\Di\Annotation\Inject;

class IndexController extends Controller
{
    /**
     * @Inject
     * @var TencentAI
     */
    protected $ai;

    public function index()
    {
        $rest = $this->ai->getApp()->nlp->request('textchat', [
            'question' => '你是谁',
            'session' => uniqid(),
        ]);
        return $this->response->success($rest);
    }
}
