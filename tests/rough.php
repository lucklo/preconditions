<?php

include_once "../vendor/autoload.php";

if (precondition() instanceof \Preconditions\Preconditions) {
    echo 'works';
}