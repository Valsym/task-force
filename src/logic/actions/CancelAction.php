<?php
namespace taskforce\logic\actions;

class CancelAction extends BaseAction
{
    static public function getLabel()
    {
        return 'Отменить';
    }

    static public function getInnerName()
    {
        return 'act_cancel';
    }

    static public function checkRights(int $userId, int $clientId, int $performerId)
    {
        return $userId == $clientId;
    }
}