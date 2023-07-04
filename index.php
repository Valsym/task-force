<?php
require 'vendor/autoload.php';

use taskforce\logic\AvailableActions;

$strategy = new AvailableActions('new', 1);
print_r($strategy);

assert($strategy->getNextStatus('act_cancel') == AvailableActions::STATUS_CANCEL, 'cancel');
print_r($strategy->getNextStatus('act_cancel'));
print_r($strategy->getNextStatus('act_complete'));
print_r($strategy->getNextStatus('act_deny'));
print_r($strategy->getStatusMap()['new']);
print_r($strategy->getActionsMap()['act_response']);