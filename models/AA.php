<?php

class AA
{
   public $id;
   public $name;

   public static function get(array $parameters)
   {
       return WebService::getObject(
           array(
             'serviceName' => 'tabst',
             'serviceNumber' => '1301',
             'returnDataStartAt' => '2',
             'parameters' => $parameters,
             'class' => __CLASS__,
            )
         );
     }
}