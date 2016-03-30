<?php

class UpdatePawnAccount
{
   public $status;

   public static function get(array $parameters)
   {
       return WebService::getObject(
           array(
             'serviceName' => 'pawn',
             'serviceNumber' => '4300',
             'returnDataStartAt' => '0',
             'parameters' => $parameters,
             'class' => __CLASS__,
            )
         );
     }
}