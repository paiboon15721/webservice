<?php

class ListImage
{
   public $page;
   public $fileId;
   public $imgSource;
   public $imgDesc;
   public $imgType;
   public $imgTypeDesc;
   public $recStatus;
   public $pid;
   public $docPlace;
   public $docDate;
   public $imgDate;
   public $imgTime;

   public static function get(array $parameters)
   {
       return WebService::getObject(
           array(
             'serviceName' => 'imgmgt',
             'serviceNumber' => '4001',
             'returnDataStartAt' => '2',
             'parameters' => $parameters,
             'class' => __CLASS__,
            )
         );
     }
}