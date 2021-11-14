<?php

class CsvImportCore extends ObjectModel
{
    public $id_csv;
    public $uploaded_by;
    public $approved_by;
    public $imported_by;
    public $validated_by;
    public $valid;
    public $file_name;    
    public $password;
    public $date_add;
    public $date_upd;

    public static $definition = array(
        'table' => 'csv',
        'primary' => 'id_csv',
        'fields' => array(
            'uploaded_by' =>            array('type' => self::TYPE_INT, 'validate' => 'isUnsignedId'),
            'approved_by' =>            array('type' => self::TYPE_INT, 'validate' => 'isUnsignedId'),
            'imported_by' =>            array('type' => self::TYPE_INT, 'validate' => 'isUnsignedId'),
            'validated_by' =>            array('type' => self::TYPE_INT, 'validate' => 'isUnsignedId'),
            'password' =>            array('type' => self::TYPE_INT, 'validate' => 'isUnsignedId'),
            'valid' =>            array('type' => self::TYPE_INT),
            'date_add' =>            array('type' => self::TYPE_DATE),
            'date_upd' =>            array('type' => self::TYPE_DATE),
            'file_name' =>    array('type' => self::TYPE_STRING, 'size' => 255),
        ),
    );

    public static function checkValidFile($file_name)
    {
        $sql=" select valid from `"._DB_PREFIX_."csv` where file_name='".$file_name."'";
        return Db::getInstance()->getRow($sql);
    }

    public static function getPin($file_name)
    {
        $sql=" select password from `"._DB_PREFIX_."csv` where file_name='".$file_name."'";
        return Db::getInstance()->getRow($sql);
    }

}

?>