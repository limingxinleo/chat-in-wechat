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
use App\Service\WeChat;
use Hyperf\Di\Annotation\Inject;
use Symfony\Component\HttpFoundation\Request;

class IndexController extends Controller
{
    /**
     * @Inject
     * @var TencentAI
     */
    protected $ai;

    /**
     * @Inject
     * @var WeChat
     */
    protected $wechat;

    public function index()
    {
        $get = $this->request->getQueryParams();
        $post = $this->request->getParsedBody();
        $cookie = $this->request->getCookieParams();
        $uploadFiles = $this->request->getUploadedFiles() ?? [];
        $server = $this->request->getServerParams();
        $xml = $this->request->getBody()->getContents();
        $files = [];
        /** @var \Hyperf\HttpMessage\Upload\UploadedFile $v */
        foreach ($uploadFiles as $k => $v) {
            $files[$k] = $v->toArray();
        }

        $app = $this->wechat->getApp(new Request($get, $post, [], $cookie, $files, $server, $xml));

        $response = $app->server->serve();

        return $response->getContent();
    }
}
