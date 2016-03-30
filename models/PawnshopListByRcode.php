<?php

class PawnshopListByRcode
{
   public $licId;
   public $siteName;
   public $siteId;

   public static function get(array $parameters)
   {
       return WebService::getObject(
           array(
             'serviceName' => 'pawn',
             'serviceNumber' => '2500',
             'returnDataStartAt' => '2',
             'parameters' => $parameters,
             'class' => __CLASS__,
            )
         );
     }
}