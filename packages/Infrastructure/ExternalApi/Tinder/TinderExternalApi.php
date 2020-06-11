<?php
namespace packages\Infrastructure\ExternalApi\Tinder;

use packages\Infrastructure\ExternalApi\Tinder\TinderExternalApiInterface;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Response;

class TinderExternalApi implements TinderExternalApiInterface
{
    private const API_BASE_URL = 'https://api.gotinder.com/';

    /**
     * 22人のtinder user listを取得する
     *
     * @param $xAuthToken
     *
     * @return array
     */

    public function fetchUserList(string $xAuthToken): array
    {
        // try {
        //     $response = $this->get('recs/core/', $xAuthToken);
        // } catch (Exception $e) {
        //     logger($e);
        // }
         try {
            $client    = new Client();
            $parameter = [
                'headers' => [
                    'x-auth-token' => $xAuthToken,
                ]
            ];
            $res = $client->request('GET', self::API_BASE_URL.'v2/recs/core', $parameter);

            if ($res->getStatusCode() == 200) {
                $tmp = json_decode($res->getBody()->getContents(), true);

                return $tmp['data']['results'];
            }
        } catch(Exception $e){
            echo 'Caught exception: ',  $e->getMessage();
        }
    }

     /**
     * tinder user listを取得する
     *
     * @param $xAuthToken
     * @param $tinderUserId
     *
     * @return 
     */

    public function swipe(string $xAuthToken, string $tinderUserId)
    {
        try {
            $client    = new Client();
            $parameter = [
                'headers' => [
                    'x-auth-token' => $xAuthToken,
                ]
            ];

            $res = $client->request('POST', self::API_BASE_URL.'like/'.$tinderUserId, $parameter);

            if ($res->getStatusCode() == 200) {
                return json_decode($res->getBody()->getContents(), true);
            }

        } catch(Exception $e){
            echo 'Caught exception: ',  $e->getMessage();
        }
    }

    /**
     *  tinder apiにリクエストするために使用するHeaderを作成するためのメソッド.
     * @param $xAuthToken
     * @return array|string[]
     */
    private function initRequestHeaders(string $xAuthToken): array
    {
        $headers = [
            'x-auth-token' => $xAuthToken,
        ];

        return $headers;
    }

    /**
     *  tinder apiにGETリクエストするためのメソッド.
     *
     * @param $path
     * @param $xAuthToken
     * @param $fields
     *
     * @return array|mixed
     */
    private function get(string $path, string $xAuthToken, array $fields = []): Response
    {
        return $this->baseRequest('GET', $path, $xAuthToken, $fields);
    }

    /**
     *  tinder apiにPOSTリクエストするためのメソッド.
     *
     * @param $path
     * @param $fields
     *
     * @return array|mixed
     */
    private function post(string $path, string $xAuthToken, array $fields = []): Response
    {
        return $this->baseRequest('POST', $path, $fields);
    }

    /**
     * tinder apiにリクエストするためのメソッド.
     *
     * @param string       $method
     * @param string       $path
     * @param string|array $requestContent
     *
     * @return Response|\Psr\Http\Message\ResponseInterface
     */
    private function baseRequest(string $method, string $path, string $xAuthToken, array $fields)
    {
        $client         = new Client();
        $headers        = $this->initRequestHeaders($xAuthToken);
        $url            = self::API_BASE_URL.$path;

        $requestContent = [
            'query'         => $fields,
            'headers'       => $headers,
            'http_errors'   => false,
            'Accept'        => 'application/json',
        ];

        if ($method === 'POST') {
            $body = json_encode($fields);

            $requestContent = [
                'body'          => $body,
                'headers'       => $headers,
                'http_errors'   => false,
                'Content-Type'  => 'application/json',
                'Accept'        => 'application/json',
            ];
        }

        \Log::info('Call tinder api url:'.$url);

        return $client->request($method, $url, $requestContent);
    }

    /**
     * tinder apiのコールに失敗した際に呼び出すメソッド。
     * APIErrorExceptionを発火させる。
     *
     * @param Response $response
     *
     * @throws APIErrorException
     */
    private function raiseApiCallException(Response $response)
    {
        \Log::error('Fail call tinder api'.$response->getBody());
        throw new APIErrorException($response->getBody(), $response->getStatusCode());
    }
}
