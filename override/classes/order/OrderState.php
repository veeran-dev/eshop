<?php 
class OrderState extends OrderStateCore
{
	public function getStatusName($id_status,$id_lang)
	{
		return Db::getInstance()->getValue('SELECT a.`name` FROM `'._DB_PREFIX_.'order_state_lang` a WHERE a.`id_order_state` = '.$id_status.' AND a.`id_lang` = '.$id_lang.'');
	}
   public static function getSupplierOrderStates($id_lang)
    {
        $result = Db::getInstance(_PS_USE_SQL_SLAVE_)->executeS('
            SELECT *
            FROM `'._DB_PREFIX_.'order_state` os
            LEFT JOIN `'._DB_PREFIX_.'order_state_lang` osl ON (os.`id_order_state` = osl.`id_order_state` AND osl.`id_lang` = '.(int)$id_lang.')
            WHERE deleted = 0
            AND osl.id_order_state IN('.Configuration::get('ELITE_SUPPLIER_ORDER_STATUS').')
            ORDER BY `name` ASC');
            return $result;
    }
}
?>