<?php
/*
*
*  Supplier and Address Mapping
*
*/
class EliteSupplierAddressCore extends ObjectModel
{
    /** @var int ID supplier */
    public $id_supplier;

    /** @var int address ID */
    public $id_address;

    public static $definition = array(
        'table' => 'elite_supplier_address',
        'primary' => 'id_supplier_address',
        'multilang' => false,
        'fields' => array(
            /* EliteSupplier Address */
            'id_supplier' => array('type' => self::TYPE_INT, 'required' => true, 'validate' => 'isUnsignedId'),
            'id_address' => array('type' => self::TYPE_INT, 'required' => true, 'validate' => 'isUnsignedId'),
        )
    );

    public static function hasAddress($id_supplier){
        $findAddress = "select ka.id_address from "._DB_PREFIX_."elite_supplier_address kesa 
                            LEFT JOIN "._DB_PREFIX_."address ka on ka.id_address=kesa.id_address
                            where kesa.id_supplier=".$id_supplier;
        $result = Db::getInstance()->getRow($findAddress);
        if(!$result){
            return false;
        }
        $address = new Address($result[0]['id_address']);
        $supplier_address = AddressFormat::generateAddress($address, $patternRules, '<br />');
        return $supplier_address;
    }

    public function getAddress(){
        $this->context = Context::getContext();
        $id_supplier = $this->context->cookie->s_id;
        $findAddress = "select id_address from "._DB_PREFIX_."elite_supplier_address where id_supplier=".$id_supplier;
        $result = Db::getInstance()->getRow($findAddress);
        if(!$result){
            return false;
        }
        $address = new Address($result['id_address']);
        $supplier_address = AddressFormat::generateAddress($address, $patternRules, '<br />');
        $supplier_address = $supplier_address.'<br /> GST:'.$address->vat_number;
        return $supplier_address;   
    }

    public static function getSupplierAddress($id_supplier){
        $findAddress = "select id_address from "._DB_PREFIX_."elite_supplier_address where id_supplier=".$id_supplier;
        $result = Db::getInstance()->getRow($findAddress);
        if(!$result){
            return false;
        }
        $address = new Address($result['id_address']);
        $supplier_address = AddressFormat::generateAddress($address, $patternRules, '<br />');
        if($address->vat_number)
            $supplier_address = $supplier_address.'<br /> GST:'.$address->vat_number;
        return $supplier_address;   
    }
}