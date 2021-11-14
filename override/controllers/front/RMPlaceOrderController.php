<?php
class RMPlaceOrderControllerCore extends BackController
{
	public function displayContent()
	{
		parent::init();

		$this->context->smarty->display('rm/rm-placeorder.tpl');	
 	}
	
	public function getCustomerList()
	{
		$this->init();
		echo Tools::jsonEncode(Group::getGroups(true));
	}
	
	public function createNewProductExpress()
	{
		/*$logger = new FileLogger();
		$logger->setFilename('test-log.txt');*/
		
		$this->init();
		
		//Read Post Data
		$name=$_POST['productName'];
		$priceTE=$_POST['priceTE'];
		$vat = $_POST['id_tax_rules_group'];
		$custPrice = $_POST['custPrice'];
		$listId = $_POST['purlist'];
		$id_customer = $_POST['customerId'];
		
		//Create Product
		$p = new Product();
		$p->name[1] = (string)$name;
		$p->id_tax_rules_group = $vat;
		$p->price = $priceTE;
		$p->condition = "new";
  		$link_rewrite = str_replace(' ', '-', $name); // Replaces all spaces with hyphens.

		$link_rewrite_value = preg_replace('/[^A-Za-z0-9\-]/', '', $link_rewrite); // Removes special chars.
		$link_rewrite_value = str_replace('--', '-', $link_rewrite_value);
		$link_rewrite_value = rtrim($link_rewrite_value,'-');
 		$p->link_rewrite[1] = $link_rewrite_value;
		
		//Add product
		if($p->add()){
			//Product Created
			//Add to Home Category
			$cat = array(1);
			$p->addToCategories($cat);
			$p->id_category_default = 1;
			if($p->update())
			{
				//Indexing product for search
				Search::indexation(false,(int)($p->id));

				//send email to catelog team
				$productObject = new Product((int)($p->id));
				Product::newProductAddedEmail($productObject);
				
				if(!empty($listId))
				{
					//Add to Purchase List
					$rate=new RateContract();
					$rate->addratecontract($p->id, (int)$id_customer, (int)$listId);
				}
				
				if(!empty($custPrice)){
					//Add Specific Price
					$id_product = (int)$p->id;
					$id_shop = 1;
					$id_currency = 0;
					$id_country = 0;
					$cust = new Customer($id_customer);
					$id_group = $cust->id_default_group;
					$price = $custPrice;
					$from_quantity = 1;
					$reduction = 0;
					$reduction_type = 'amount';
					
					$specificPrice = new SpecificPrice();
					$specificPrice->id_product = $id_product;
					$specificPrice->id_shop = (int)($id_shop);
					$specificPrice->id_currency = (int)($id_currency);
					$specificPrice->id_country = (int)($id_country);
					$specificPrice->id_group = (int)($id_group);
					$specificPrice->price = (float)($price);
					$specificPrice->from_quantity = (int)($from_quantity);
					$specificPrice->reduction = (float)($reduction_type == 'percentage' ? $reduction / 100 : $reduction);
					$specificPrice->reduction_type = $reduction_type;
					$specificPrice->from = !$from ? '0000-00-00 00:00:00' : $from;
					$specificPrice->to = !$to ? '0000-00-00 00:00:00' : $to;
					if ($specificPrice->add())
					{
						//Success
					}
					else
					{
						$failResult = array(
							"result" => 0
						);
						return json_encode($failResult);
						
					}
				}
			}
			else
			{
				$failResult = array(
					"result" => 0
				);
				return json_encode($failResult);
			}
		}
		else{
			$failResult = array(
				"result" => 0
			);
			return json_encode($failResult);
		}
		
		
		//$logger->logInfo($p->id . " - " . $p->name . "-". $id_customer);
		
		//return $name.$mrp.$vat.$custPrice.$listId.$id_customer;
		$passResult = array(
			"result" => 1,
			"id_product" => $p->id,
			"id_product_attribute" => empty($custPrice) ? $priceTE : $custPrice,
			"name" => $p->name[1],
			"link" => $p->link_rewrite[1],
			"reference"=> $p->reference
		);
		
		return json_encode($passResult);
	}
	
	public function ajaxReturn()
	{
 		$type = Tools::getValue('type');  
 		$id_group = Tools::getValue('id_group');  
		 
		if(isset($type))
		{
			if($type == 1) {
				$data = RelationshipManager::getCustomerInGroup($id_group);
			}

 			echo Tools::jsonEncode($data);
		}
	}
}

?>