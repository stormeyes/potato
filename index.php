<?php

require_once('potato/potato.php');

$application = new potato\potato(
    $debug = True
);

$application->run();
