<?php

namespace Arandel\OtrsRpcClient\Api;

/**
 * Class LogApi
 * @package Arandel\OtrsRpcClient\Api
 */
class LogApi extends AbstractApi
{
    protected $objectName = 'LogObject';


    const PRIORITY_ERROR = 'error';
    const PRIORITY_INFO = 'info';
    const PRIORITY_NOTICE = 'notice';

    const TYPE_MESSAGE = 'Message';
    const TYPE_TRACE_BACK = 'Traceback';

    public function log($message, $prio = 'error')
    {
        return $this->rpcCall('Log', [
            'Priority' => $prio,
            'Message' => $message
        ]);
    }

    public function getEntry($type = self::PRIORITY_ERROR, $what = self::TYPE_MESSAGE)
    {
        return $this->rpcCall('GetLogEntry', [
            'Type' => $type,
            'What' => $what,
        ], true);
    }

    #GetLogEntry
    #GetLog
    #CleanUp
    #Dumper
}