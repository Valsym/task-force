<?php
require 'vendor/autoload.php';

//require_once __DIR__.  '\src\logic\AvailableActions.php';
use taskforce\logic\Task;

$strategy = new Task('new', 1, 0);
print_r($strategy);

assert($strategy->getNextStatus('act_cancel') == Task::STATUS_CANCEL, 'cancel');
