<?php
namespace taskforce\logic\actions;
abstract class BaseAction
{
    abstract static public function getLabel();

    abstract static public function getInnerName();

    abstract static public function checkRights(int $userId, int $clientId, int $performerId);

}