<?php

class TT
{
   public $id;
   public $name;

   public static function get(array $parameters)
   {
       return WebService::getObject(
           array(
             'serviceName' => 'tabst',
             'serviceNumber' => '1302',
             'returnDataStartAt' => '2',
             'parameters' => $parameters,
             'class' => __CLASS__,
            )
         );
     }
}