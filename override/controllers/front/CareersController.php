<?php 
class CareersControllerCore extends DashController
{
	public function ajaxReturn()
	{	
		
		$recievedData = array(
			'fullname' 			=> trim(Tools::getValue('fullname')),
			'email' 			=> trim(Tools::getValue('email')),
			'mobile' 			=> trim(Tools::getValue('mobile')),
			'department' 		=> trim(Tools::getValue('department')),
			'linkedin' 			=> trim(Tools::getValue('linkedin')),
			'website' 			=> trim(Tools::getValue('website')),
			'message' 			=> trim(Tools::getValue('message'))
		);

		$uploads_dir 		= 'resume';
		$fileAttachment 	= $_FILES['resume']['tmp_name'];
		$fileName 			= uniqid()."_".$_FILES['resume']['name'];
		$file_dir 			= _PS_BASE_URL_.__PS_BASE_URI__."resume/".$fileName;
		move_uploaded_file($fileAttachment, $uploads_dir."/".$fileName);
		
		$mailData = array(
			'{fullname}' 		=> $recievedData['fullname'],
			'{email}' 			=> $recievedData['email'],
			'{mobile}' 			=> $recievedData['mobile'],
			'{department}' 		=> $recievedData['department'],
			'{linkedin}' 		=> $recievedData['linkedin'],
			'{website}' 		=> $recievedData['website'],
			'{message}' 		=> $recievedData['message'],
			'{fileName}'		=> $_FILES['resume']['name'],
			'{fileNameUpdated}'	=> $fileName,
			'{file_dir}'		=> $file_dir
		);
		
		
		$to			= $recievedData['email'];
		$toName 	= $recievedData['fullname'];
		$from		= "jobs@kobster.com";
		$fromName 	= "HR Team from Kobster";
		$subject 	= $recievedData['fullname'].', Thanks for Applying to Kobster';
		Mail::Send(1, 'careers_employee', $subject, $mailData, $to, $toName, $from, $fromName);
		
		//Mail::Send(1, 'careers_employee', Mail::l($subject,1), $mailData, $rec_email, $toName);
		//Mail::Send($id_land, $template_name, $title, $templateVars, $customer->email, $toName, $from, $fromName, $fileAttachment);
		
		$to			= "jobs@kobster.com";
		$toName 	= "HR Team";
		$from		= $recievedData['email'];
		$fromName 	= $recievedData['fullname'];
		$subject 	= "Job Application for ".$recievedData['department']." team, from ".$recievedData['fullname'];
		Mail::Send(1, 'careers_employer', $subject, $mailData, $to, $toName, $from, $fromName, $file_dir);
		
		echo "success";

	}
	
	
}
?>