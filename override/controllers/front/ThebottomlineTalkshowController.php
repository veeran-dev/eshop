<?php
/*
* Bottomline landing controller added by Elumalai K
*/
class ThebottomlineTalkshowControllerCore extends FrontController 
{
	public $php_self = 'thebottomline-talkshow';

	public function display() {
		$this->context->smarty->assign(array('countries' => Country::getCountries(true)));
		$this->context->smarty->display(_PS_THEME_DIR_.'campaigns/bottomline.tpl');
	}

	public function ajaxReturn()
	{
		$firstname = Tools::getValue('firstname');
		$lastname = Tools::getValue('lastname');
		$email = Tools::getValue('email');
		$designation = Tools::getValue('designation');
		$id_country = Tools::getValue('id_country');

		if(BottomLine::alreadyRegistered($email)) {
			echo 'success';
			return false;
		}

		$bottomline = new BottomLine();
		$bottomline->firstname = $firstname;
		$bottomline->lastname = $lastname;
		$bottomline->email = $email;
		$bottomline->designation = $designation;
		$bottomline->id_country = $id_country;
		if($bottomline->add()) {
			echo 'success';
		}
	}
}