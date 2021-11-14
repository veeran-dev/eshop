<?php
/*
* 2007-2015 PrestaShop
*
* NOTICE OF LICENSE
*
* This source file is subject to the Open Software License (OSL 3.0)
* that is bundled with this package in the file LICENSE.txt.
* It is also available through the world-wide-web at this URL:
* http://opensource.org/licenses/osl-3.0.php
* If you did not receive a copy of the license and are unable to
* obtain it through the world-wide-web, please send an email
* to license@prestashop.com so we can send you a copy immediately.
*
* DISCLAIMER
*
* Do not edit or add to this file if you wish to upgrade PrestaShop to newer
* versions in the future. If you wish to customize PrestaShop for your
* needs please refer to http://www.prestashop.com for more information.
*
*  @author PrestaShop SA <contact@prestashop.com>
*  @copyright  2007-2015 PrestaShop SA
*  @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
*  International Registered Trademark & Property of PrestaShop SA
*/

class FeedbackControllerCore extends FrontController
{
    public $php_self = 'feedback';

    // Dummy check for deploy..

    public function setMedia()
    {
        parent::setMedia();
        $this->addJS(_PS_JS_DIR_.'feedback-validate.js');
		$this->addJS(_PS_JS_DIR_.'jquery/jquery.validate.min.js');
    }

    /**
     * Assign template vars related to page content
     * @see FrontController::initContent()
     */
    public function initContent()
    {
        parent::initContent();
		
		$feedback_detail = array(
			'feedback' 		=> trim(Tools::getValue('feedback')),
			'mode' 			=> trim(Tools::getValue('mode')),
			'detail' 		=> trim(Tools::getValue('detail')),
			'email' 		=> trim(Tools::getValue('email')),
			'id_customer' 	=> trim(Tools::getValue('customer')),
			'mail_title' 	=> trim(Tools::getValue('mail_title'))
		);
		if ($feedback_detail['feedback'] == 1){
			$this->context->smarty->assign('title', "Glad that you loved our service, Thank you!");
			$this->context->smarty->assign('place_holder', "We would love to hear more about this from you.");
		}
		else if ($feedback_detail['feedback'] == 2){
			$this->context->smarty->assign('title', "Sorry that you had to go through this experience. We'll redress it shortly!");
			$this->context->smarty->assign('place_holder', "Help us understand more about your concern.");
		}
		
		$table = 'email_feedback';
		if(Db::getInstance()->insert($table, $feedback_detail)){
			
			$id_feedback = Db::getInstance()->Insert_ID(); 
			$this->context->smarty->assign('id_feedback', $id_feedback);
			
			if($feedback_detail['feedback'] == 1) $feedback = "Good";
			else if($feedback_detail['feedback'] == 2) $feedback = "Bad";
			
			if($feedback_detail['mode'] == 0){ $mode = "Unknown"; $detail_name = "Mail Type"; }
			else if($feedback_detail['mode'] == 1){ $mode = "Order"; $detail_name = "Order Id"; }
			else if($feedback_detail['mode'] == 2){ $mode = "Campaign"; $detail_name = "Campaign name"; }
			
			$mailData = array(
				'{feedback}' 		=> $feedback,
				'{email}' 			=> $feedback_detail['email'],
				'{mode}' 			=> $mode,
				'{detail_name}' 	=> $detail_name,
				'{detail}' 			=> $feedback_detail['detail'],
				'{id_customer}' 	=> $feedback_detail['id_customer'],
				'{message}' 		=> $feedback_detail['message'],
				'{mail_title}' 		=> $feedback_detail['mail_title']
			);
			
			$to			= "rakesh.r@kobster.com";
			$toName 	= "Kobster Support";
			$from		= "noreply@kobster.com";
			$fromName 	= $feedback_detail['email'];
			$subject 	= 'Review from '. $feedback_detail['email'];
	
			Mail::Send(1, 'feedback_internal', $subject, $mailData, $to, $toName, $from, $fromName);	
		}

		
        $this->setTemplate(_PS_THEME_DIR_.'email-feedback.tpl');
    }
	
	public function ajaxReturn()
	{
		
		$id_feedback	= trim(Tools::getValue('feedback_id'));
		$message		= trim(Tools::getValue('message'));
		$supplier		= trim(Tools::getValue('supplier'));
		$table = 'email_feedback';
		if ( Db::getInstance()->update($table, array('message'=>$message), 'id_feedback = '.(int)$id_feedback) ){
			
			$table = 'email_feedback';
			$query = "SELECT * FROM "._DB_PREFIX_.$table." WHERE `id_feedback` = ".$id_feedback;
			if ( $feedback_detail = Db::getInstance()->getRow($query) ){
				
				if($feedback_detail['feedback'] == 1) $feedback = "Good";
				else if($feedback_detail['feedback'] == 2) $feedback = "Bad";
				
				if($feedback_detail['mode'] == 0){ $mode = "Unknown"; $detail_name = "Mail Type"; }
				else if($feedback_detail['mode'] == 1){ $mode = "Order"; $detail_name = "Order Id"; }
				else if($feedback_detail['mode'] == 2){ $mode = "Campaign"; $detail_name = "Campaign name"; }

				
				$mailData = array(
					'{feedback}' 		=> $feedback,
					'{email}' 			=> $feedback_detail['email'],
					'{mode}' 			=> $mode,
					'{detail_name}' 	=> $detail_name,
					'{detail}' 			=> $feedback_detail['detail'],
					'{id_customer}' 	=> $feedback_detail['id_customer'],
					'{message}' 		=> $feedback_detail['message'],
					'{mail_title}' 		=> $feedback_detail['mail_title']
				);
				
				$to			= "rakesh.r@kobster.com";
				$toName 	= "Kobster Support";
				$from		= "noreply@kobster.com";
				$fromName 	= $feedback_detail['email'];
				$subject 	= $supplier == true ?'Supplier Review from '. $feedback_detail['email'] : 'Review from '. $feedback_detail['email'];;
		
				Mail::Send(1, 'feedback_internal', $subject, $mailData, $to, $toName, $from, $fromName);
			}
			
			echo 1;
		}
		else {
			echo 2;	
		}
	}
}
