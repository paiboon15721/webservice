<?php

class LicId
{
   public $licId;
   public $licRcode;

   public static function get(array $parameters)
   {
       return WebService::getObject(
           array(
             'serviceName' => 'pawn',
             'serviceNumber' => '6000',
             'returnDataStartAt' => '1',
             'parameters' => $parameters,
             'class' => __CLASS__,
            )
         );
     }
}