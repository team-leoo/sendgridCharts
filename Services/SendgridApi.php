<?php

/** Namespace */
namespace LeooTeam\SendgridChartsBundle\Services;

/** Usages */
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class SendgridApi
 * @package LeooTeam\SendgridChartsBundle\Services
 */
class SendgridApi
{
    /**
     * @var array $conf
     */
    private $conf;

    /**
     * @var Client $client
     */
    private $client;

    /**
     * SendgridApi constructor.
     * @param array $conf
     * @param Client $client
     */
    public function __construct(array $conf, Client $client)
    {
        $this->conf   = $conf;
        $this->client = $client;
    }

    /**
     * @param $uri
     * @param array $parameters
     * @param array $options
     * @return mixed
     * @throws \Exception
     */
    public function get($uri, $parameters = [], $options = [])
    {
        try {
            /** @var \GuzzleHttp\Psr7\Response $response */
            $response = $this->client->get($this->buildUri(Request::METHOD_GET, $uri, $parameters), $options + [
                'headers'     => $this->makeHeaders(),
                'http_errors' => false,
            ]);
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }

        return $this->respond($response);
    }

    /**
     * @param $rs
     * @return mixed
     */
    private function respond(\GuzzleHttp\Psr7\Response $rs)
    {
        if (Response::HTTP_OK > $rs->getStatusCode()
            || Response::HTTP_BAD_REQUEST <= $rs->getStatusCode()) {
            foreach (\GuzzleHttp\json_decode($rs->getBody()->__toString())->errors as $error) {
                $messages[] = ' - ' . $error->message;
            }

            if (!isset($messages)) {
                $messages = [ 'Unknown error.' ];
            }

            throw new \RuntimeException(implode("\r\n", $messages), $rs->getStatusCode());
        }

        return \GuzzleHttp\json_decode($rs->getBody()->__toString());
    }

    /**
     * @param string $method
     * @param string $uri
     * @param array $parameters
     * @return string
     */
    private function buildUri($method, $uri = null, array $parameters = [])
    {
        if ($method == Request::METHOD_GET and count($parameters) > 0) {
            $uri .= '?' . http_build_query($parameters);
        }

        return '/v3' . $uri;
    }

    /**
     * @return array
     */
    private function makeHeaders()
    {
        return [
            'Content-Type' => 'application/json',
            'Accept'       => 'application/json',
            'authorization' => "Bearer {$this->conf['apikey']}"
        ];
    }
}