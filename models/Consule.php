<?php

class Consule
{
   public $consuleCode;
   public $consuleTdesc;
   public $consuleCtry;
   public $ctryTdesc;

   public static function get(array $parameters)
   {
       return WebService::getObject(
           array(
             'serviceName' => 'tabst',
             'serviceNumber' => '1010',
             'returnDataStartAt' => '2',
             'parameters' => $parameters,
             'class' => __CLASS__,
            )
         );
     }
}