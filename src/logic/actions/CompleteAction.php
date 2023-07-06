<?php
namespace taskforce\logic\actions;

class CompleteAction extends BaseAction
{
    static public function getLabel()
    {
        return 'Выполнено';
    }

    static public function getInnerName()
    {
        return 'act_complete';
    }

    static public function checkRights(int $userId, int $clientId, int $performerId)
    {
        return $userId == $performerId;
    }
}