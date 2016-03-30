<?php
require '../core/init.php';
header('Content-Type: application/json');
echo ListImage::get(
 array(
       Input::get('docReg'),
       Input::get('docRegSub'),
       Input::get('docType'),
       Input::get('docTypeSub'),
       Input::get('indexOrd1'),
       Input::get('indexOrd2'),
       Input::get('indexOrd3'),
       Input::get('indexOrd4'),
       Input::get('indexOrd5'),
   )
)->getJSON();