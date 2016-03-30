<?php
require '../core/init.php';
header('Content-Type: application/json');
echo InsertPawnAccount::get(
 array(
       Input::get('licRcode'),
       Input::get('licId'),
       Input::get('month'),
       Input::get('year'),
       Input::get('people'),
       Input::get('capitalNo'),
       Input::get('capitalBaht'),
       Input::get('capitalSatang'),
       Input::get('redeemNo'),
       Input::get('redeemBaht'),
       Input::get('redeemSatang'),
       Input::get('fallNo'),
       Input::get('fallBaht'),
       Input::get('fallSatang'),
       Input::get('interestBaht'),
       Input::get('interestSatang'),
       Input::get('mark'),
       Input::get('cancelCode'),
       Input::get('cancelCause'),
       Input::get('updDatePawn'),
       Input::get('updTimePawn'),
       Input::get('updEmpPawn'),
   )
)->getJSON();