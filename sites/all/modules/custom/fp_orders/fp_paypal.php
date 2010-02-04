<?php
/**
 * @author ray.zhang
 * @copyright Copyright (c) 2008 Red8studios Inc. (www.red8studios.com)
 * @date Apr 14, 2009
 * @encoding UTF-8
 * @version 
*/

/**
  * hash_call: Function to perform the API call to PayPal using API signature
  * @methodName is name of API  method.
  * @nvpStr is nvp string.
  * returns an associtive array containing the response from the server.
*/

function deformatNVP($nvpstr){
	$intial=0;
 	$nvpArray = array();

	while(strlen($nvpstr)){
		//postion of Key
		$keypos= strpos($nvpstr,'=');
		//position of value
		$valuepos = strpos($nvpstr,'&') ? strpos($nvpstr,'&'): strlen($nvpstr);

		/*getting the Key and Value values and storing in a Associative Array*/
		$keyval=substr($nvpstr,$intial,$keypos);
		$valval=substr($nvpstr,$keypos+1,$valuepos-$keypos-1);
		//decoding the respose
		$nvpArray[urldecode($keyval)] =urldecode( $valval);
		$nvpstr=substr($nvpstr,$valuepos+1,strlen($nvpstr));
     }
	return $nvpArray;
}

function fp_paypal_hash_call($methodName,$nvpStr, $profile){
	
	$nvpreq="METHOD=".urlencode($methodName);
	
	foreach($profile as $k=>$v){
		if ($k == "ENVIRONMENT" || $k == "API_ENDPOINT"){
			continue;
		}
		$nvpreq .= "&".$k."=".urlencode($v);
	}
	$nvpreq .= $nvpStr;
	
	#var_dump($nvpreq, $nvpStr);
	//exit;
	
	//setting the curl parameters.
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL,$profile['API_ENDPOINT']);
	curl_setopt($ch, CURLOPT_VERBOSE, 1);

	//turning off the server and peer verification(TrustManager Concept).
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
	curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);

	curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
	curl_setopt($ch, CURLOPT_POST, 1);

	//if USE_PROXY constant set to TRUE in Constants.php, then only proxy will be enabled.
    //Set proxy name to PROXY_HOST and port number to PROXY_PORT in constants.php 
	/*if(USE_PROXY)
	curl_setopt ($ch, CURLOPT_PROXY, PROXY_HOST.":".PROXY_PORT);*/ 

	//NVPRequest for submitting to server
	

	//setting the nvpreq as POST FIELD to curl
	curl_setopt($ch,CURLOPT_POSTFIELDS,$nvpreq);

	//getting response from server
	$response = curl_exec($ch);

	//convrting NVPResponse to an Associative Array
	$nvpResArray=deformatNVP($response);
	$nvpReqArray=deformatNVP($nvpreq);
	$_SESSION['nvpReqArray']=$nvpReqArray;

	if (curl_errno($ch)) {
		// moving to display page to display curl errors
		$_SESSION['curl_error_no']=curl_errno($ch) ;
		$_SESSION['curl_error_msg']=curl_error($ch);
		$location = "APIError.php";
		header("Location: $location");
	} else {
	 //closing the curl
		curl_close($ch);
	}
	return $nvpResArray;
}

/** This function will take NVPString and convert it to an Associative Array and it will decode the response.
  * It is usefull to search for a particular key and displaying arrays.
  * @nvpstr is NVPString.
  * @nvpArray is Associative Array.
  */



function fp_paypal_create_profile($username, $password, $signature, $environment){
 	$profile = array();
 	if ($environment == "sandbox"){
 		$profile['API_ENDPOINT'] = 'https://api-3t.sandbox.paypal.com/nvp';
 	}
 	else {
 		$profile['API_ENDPOINT'] = 'https://api-3t.paypal.com/nvp';
 	}
 	
	$profile['VERSION'] 	= '56.0';
	$profile['USER'] 		= $username;
   	$profile['PWD'] 		= $password;
   	$profile['SIGNATURE']	= $signature; 
   	$profile['ENVIRONMENT']	= $environment;
   	
   	return $profile;
}

