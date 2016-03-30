<?php

class PawnAccountReport
{
   public $month;
   public $people;
   public $capitalNo;
   public $capitalBaht;
   public $capitalSatang;
   public $redeemNo;
   public $redeemBaht;
   public $redeemSatang;
   public $fallNo;
   public $fallBaht;
   public $fallSatang;
   public $interestBaht;
   public $interestSatang;
   public $mark;
   public $accountId;

   public static function get(array $parameters)
   {
       return WebService::getObject(
           array(
             'serviceName' => 'pawn',
             'serviceNumber' => '4200',
             'returnDataStartAt' => '2',
             'parameters' => $parameters,
             'class' => __CLASS__,
            )
         );
     }
}