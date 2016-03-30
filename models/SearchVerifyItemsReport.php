<?php

class SearchVerifyItemsReport
{
   public $docSeq;
   public $chkDate;
   public $chkTime;
   public $chkEmp;
   public $flag;
   public $bookName;
   public $police;
   public $pawnDocNo;
   public $pawnIssueNo;
   public $updDate;
   public $updTime;
   public $updEmp;
   public $docNo;
   public $docDate;

   public static function get(array $parameters)
   {
       return WebService::getObject(
           array(
             'serviceName' => 'pawn',
             'serviceNumber' => '5400',
             'returnDataStartAt' => '2',
             'parameters' => $parameters,
             'class' => __CLASS__,
            )
         );
     }
}