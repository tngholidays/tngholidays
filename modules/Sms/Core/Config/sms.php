<?php
	return[
		'default' => env('SMS_DRIVER', ''),
		'nexmo'=>[
			'url'=>'https://rest.nexmo.com/sms/json',
			'from'=>env('SMS_NEXMO_FROM','Booking Core'),
			'key'=>env('SMS_NEXMO_KEY',''),
			'secret'=>env('SMS_NEXMO_SECRET',''),
		],
		'twilio'=>[
			'url'=>'https://api.twilio.com',
			'from'=>env('SMS_TWILIO_FROM','+12019480710'),
			'sid'=>env('SMS_TWILIO_ACCOUNTSID',''),
			'token'=>env('SMS_TWILIO_TOKEN',''),
		],
		'tradelit'=>[
			'url'=>'http://msg.msgclub.net/rest/services/sendSMS/sendGroupSms',
			'from'=>env('SMS_TRADELIT_FROM','TNGHOL'),
			'token'=>env('SMS_TOKEN_KEY',''),
		],
		'whatsapp'=>[
			'url'=>'https://www.cp.bigtos.com/api/v1/sendmessage',
			'token'=>env('SMS_TOKEN_KEY',''),
		],
	];