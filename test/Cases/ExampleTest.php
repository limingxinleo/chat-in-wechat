<?php

declare(strict_types=1);
/**
 * This file is part of Hyperf.
 *
 * @link     https://www.hyperf.io
 * @document https://hyperf.wiki
 * @contact  group@hyperf.io
 * @license  https://github.com/hyperf/hyperf/blob/master/LICENSE
 */
namespace HyperfTest\Cases;

use GuzzleHttp\Client;
use GuzzleHttp\RequestOptions;
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
        $query = http_build_query([
            'signature' => '1060fd5c89c2f550755fcabab9ea4d747130d51d',
            'timestamp' => '1596891413',
            'nonce' => '1759229533',
            'openid' => 'o5KUZt5v3UcMEYsOyHTNIqx0ENG0',
            'encrypt_type' => 'aes',
            'msg_signature' => '81ae2d720ec02ab0ad0ba6c61a608f1a2e48d397',
        ]);

        $content = '<xml>
    <ToUserName><![CDATA[gh_17cd1c8dad65]]></ToUserName>
    <Encrypt><![CDATA[f/t6gb5cWsgULr+98E7cEpw0d3VPAHas0eEOWZzMXa86PQFEDgAKOWUTlanow9sZ+VKMa+iroTxEsx7BTSBfjES/+WPRRsk8ZpeD+boymd2hY82e593e/YHs3tzOQCFf63WYmYMS4jFpugQDFZu/NIsLhTruuUJTNwPDFU1XJlYhjpe5pwo2gy7e/I8WX4/932s2XAO7xRdZ0+m+xUrWahi2t47+P50l0/+pYBLlbDsfxixFCpUXIrVVO422fSBX8rp9y1IH9vt+VHnNbcfnlBLJA4o9E9WborBo6x+yj7/XGcOk5jSuW0t/86GR9V6KIY2x0oCZ+UDtF9I5V/qrUEtXRZrKd3Uv1McPP0623Sk6p8bN81rBxmayTIs9oPwglrYyNnpCeALnOtT1W1YFH47kycJSu8cipK0qWc1uIXRs3/S3pgPtJTAVhJf6CIdZRFdkSzIhNMjGa4ydXX3gsQ==]]></Encrypt>
</xml>';

        $client = new Client([
            'base_uri' => 'http://127.0.0.1:9501',
            'handler' => di()->get(HandlerStackFactory::class)->create(),
        ]);

        $response = $client->post('/', [
            RequestOptions::QUERY => $query,
            RequestOptions::BODY => $content,
        ]);
        $this->assertSame(200, $response->getStatusCode());
        $this->assertStringContainsString('<xml><Encrypt>', $response->getBody()->getContents());
    }
}
