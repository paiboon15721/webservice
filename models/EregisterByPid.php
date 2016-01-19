<?php

class EregisterByPid
{
   public $SITE_ID;
   public $SITE_NAME;
   public $PID;
   public $IDENTIFY_DOCTYPE;
   public $TITLE;
   public $TITLE_DESC;
   public $FNAME;
   public $MNAME;
   public $LNAME;
   public $SEX;
   public $REMARK;
   public $PASSWD;
   public $REGIS_DATE;
   public $REC_STATUS;
   public $DATE_STATUS;
   public $CANCEL_CODE;
   public $CANCEL_DATE;
   public $UPD_EMP;
   public $UPD_DATE;
   public $UPD_TIME;

   public static function get(array $parameters)
   {
       return WebService::getObject(
           array(
             'serviceName' => 'entertain',
             'serviceNumber' => '2056',
             'startAt' => '2',
             'parameters' => $parameters,
             'class' => __CLASS__,
            )
         );
     }
}