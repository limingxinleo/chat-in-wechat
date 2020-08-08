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
namespace HyperfTest\Cases;

use GuzzleHttp\Client;
use Hyperf\Guzzle\HandlerStackFactory;
use HyperfTest\HttpTestCase;

/**
 * @internal
 * @coversNothing
 */
class ExampleTest extends HttpTestCase
{
    public function testExample()
    {
        $this->assertTrue(true);
    }

    public function testWeChatServe()
    {
        $content = '<xml>
    <ToUserName><![CDATA[gh_17cd1c8dad65]]></ToUserName>
    <Encrypt><![CDATA[t9vnVpFzjgwLLJgJpaIX/HozflGhPmdMi1cFq47ihs/twkPp4DZuNLVT5q9F5bg4WuxoSrMKr7Ewc5ceIYpNXqQIV1ctTzXNbc0V3LCxHQ/0nmTj2lcd6xNkypVheKoHfaFpmqzX7Nu3c+WLwPPl1IMQ0ffptKCxHASLCy1zmdP4IEFlxgFYJCwKFEfQ0zn6GzfzdC/GspafTgq7qv7oplU3HkujgrpqzEIVCADFouIjl6ifzur9AXjx8+wsfkFagjpIS840Jir/3gIOJs3YD8BKCHHqOoLdVfpeoSkKrGlQAS6ph8ExqML7QLeGj02idDkDM2m2XLZYbr9dRtAc0XMjwJZpS2YDfqrxsYTGEPBoDrTMTN272QUSbvYUaFlVQHjpl3sn7Ows5R2VRi9AnpBJJjSn2mfRsule4MsF1rY=]]></Encrypt>
</xml>
';

        $client = new Client([
            'base_uri' => 'http://127.0.0.1:9501',
            'handler' => di()->get(HandlerStackFactory::class)->create(),
        ]);

        $response = $client->post('/', ['body' => $content]);
        $this->assertSame(200, $response->getStatusCode());
        var_dump($response->getBody()->getContents());
    }
}
