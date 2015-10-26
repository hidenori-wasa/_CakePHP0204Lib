<?php

include_once './BreakpointDebugging_Inclusion.php';

$LockByShmopRequest = &\BreakpointDebugging_LockByShmopRequest::singleton(); // Creates a lock instance.
$LockByShmopRequest->lock(); // Locks php-code.
try {
    echo '"BreakpointDebugging_LockByShmopRequest" class test.';
} catch (\Exception $e) {
    $LockByShmopRequest->unlock(); // Unlocks php-code.
    throw $e;
}
$LockByShmopRequest->unlock(); // Unlocks php-code.
