<?php

namespace Arandel\OtrsRpcClient\Api;

/**
 * Class Main
 * @package Arandel\OtrsRpcClient\EndPoint
 * @url https://github.com/OTRS/otrs/blob/master/Kernel/System/Main.pm
 */
class MainApi extends AbstractApi
{
    public function fileRead()  {}
    public function fileWrite()  {}
    public function fileDelete()  {}
    public function fileGetMTime()  {}
    public function getMD5sum()  {}
    public function directoryRead()  {}
    public function generateRandomString()  {}
}
