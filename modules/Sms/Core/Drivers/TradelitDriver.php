<?php

namespace Modules\Sms\Core\Drivers;
use Modules\Sms\Core\Exceptions\SmsException;
use phpDocumentor\Reflection\DocBlock\Tags\Throws;

class TradelitDriver extends Driver
{

    protected $config;

    public function __construct($config)
    {
        $this->config = $config;
    }

    public function send()
    {
		
    	$data = [
    		'senderId'=>$this->config['from'],
		    'message'=>$this->message,
		    'mobileNos'=>$this->recipient,
		    'api_key'=>$this->config['token'],
		   
			
	    ];

	    $curl = $this->tradelitCurl($data);
	    $result = json_decode($curl,true);
	    if($result['responseCode']==0){
	    	throw  new SmsException($result['response']);
	    }
	    return $result;
    }
    public function tradelitCurl($data){
	  
	    
		$curl = curl_init();
		
		curl_setopt_array($curl, array(
		  CURLOPT_PORT => "80",
		  CURLOPT_URL => $this->config['url']."?AUTH_KEY=".$data['api_key']."&message=".urlencode($data['message'])."&senderId=".$data['senderId']."&routeId=1&mobileNos=".$data['mobileNos']."&smsContentType=english",
		  CURLOPT_RETURNTRANSFER => true,
		  CURLOPT_ENCODING => "",
		  CURLOPT_MAXREDIRS => 10,
		  CURLOPT_TIMEOUT => 30,
		  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		  CURLOPT_CUSTOMREQUEST => "GET",
		  CURLOPT_HTTPHEADER => array(
			"Cache-Control: no-cache"
		  ),
		));
		
		$response = curl_exec($curl);
		$err = curl_error($curl);
		
		curl_close($curl);
		
	   
	    return $response;
	}


}