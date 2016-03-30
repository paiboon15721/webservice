<?php

class VerifyPawnAccount
{
   public $licId;
   public $siteName;
   public $accountId;
   public $updDatePawn;

   public static function get(array $parameters)
   {
       return WebService::getObject(
           array(
             'serviceName' => 'pawn',
             'serviceNumber' => '4100',
             'returnDataStartAt' => '2',
             'parameters' => $parameters,
             'class' => __CLASS__,
            )
         );
     }
}