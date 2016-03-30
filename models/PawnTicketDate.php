<?php

class PawnTicketDate
{
   public $datePost;
   public $dateExpire;

   public static function get(array $parameters)
   {
       return WebService::getObject(
           array(
             'serviceName' => 'pawn',
             'serviceNumber' => '3112',
             'returnDataStartAt' => '1',
             'parameters' => $parameters,
             'class' => __CLASS__,
            )
         );
     }
}