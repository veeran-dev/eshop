<?php

class SMSAlert extends ObjectModel
{
	public static function sendSMSAlert($receipientno, $msgtxt)
	{
		$ch = curl_init();
		$user="karthik@kobster.com:Kob5%25ST";
		$senderID="KOBSTR"; 
		curl_setopt($ch, CURLOPT_URL,  "http://api.mVaayoo.com/mvaayooapi/MessageCompose");
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, "user=$user&senderID=$senderID&receipientno=$receipientno&msgtxt=$msgtxt");
		$buffer = curl_exec($ch);
		curl_close($ch);
	}
}

