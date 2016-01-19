<?php

class Rcode
{
   public $soiCode;
   public $soiDesc1;
   public $soiDesc2;

   public static function get(array $parameters)
   {
       return WebService::getObject(
           array(
             'serviceName' => 'tabst',
             'serviceNumber' => '1015',
             'startAt' => '2',
             'parameters' => $parameters,
             'class' => __CLASS__,
            )
         );
     }
}