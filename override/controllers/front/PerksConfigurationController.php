<?php
class PerksConfigurationControllerCore extends BackController
{
 	public $RM_auth = true;
	
 	public function displayContent()
  {	
    $domains = PerksCompanies::getAllDomains();
    $fc = new FulfillmentCentre();
    $states = $fc->getStates();
    $cities = $fc->getCities();

    $this->context->smarty->assign('domains', $domains);
    $this->context->smarty->assign('states', $states);
    $this->context->smarty->assign('cities', $cities);

    parent::displayContent();
    self::$smarty->display('rm/rm-perks.tpl');	
  }
  public function setMedia()
  {
    
  }

  	public function ajaxReturn()
  	{
      $logger = new FileLogger();
      $logger->setFilename('veeram.txt');
      $logger->logError("------");

  		$type = Tools::getValue('type');  		
      $id_group = Tools::getValue('id_group');
      $address1 = Tools::getValue('address1');
      $city = Tools::getValue('city');
      $state = Tools::getValue('state');
      $postcode = Tools::getValue('postcode');
      $email = Tools::getValue('email');


      $group = new Group($id_group);
      $logger->logError($group->name[1]);
      $logger->logError(PerksCompanies::getDomains($email));
      $checkCompanies = PerksCompanies::getDomains($email);
  		if($type == 1)
  		{
        if(!empty($checkCompanies))
        {
          echo "2";
          return true;
        }
  			$perks = new PerksCompanies();
  			$perks->name = $group->name[1];
  			$perks->email = $email;
  			$perks->id_group = $id_group;
        $perks->address1= $address1;
        $perks->city = $city;
        $perks->state = $state;
        $perks->postcode = $postcode;
  			if($perks->add())
  			{
  				echo "1";
  				return true;
  			}
  			else
  			{
  				echo "0";
  				return false;
  			}
  		}
  	}
}
 
?>