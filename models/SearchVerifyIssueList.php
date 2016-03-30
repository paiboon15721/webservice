<?php

class SearchVerifyIssueList
{
   public $issueNo;
   public $updDatePawn;
   public $status;
   public $datePost;
   public $dateExpire;

   public static function get(array $parameters)
   {
       return WebService::getObject(
           array(
             'serviceName' => 'pawn',
             'serviceNumber' => '3100',
             'returnDataStartAt' => '2',
             'parameters' => $parameters,
             'class' => __CLASS__,
            )
         );
     }
}