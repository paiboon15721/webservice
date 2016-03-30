<?php

class CC
{
   public $id;
   public $name;

   public static function get(array $parameters)
   {
       return WebService::getObject(
           array(
             'serviceName' => 'tabst',
             'serviceNumber' => '1300',
             'returnDataStartAt' => '2',
             'parameters' => $parameters,
             'class' => __CLASS__,
            )
         );
     }
}