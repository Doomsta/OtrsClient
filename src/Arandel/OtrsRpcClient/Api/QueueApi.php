<?php

namespace Arandel\OtrsRpcClient\Api;

/**
 * Class QueueApi
 * @package Arandel\OtrsRpcClient\Api
 * @url https://github.com/OTRS/otrs/blob/master/Kernel/System/Queue.pm
 */
class QueueApi extends AbstractApi
{
    protected $objectName = 'QueueObject';


    /**
     * get a queue system email address
     * @TODO return some struct
     * @param $queueID
     * @return array with RealName and Email
     */
    public function getSystemAddress($queueID)
    {
        return $this->rpcCall('GetSystemAddress', ['QueueID' => $queueID]);
    }

    /**
     * get a queue signature
     * @return string
     */
    public function getSignature($queueID)
    {
        return (string) $this->rpcCall('GetSignature', ['QueueID' => $queueID]);
    }

    /**
     * to add a template to a queue
     * @param $queueID
     * @param $templateID
     * @param int $userID
     * @param int $active
     * @return mixed
     */
    public function addTemplateToQueue($queueID, $templateID, $userID = 1, $active = 1)
    {
        return $this->rpcCall('', [
            'QueueID' => $queueID,
            'StandardTemplateID' => $templateID,
            'Active' => $active,
            'UserID' => $userID,
        ]);
    }

    /**
     * get std responses of a queue
     * @param $queueID
     * @return array
     */
    public function getTemplatesByQueue($queueID)
    {
        return $this->rpcCall('QueueStandardTemplateMemberList', ['QueueID' => $queueID]);
    }

    /**
     * @param $templateType
     * @return array
     */
    public function getTemplatesByTemplateType($templateType)
    {
        return $this->rpcCall('QueueStandardTemplateMemberList', ['TemplateTypes' => $templateType]);
    }

    /**
     * @param $templateID
     * @return array
     */
    public function getTemplatesByTemplateID($templateID)
    {
        return  $this->rpcCall('QueueStandardTemplateMemberList', ['StandardTemplateID' => $templateID]);
    }

    public function getAllQueues($userID = 1, $permission = 'ro')
    {
        return $this->rpcCall('GetAllQueues', ['UserID' => $userID, 'Type' => $permission]);
    }

    public function getAllCustomQueues($userID = 1)
    {
        return $this->rpcCall('GetAllCustomQueues', ['UserID' => $userID]);
    }

    public function lookupID($queue)
    {
        return (int) $this->rpcCall('QueueLookup', ['Queue' => $queue]);
    }

    public function lookupName($queueID)
    {
        return (string) $this->rpcCall('QueueLookup', ['QueueID' => $queueID]);
    }


    #GetFollowUpOption
    #GetFollowUpLockOption
    #GetQueueGroupID
    #QueueAdd
    #QueueGet
    #QueueUpdate
    #QueueList
    #QueuePreferencesSet
    #QueuePreferencesGet
    #NameExistsCheck

}