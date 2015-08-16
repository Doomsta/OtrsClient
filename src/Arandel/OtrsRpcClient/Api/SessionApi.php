<?php

namespace Arandel\OtrsRpcClient\Api;

/**
 * Class Session
 * @package Arandel\OtrsRpcClient\EndPoint
 * @url https://github.com/OTRS/otrs/blob/master/Kernel/System/AuthSession.pm
 */
class SessionApi extends AbstractApi
{
    protected $objectName = 'SessionObject';

    #SessionIDErrorMessage

    public function getSessionData($id)
    {
        return $this->rpcCall('GetSessionIDData', ['SessionID' => $id]);
    }
}
