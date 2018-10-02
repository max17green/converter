<?php
namespace Arhive;

require_once("classes/Arhive.php");

$a = new ArhiveClass();
if ($a->init($_GET["name"])) {
    if ($a->create()) {
        //echo "верно";
        $a->addIn();
        $a->output();
    } else {
        $a->printError();
    }
} else {
    $a->printError();
}
