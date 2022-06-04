<?php

namespace Modules\Sms\Core\Drivers;
use Modules\Sms\Core\Exceptions\SmsException;
use phpDocumentor\Reflection\DocBlock\Tags\Throws;

class WhatsAppDriver extends Driver
{

    protected $config;

    public function __construct($config)
    {
        $this->config = $config;
    }

    public function send()
    {
		
		//$type=(@$this->type!="")?@$this->type:"Text";
		$mobileno=str_replace('+','', $this->recipient);
		
    	$data = [
		    'msg'=>$this->message,
		    'mobileno'=>$mobileno,
		    'key'=>$this->config['token'],
			'type'=>"Text",
		   
			
	    ];
	    if(!empty($this->file)){
	        $data['File'] = @$this->file;
	        $data['type'] = 'Image';
	    }
		
		
        
	    $curl = $this->WhatsAppCurl($data);
	    $result = json_decode($curl,true);
	    if($result['status']=='Error'){
	    	throw  new SmsException($result['msg']);
	    }
	    return $result;
    }
    public function WhatsAppCurl($data){
		
		$ch = curl_init($this->config['url']);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
		$response = curl_exec($ch);
		curl_close($ch);
	    return $response;
	}


}