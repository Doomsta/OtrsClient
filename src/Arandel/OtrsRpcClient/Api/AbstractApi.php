<?php

namespace Arandel\OtrsRpcClient\Api;

use Arandel\OtrsRpcClient\OtrsClient;
use Arandel\OtrsRpcClient\RpcClient;

abstract class AbstractApi
{
    protected $objectName = null;
    /** @var RpcClient */
    private $client;
    /**
     * @var OtrsClient
     */
    private $otrs;

    /**
     * @param RpcClient $client
     * @param OtrsClient $otrs
     */
    public function __construct(RpcClient $client, OtrsClient $otrs)
    {
        $this->client = $client;
        $this->otrs = $otrs;
    }

    /**
     * @return RpcClient
     */
    protected function getClient()
    {
        return $this->client;
    }

    protected function getObjectName()
    {
        if ($this->objectName === null) {
            throw new \InvalidArgumentException('Object name is invalid');
        }
        return $this->objectName;
    }

    /**
     * This is the main request function to use!!
     * the others are deprecated
     * @param $method
     * @param array $params
     * @return mixed
     */
    protected function rpcCall($method, $params = [], $debug = false)
    {
        if ($debug) {
            print_R($params);
        }
        $endpoint = array($this->getObjectName() => $method);
        $params = array_merge($endpoint, $params);
        return $this->client->dispatchCall($params);
    }

    /**
     * @param array $row
     * @return array
     */
    final public static function perlArray2PhpArray(array $row = [])
    {
        $r = [];
        foreach ($row as $val0 => $val1) {
            $r[] = $val0;
            if ($val1) {
                $r[] = $val1;
            }
        }
        return array_reverse($r);
    }
}
