<?php
Class CategoryRestructureControllerCore Extends FrontController
{
	public $php_self = 'CategoryRestructure.php';
	public $auth = false;
	public $id_parent;
	public function postProcess()
	{
		$id_parent = $_GET['id_parent'];
		$category = new Category($id_parent);
		

		$child_set=array();
		
		$first_set_child = $this->getChildCategories($id_parent);//getting first set of child
		
		 for($i = 0; $i<sizeof($first_set_child); $i++)//getting second set of child
		 {//$i
			 if(sizeof($first_set_child[$i])>0)
			 {
				 $second_set = $this->getChildCategories($first_set_child[$i]['id_category']);
				 if($second_set)
				 {
					 for($k = 0; $k<sizeof($second_set); $k++)
					 {
						 if(sizeof($second_set[$k])>0)
						 { 
							 $third_set = $this->getChildCategories($second_set[$k]['id_category']);
							 if($third_set)
							 {
								 for($j = 0; $j<sizeof($third_set); $j++)//getting third set of child
								 {
									 if(sizeof($third_set[$j])>0)
									 {
										 $key_with_id_cat = $id_parent."-".$first_set_child[$i]['id_category']."-".$second_set[$k]['id_category']."-".$third_set[$j]['id_category'];
										 array_push($child_set,$key_with_id_cat);
									 }
									 else
									 {
										 
									 }
									
								 }//$j
							 }
							 else
							 {
								 $key_with_id_cat = $id_parent."-".$first_set_child[$i]['id_category']."-".$second_set[$k]['id_category']."-0";
								array_push($child_set,$key_with_id_cat);
							 }
						 }
						
					 }//$k
					 
				}
				else
					 {
						 $key_with_id_cat = $id_parent."-".$first_set_child[$i]['id_category']."-0-0";
						array_push($child_set,$key_with_id_cat);
					 }
			 }
			
		 }//$i
		 $this->assignChildToParentCategory($child_set);
	}
	 
	public function getChildCategories($id_category)
	{
		return Db::getInstance(_PS_USE_SQL_SLAVE_)->executeS('SELECT id_category FROM `'._DB_PREFIX_.'category` WHERE id_parent = '.$id_category);
	}
	public function  getCategoryProduct($id_category)
	{
		return Db::getInstance(_PS_USE_SQL_SLAVE_)->executeS('SELECT id_product FROM `'._DB_PREFIX_.'product` WHERE id_category_default = '.$id_category.' and active = 1');
	}
	public function assignChildToParentCategory($child_set)
	{
 
		for($i=0; $i<sizeof($child_set); $i++)
		{
			$child = explode("-", $child_set[$i]);
			
			if($child[3])//level4 product tages to level-3,2,1
			{
 				$third_set_product_child = $this->getCategoryProduct($child[3]);
 				if($third_set_product_child)
				{
					
					for($a =0; $a<sizeof($third_set_product_child); $a++)
					{
						Db::getInstance(_PS_USE_SQL_SLAVE_)->execute('INSERT IGNORE INTO `'._DB_PREFIX_.'category_product` (`id_category`,`id_product`) VALUE ('.$child[2].','.$third_set_product_child[$a]['id_product'].'),('.$child[1].','.$third_set_product_child[$a]['id_product'].'),('.$child[0].','.$third_set_product_child[$a]['id_product'].')');
					}
				}
			}
			if($child[2])//level3 product tages to level-2,1
			{
				$second_set_child = $this->getCategoryProduct($child[2]);
				if($second_set_child)
				{
					for($b =0; $b<sizeof($second_set_child); $b++)
					{
						Db::getInstance(_PS_USE_SQL_SLAVE_)->execute('INSERT IGNORE INTO `'._DB_PREFIX_.'category_product` (`id_category`,`id_product`) VALUE ('.$child[1].','.$second_set_child[$b]['id_product'].'),('.$child[0].','.$second_set_child[$b]['id_product'].')');
					}
				}
			}
			if($child[1])//level2 product tages to level-1
			{
				$first_set_child = $this->getCategoryProduct($child[1]);
				if($first_set_child)
				{
					for($c =0; $c<sizeof($first_set_child); $c++)
					{
						Db::getInstance(_PS_USE_SQL_SLAVE_)->execute('INSERT IGNORE INTO `'._DB_PREFIX_.'category_product` (`id_category`,`id_product`) VALUE ('.$child[0].','.$first_set_child[$c]['id_product'].')');
					}
				}
			}
			
		}
		echo "Product assign to parent Category Successfully";
		
	}
	
 }
?>