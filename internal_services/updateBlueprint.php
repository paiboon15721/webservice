<?php
require '../core/init.php';
header('Content-Type: application/json');

$blueprint = new Blueprints();
$blueprint->setBlueprintName(Input::get('blueprintName'));
$blueprint->setServiceName(Input::get('serviceName'));
$blueprint->setServiceNumber(Input::get('serviceNumber'));
$blueprint->setStartAt(Input::get('startAt'));
$blueprint->setParameters(json_decode(Input::get('parameters')));
$blueprint->setProperties(json_decode(Input::get('properties')));
echo $blueprint->update();