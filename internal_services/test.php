<?php
require '../core/init.php';


$json = '["description", "flagAll", [{"test1":"kk", "test2":"kk"}, {"test1":"oo", "test2":"oo"}]]';


$parameters = json_decode($json, true);

$parameters = ["test", "test2", [["test3", "test4"]]];

function convertArrayToString($parameters, $sendMessage = '') {
    if (is_array($parameters)) {
        foreach ($parameters as $parameter) {
            convertArrayToString($parameter, $sendMessage);
        }
    } else {
        $sendMessage .= $parameters . '|';
    }
    return $sendMessage;
}

echo convertArrayToString($parameters);

//echo implode('|', $parameters);

//echo $parameters[2][0]['test1'];
//$json = '{"a":1,"b":2,"c":3,"d":4,"e":5}';

//var_dump(json_decode($json));

//print_r($parameters);

//echo WebService::produceSendMessage($parameters);
