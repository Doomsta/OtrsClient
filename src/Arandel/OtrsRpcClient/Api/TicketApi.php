<?php

namespace Arandel\OtrsRpcClient\Api;

use Arandel\OtrsRpcClient\Struct\HistoryStruct;


/**
 * Class TicketApi
 * @package Arandel\OtrsRpcClient\Api
 * @url https://github.com/OTRS/otrs/blob/master/Kernel/System/Ticket.pm
 */
class TicketApi extends AbstractApi
{
    protected $objectName = 'TicketObject';


    /**
     * checks if ticket number exists, returns ticket id if number exists
     * @param $tn
     * @return bool
     */
    public function checkNumber($tn)
    {
        return (bool) $this->rpcCall('TicketCheckNumber', ['Tn' => $tn]);
    }

    /**
     * creates a new ticket
     * @return mixed|null|string
     */
    public function createTicket()
    {
        #Title        => 'Some Ticket Title',
        #Queue        => 'Raw',            # or QueueID => 123,
        #Lock         => 'unlock',
        #Priority     => '3 normal',       # or PriorityID => 2,
        #State        => 'new',            # or StateID => 5,
        #CustomerID   => '123465',
        #CustomerUser => 'customer@example.com',
        #OwnerID      => 123,
        #UserID       => 123,
        return $this->rpcCall('TicketCreate', []);
    }

    /**
     * deletes a ticket with articles from storage
     * @param $ticketID
     * @param $userID
     * @return bool
     */
    public function deleteTicket($ticketID, $userID)
    {
        return (bool) $this->rpcCall('TicketDelete', [
            'TicketID' => $ticketID,
            'UserID'   => $userID,
        ]);
    }

    /**
     * ticket id lookup by ticket number
     * @param $ticketNumber
     * @param $userID
     * @return mixed|null|string
     */
    public function lookupID($ticketNumber, $userID)
    {
        return $this->rpcCall('TicketIDLookup', [
            'TicketNumber' => $ticketNumber,
            'UserID'   => $userID,
        ]);
    }

    public function lookupNumber($ticketID, $userID)
    {
        return $this->rpcCall('TicketNumberLookup', [
            'TicketID' => $ticketID,
            'UserID'   => $userID,
        ]);
    }

    public function buildSubject($ticketNumber, $subject, $action, $type, $noCleanup = 1)
    {
        $params = [
            'TicketNumber' => $ticketNumber,
            'Subject' => $subject,
            'Type' => $type,
            'NoCleanup' => $noCleanup,
            'Action' => $action,
        ];
        return $this->rpcCall('TicketSubjectBuild', $params);
    }

    /**
     * get ticket history as array with hashes
     * (TicketID, ArticleID, Name, CreateBy, CreateTime, HistoryType, QueueID,
     * OwnerID, PriorityID, StateID, HistoryTypeID and TypeID)
     * @return HistoryStruct[]
     */
    public function getHistory($ticketID, $userID)
    {
        $raw = $this->rpcCall('HistoryGet', [
            'TicketID' => $ticketID,
            'UserID'   => $userID,
        ]);
        $result = [];
        foreach($raw as $entry) {
            $result[] = new HistoryStruct($entry);
        }
        return $result;
    }

    public function getTicket($ticketId, $userId = null, $extended = false)
    {
        $params = ['TicketID' => (int) $ticketId];
        if ($userId) {
            $params['UserID'] = (int) $userId;
        }
        if ($extended) {
            $params['Extended'] = 1;
        }
        return $this->rpcCall('TicketGet', $params);
    }

    const SEARCH_RESULT_ARRAY = 'ARRAY';
    const SEARCH_RESULT_HASH = 'HASH';
    const SEARCH_RESULT_COUNT = 'COUNT';

    public function ticketSearch($searchParams = [ 'Title' => '%'], $userId = 1, $resultType = self::SEARCH_RESULT_HASH)
    {

        $supportedResultTypes = [
            self::SEARCH_RESULT_ARRAY,
            self::SEARCH_RESULT_HASH,
            self::SEARCH_RESULT_COUNT,
        ];

        if (!in_array($resultType, $supportedResultTypes)) {
            throw new \InvalidArgumentException('Invalid result type');
        }

        $params = [
            'UserID' => (int) $userId,
            'Result' => $resultType,
        ];
        $result = $this->rpcCall('TicketSearch', array_merge($params, $searchParams));

        return ($resultType === self::SEARCH_RESULT_ARRAY)? self::perlArray2PhpArray($result) : $result;
    }


    /**
     * to get the state list for a ticket (depends on workflow, if configured)
     * @param int $queueID
     * @param string $type
     * @param int $ticketID
     * @param int $userID
     * @return array StateID => StateName
     */
    public function getStateList($queueID = null, $type = null, $ticketID = null, $userID = 1)
    {
        if($queueID === null && $type === null && $ticketID === null) {
            throw new \InvalidArgumentException('at least one param $queueID|$type|$ticketID musst be set');
        }
        $params = [
            'UserID' => $userID,
        ];
        if($queueID !== null) {
            $params['QueueID'] = (int) $queueID;
        }
        if($type !== null) {
            $params['Type'] = $type;
        }
        return $this->rpcCall('TicketStateList', $params);
    }


    public function getStateListByType() {}
}

