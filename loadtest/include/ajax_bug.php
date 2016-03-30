<?php
	header('Content-Type: text/html; charset=utf-8');
	include("connws.php"); 
	
	 ///set default value
	if(count($_POST["func"]) != 0){
		foreach($_POST as $key => $val ){
			if(count($_POST[$key]) == 0){
				$_POST[$key] = "";
			}
		}

		$strSend 	= $_POST['strSend'];
		$func 		= $_POST["func"];
		$current 	= $_POST['current'];
		$restrict 		= $_POST['restrict'];
		
		switch($func){
			case "genCatm" : $ans = genCatm($strSend); break;
			default : $ans = $func($strSend , $current ,$restrict); break;
			}
		
		$testArr = Array("ans"=> $ans);
		echo json_encode($testArr);
	}

	function getBug($strSend = null , $current = null , $restrict = null , $display = null){
		$service = "sdpa_test";
		$strArr = explode("|" , $strSend);
		$sCode = $strArr[0];
		// $sCode = substr($strSend,0,4);
		
		
		
		switch($sCode){
			case "1399" : $strSend = "1300|00|0"; break;
			case "1300" :
			// case "1399" : $strReceive = "1300|0|0"; break;
		}
		$strReceive = connDPAWS($service,$strSend,"0");
		
		if($display != null){
			return $strReceive;
		}
		
		$data = Array();
		// $strReceive = iconv('UTF-8','TIS-620',$strReceive);
		$recArr = explode("|",$strReceive);  
		$result = $recArr[0];
		$total = $recArr[1];
		
		$falseValArr = Array("0" , '99' , '999');
		if (in_array($result , $falseValArr)){
			return "0".$strReceive ."\nstrSend : " . $strSend;
		}
		
		
		array_shift($recArr);
		array_shift($recArr);
		$ansArr = array_chunk($recArr,2);
		$regionArr = Array("10","20","30","41","50","65","73","84","90");
		$returnData = Array();
		
		$regionCount = 0 ;
		for( $i =0 ; $i < $total ; $i++){
			$ccaattmm = $ansArr[$i][0]; 
			$fullDesc 	 = $ansArr[$i][1]; 
			$fullDesc = str_replace("local","",$fullDesc);
			$fullDesc = str_replace("province","",$fullDesc);		
			if(($ccaattmm >= 38) &&($ccaattmm < 50) ){
				$region = "4"; 
			}else{
				$region = substr($ccaattmm,0,1);
			}

			$curNum = strlen($current);
			

			if($sCode == "1399" ){
				if(in_array($ccaattmm, $regionArr)){
					$data[$regionCount]['rcode'] 	=  substr($ccaattmm,0,1);
					$data[$regionCount]["desc"]	= "zone".$region." ".$fullDesc;
					$data[$regionCount]['region']	=  $region;
					$regionCount++;
				}
			}else if($sCode == "1301"){			
				$data[$regionCount]['rcode'] 	=  $strArr[1] . $ccaattmm; /// full Rcode receive
				$data[$regionCount]["desc"]	= 	$fullDesc ;
				$data[$regionCount]['region'] =  $region;
				$regionCount++;
			}else{
				$data[$regionCount]['rcode'] 	=  $ccaattmm  ;
				$data[$regionCount]["desc"]	= 	$fullDesc ;
				$data[$regionCount]['region'] =  $region;
				$regionCount++;
			}
		}
		$returnData = $data;
		return $returnData;

	}

?>
