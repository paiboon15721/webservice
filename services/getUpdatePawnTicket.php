<?php
require '../core/init.php';
header('Content-Type: application/json');
echo UpdatePawnTicket::get(
 array(
       Input::get('licRcode'),
       Input::get('licId'),
       Input::get('updEmpPawn'),
       Input::get('seq'),
       Input::get('issueNo'),
       Input::get('pawnDate'),
       Input::get('pawnNo'),
       Input::get('pawnName'),
       Input::get('pawnAddress'),
       Input::get('pawnDetail'),
       Input::get('pawnNumber'),
       Input::get('pawnBaht'),
       Input::get('pawnSatang'),
       Input::get('pawnMark'),
   )
)->getJSON();