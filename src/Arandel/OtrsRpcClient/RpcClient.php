<?php

namespace Arandel\OtrsRpcClient;

class RpcClient
{
    protected $soapUrl;
    protected $username;
    protected $password;
    protected $client;

    public function __construct($soapUrl, $username, $password)
    {
        $this->soapUrl = $soapUrl;
        $this->username = $username;
        $this->password = $password;

        $this->client = new \SoapClient(
            null,
            array(
                'location' => $this->soapUrl,
                'uri' => 'Core',
                'trace' => 1,
                'login' => $this->username,
                'password' => $this->password,
                'style' => SOAP_RPC,
                'use' => SOAP_ENCODED
            )
        );
    }

    public function dispatchCall(array $params = array())
    {
        $result = false;


        $soapParams = array($this->username, $this->password);

        foreach ($params as $paramName => $paramValue) {
            $soapParams[] = $paramName;
            $soapParams[] = $paramValue;
        }

        try {
            $result = $this->client->__soapCall('Dispatch', $soapParams);

            if (is_array($result)) {
                $result = $this->parsePairs($result);
            }


        } catch (\Exception $e) {
            print_R($e->getMessage());
        }

        return $result;
    }

    public function getLastRequest()
    {
        return $this->client->__getLastRequest();
    }

    public function getLastResponse()
    {
        return $this->client->__getLastResponse();
    }

    public function parsePairs(array $data)
    {
        $result = [];
        $values = array_values($data);
        foreach ($values as $key => $value) {
            if ($value instanceof \stdClass) {
                $result[$key] = get_object_vars($value);
                continue;
            }
            if ($key % 2 == 0) {
                $result[$value] = $values[++$key];
            }
        }
        return $result;
    }
}
