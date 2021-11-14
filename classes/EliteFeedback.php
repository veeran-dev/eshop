<?php

class EliteFeedbackCore extends ObjectModel
{
	/** @var integer id_feedback  */
	public		$id_feedback;

	/** @var integer order id  */
	public		$id_order;

	/** @var integer customer id  */
	public		$id_customer;

	/** @var integer rating */
	public 		$rating;

	/** @var context comments */
	public 		$comment;

	protected 	$table = 'elite_feedback';
	protected 	$identifier = 'id_feedback';
	protected 	$fieldsRequired = array('id_order','id_customer','rating','comment');
	protected 	$fieldsValidate = array('id_order' => 'isUnsignedId','id_customer'=>'isUnsignedId');

	public	function getFields()
	{
	 	parent::validateFields();
		$fields['id_order'] = (int)$this->id_order;
		$fields['id_customer'] = (int)$this->id_customer;
		$fields['rating'] = (int)$this->rating;
		$fields['comment'] = pSQL($this->comment);
		return $fields;
	}

	public function completedOrder($id_customer) {
		$sqlQuery = "SELECT DATE_FORMAT(koh.`date_add`,'%d-%b-%Y') AS date_add,koh.`id_order` FROM `kob_order_history` koh
					LEFT JOIN `kob_orders` ko ON(koh.`id_order`=ko.`id_order`)
					LEFT JOIN `kob_customer` kc ON(ko.`id_customer`=kc.`id_customer`)
					WHERE kc.`id_customer`=".$id_customer."
					AND ko.`id_order` NOT IN(SELECT id_order FROM  `kob_elite_feedback` WHERE id_customer=".$id_customer.")
					AND koh.`id_order_state`=38	";
		
		$result = Db::getInstance()->ExecuteS($sqlQuery);
		
		if($result)
			return $result;
		else
			return 0;
	}	
}