function fp_paypal_directpayment($profile, $payment_info){
	
	$payment_info['PAYMENTACTION']	= "Sale";
	$payment_info['CURRENCYCODE']	= "USD";
	
	$nvpstr = "";
	foreach ($payment_info as $k => $v){
		$nvpstr .= "&".$k."=".urlencode($v);
	}
	
	watchdog('fp', 'making direct payment with profile ' . print_r($profile, true));
	$resArray=fp_paypal_hash_call("doDirectPayment",$nvpstr, $profile);
	
	$ack = strtoupper($resArray["ACK"]);
	
	#var_dump($nvpstr, $resArray,$profile);
	//exit;

	$result = array();
	if($ack == "SUCCESS" || $ack == "SUCCESSWITHWARNING") {
    	$result["result"] 		 = "success";
    	$result['transaction_id'] = $resArray['TRANSACTIONID'];
    	$result['message'] 		 = $resArray['L_LONGMESSAGE0'];
    	$result['amount']		 = $resArray['AMT'];
   	}
   	else {
   		$result["result"] 		 = "failure";
   		$result['errorcode']	 = $resArray['L_ERRORCODE0'];
    	$result['message'] 		 = $resArray['L_LONGMESSAGE0'];
   	}
   	return $result;
}

function fp_paypal_reference_payment($profile, $payment_info){
	$payment_info['PAYMENTACTION']	= "Sale";
	$payment_info['CURRENCYCODE']	= "USD";
	
	$nvpstr = "";
	foreach ($payment_info as $k => $v){
		$nvpstr .= "&".$k."=".urlencode($v);
	}
	
	$resArray=fp_paypal_hash_call("DoReferenceTransaction",$nvpstr, $profile);
	
	$ack = strtoupper($resArray["ACK"]);
	
	$result = array();
	if($ack == "SUCCESS" || $ack == "SUCCESSWITHWARNING") {
    	$result["result"] 		  = "success";
    	$result['transaction_id'] = $resArray['TRANSACTIONID'];
    	$result['message'] 		  = "Reference Payment:".$payment_info['REFERENCEID'];
    	$result['amount']		  = $resArray['AMT'];
   	}
   	else {
   		$result["result"] 		  = "failure";
   		$result['transaction_id'] = "ERROR";
   		$result['errorcode']	  = $resArray['L_ERRORCODE0'];
    	$result['message'] 		  = sprintf("Reference Payment: %s, CODE: %s, MSG: %s" ,
    			$payment_info['REFERENCEID'], $resArray['L_ERRORCODE0'], $resArray['L_LONGMESSAGE0']);
    	$result['amount']		  = 0;
   	}
   	return $result;
}

/*$profile = fp_paypal_create_profile("urbani_1239776670_biz_api1.red8studios.com", "1239776682", 
	"A4CrGB3XOwo25dz1G6FOXe4Misp4At6BE4HNlHTPYIAvDx06UggvIwix", "sandbox");

$payment_info = array();

$payment_info['FIRSTNAME'] 		= "Ray";
$payment_info['LASTNAME']  		= "Zhang";
$payment_info['AMT']			= 39.95;
$payment_info['CURRENCYCODE']	= "USD";

$payment_info['CREDITCARDTYPE'] = "Visa";
$payment_info['ACCT'] 			= "4983393953286947";
$payment_info['EXPDATE']		= sprintf("%02d%04d", 12, 2009);
$payment_info['CVV2']			= "123";
$payment_info['IPADDRESS']		= "192.168.1.1";

$payment_info['STREET']			= "address1";
$payment_info['CITY']			= "city";
$payment_info['STATE']			= "state";
$payment_info['ZIP']			= "20091";
$payment_info['COUNTRYCODE']	= "US";

fp_paypal_directpayment($profile, $payment_info);*/

/*$payment_info = array();
$payment_info['AMT'] = 29.95;
$payment_info['REFERENCEID'] = "3X38482754317903J111";
fp_paypal_reference_payment($profile, $payment_info);*/
?>