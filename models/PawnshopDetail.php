<?php

class PawnshopDetail
{
   public $siteName;
   public $siteLocate;
   public $siteHno;
   public $siteThanon;
   public $siteTrok;
   public $siteSoi;
   public $siteTtDesc;
   public $siteAaDesc;
   public $siteCcDesc;

   public static function get(array $parameters)
   {
       return WebService::getObject(
           array(
             'serviceName' => 'pawn',
             'serviceNumber' => '3114',
             'returnDataStartAt' => '1',
             'parameters' => $parameters,
             'class' => __CLASS__,
            )
         );
     }
}