<?php
require '../core/init.php';
header('Content-Type: application/json');

echo Blueprints::find(Input::get('blueprintName'))->delete();