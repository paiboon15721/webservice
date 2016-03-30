<?php
require '../core/init.php';
header('Content-Type: application/json');
echo LicId::get(
 array(
       Input::get('siteId'),
   )
)->getJSON();