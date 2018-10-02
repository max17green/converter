<?php
namespace RestApiClass;

require_once("treatment/classes/RestApiClass.php");

//Запрос http://domen1/restApi.php?name=8091431

$name = htmlspecialchars($_GET["name"]);
$rest = new RestApi();
$str = $rest->getRestApi($name);
echo $str;
