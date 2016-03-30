<?php

class ItemsReport
{
   public $docSeq;
   public $docNo;
   public $docYear;
   public $docDate;
   public $imgSource;
   public $cancelCode;
   public $cancelCause;

   public static function get(array $parameters)
   {
       return WebService::getObject(
           array(
             'serviceName' => 'pawn',
             'serviceNumber' => '5100',
             'returnDataStartAt' => '2',
             'parameters' => $parameters,
             'class' => __CLASS__,
            )
         );
     }
}