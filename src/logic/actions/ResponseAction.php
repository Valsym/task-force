<?php
namespace taskforce\logic\actions;

class ResponseAction extends BaseAction
{
    static public function getLabel()
    {
        return 'Откликнуться';
    }

    static public function getInnerName()
    {
        return 'act_response';
    }

    static public function checkRights(int $userId, int $clientId, int $performerId)
    {
        return $userId == $performerId;
    }
}