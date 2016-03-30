<?php

class PawnAccountDetail
{
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

   public static function get(array $parameters)
   {
       return WebService::getObject(
           array(
             'serviceName' => 'pawn',
             'serviceNumber' => '4103',
             'returnDataStartAt' => '1',
             'parameters' => $parameters,
             'class' => __CLASS__,
            )
         );
     }
}