<?php


$Route = $_GET['r'];

$RouteArray = explode('/', $Route);
$ClassName = ucfirst($RouteArray[0]);
$FuntionName = strtolower($RouteArray[1]);
$param_1 = "0";
$param_2 = "0";
if(!empty($RouteArray[2])){
    $param_1 = trim($RouteArray[2]);   
}
if(!empty($RouteArray[3])){
    $param_2 = trim($RouteArray[3]);   
}

$Context;
eval("\$Context = new " . $ClassName . "();");
eval("\$Context->" . $FuntionName . "(\"$param_1\" ,\"$param_2\");");
?>