<?php
require '../core/init.php';
header('Content-Type: application/json');
echo InsertItemsReport::get(
 array(
       Input::get('docSeq'),
       Input::get('licRcode'),
       Input::get('licId'),
       Input::get('checkDate'),
       Input::get('checkEmp'),
       Input::get('flag'),
       Input::get('bookName'),
       Input::get('police'),
       Input::get('pawnDocNo'),
       Input::get('pawnIssueNo'),
       Input::get('updEmp'),
   )
)->getJSON();