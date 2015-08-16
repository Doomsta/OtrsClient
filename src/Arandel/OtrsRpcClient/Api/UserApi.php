<?php

namespace Arandel\OtrsRpcClient\Api;


/**
 * Class User
 * @package Arandel\OtrsRpcClient\EndPoint
 * @url https://github.com/OTRS/otrs/blob/master/Kernel/System/User.pm
 */
class UserApi extends AbstractApi
{
    protected $objectName = 'UserObject';

    #GetUserData
    #UserAdd
    #UserUpdate
    #UserSearch
    #SetPassword
    #UserLookup
    #UserName
    #UserList
    #GenerateRandomPassword
    #SetPreferences


    const USER_LIST_TYPE_SHORT = 'Short';
    const USER_LIST_TYPE_LONG = 'Long';

    /**
     * @TODO params may not work
     * @param string $type
     * @param int $valid
     * @param int $noOutOfOffice
     * @return mixed
     */
    public function userList($type = self::USER_LIST_TYPE_SHORT, $valid = 1, $noOutOfOffice = 0)
    {
        return $this->rpcCall('UserList', [
            'Type' => $type,
            'Valid' => $valid,
            'NoOutOfOffice' => $noOutOfOffice,
        ]);
    }


    public function getPreferences($userID)
    {
        return $this->rpcCall('GetPreferences',  [
            'UserID' => $userID,
        ]);
    }
}