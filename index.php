<?php
require 'vendor/autoload.php';

use taskforce\logic\AvailableActions;

$strategy = new AvailableActions('new', 1);
print_r($strategy);

//assert($strategy->getNextStatus('act_cancel') == AvailableActions::STATUS_CANCEL, 'cancel');
