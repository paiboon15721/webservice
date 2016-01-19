<?php

class Title
{

   public static function get(array $parameters)
   {
       return WebService::getObject(
           array(
             'serviceName' => 'tabst',
             'serviceNumber' => '1999',
             'startAt' => '2',
             'parameters' => $parameters,
             'class' => __CLASS__,
            )
         );
     }
}