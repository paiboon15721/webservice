<?php

class DeletePawnTicket
{
   public $status;

   public static function get(array $parameters)
   {
       return WebService::getObject(
           array(
             'serviceName' => 'pawn',
             'serviceNumber' => '3104',
             'returnDataStartAt' => '0',
             'parameters' => $parameters,
             'class' => __CLASS__,
            )
         );
     }
}