<?php
Class Cookie extends CookieCore
{
	public function isLoggedBackCatalog($id_poc)
	{
		if($id_poc)
		{
			/* Vendor is valid only if it can be load and if cookie password is the same as database one */
		 	return ($this->id_poc
				AND Validate::isUnsignedId($this->id_poc)
				AND Vendor::checkPassword((int)$this->id_poc, $this->passwd)
				AND (!isset($this->_content['remote_addr']) OR $this->_content['remote_addr'] == ip2long(Tools::getRemoteAddr()) OR !Configuration::get('PS_COOKIE_CHECKIP'))
			);
		}
		else
		{
			/* Employee is valid only if it can be load and if cookie password is the same as database one */
		 	return ($this->id_employee
				AND Validate::isUnsignedId($this->id_employee)
				AND Employee::checkPassword((int)$this->id_employee, $this->passwd)
				AND (!isset($this->_content['remote_addr']) OR $this->_content['remote_addr'] == ip2long(Tools::getRemoteAddr()) OR !Configuration::get('PS_COOKIE_CHECKIP'))
			);
		}
	}
}