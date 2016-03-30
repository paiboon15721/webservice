<?php

class DatePost
{
   public $datePost;

   public static function get(array $parameters)
   {
       return WebService::getObject(
           array(
             'serviceName' => 'pawn',
             'serviceNumber' => '3110',
             'returnDataStartAt' => '1',
             'parameters' => $parameters,
             'class' => __CLASS__,
            )
         );
     }
}