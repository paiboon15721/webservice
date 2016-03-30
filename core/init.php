<?php
ini_set('max_execution_time', 300);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
header('Content-Type: text/html; charset=tis-620');
$GLOBALS['config'] = array(
    'web_service' => array(
        'url' => 'http://ews.dopa.go.th:8080/wsdl',
        //'url' => 'http://172.16.224.205:8080/wsdl',
        'b_service_name' => 'bdpa_wsreqlicWS',
        'encoding' => 'UTF-8',
    )
);

function my_autoloader($class)
{
    $path = '';
    $pathClasses = '../classes/' . $class . '.php';
    $pathModels = '../models/' . $class . '.php';

    if (file_exists($pathClasses)) {
        $path = $pathClasses;
    } elseif (file_exists($pathModels)) {
        $path = $pathModels;
    }
    include $path;
}

spl_autoload_register('my_autoloader');
