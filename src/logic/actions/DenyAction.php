<?php
namespace taskforce\logic\actions;

class DenyAction extends BaseAction
{
    static public function getLabel()
    {
        return 'Отказаться';
    }

    static public function getInnerName()
    {
        return 'act_deny';
    }

    static public function checkRights(int $userId, int $clientId, int $performerId)
    {
        return $userId == $performerId;
    }
}