<?php

class CompetitorCore extends ObjectModel
{
	

	/** @var integer tin  */
	public		$id_product;

    public      $amazon;

    public      $flipkart;

    public      $snapdeal;


	public static $definition = array(
        'table' => 'competitor',
        'primary' => 'id_competitors',
        'fields' => array(
            'id_product' =>       array('type' => self::TYPE_INT),
            'amazon' =>       array('type' => self::TYPE_FLOAT),
            'flipkart' =>       array('type' => self::TYPE_FLOAT),
            'snapdeal' =>       array('type' => self::TYPE_FLOAT)
        ),
    );

    public static function getAllPrices()
    {
        return Db::getInstance()->executeS('SELECT pl.name,c.* FROM `'._DB_PREFIX_.'competitor` c left join `'._DB_PREFIX_.'product_lang` pl on pl.id_product = c.id_product WHERE pl.`id_lang` = 1');
    }

    public static function getPrices($id_product)
    {
        return Db::getInstance()->executeS('SELECT pl.name,c.* FROM `'._DB_PREFIX_.'competitor` c left join `'._DB_PREFIX_.'product_lang` pl on pl.id_product = c.id_product WHERE pl.`id_lang` = 1 and c.id_product='.$id_product.'');
    }

    public static function addPrice($id_product, $amazon, $flipkart, $snapdeal)
    {
        $result = Db::getInstance()->executeS('SELECT * from `'._DB_PREFIX_.'competitor` where id_product='.$id_product.'');

        $logger = new FileLogger();
        $logger->setFilename('test.txt');
        $logger->logError('addPrice');
        $logger->logError($result);
        $table = 'competitor';
        if($result)
        {
            $dbData = array(
                'amazon'           => $amazon,
                'flipkart'             => $flipkart,
                'snapdeal'             => $snapdeal
            );
            $where = 'id_product ='.$id_product.'';
            
            $result = Db::getInstance()->update($table, $dbData, $where);
            $logger->logError($result);
            return $result;
        }
        else
        {
            $dbData = array(
                'id_product'         => $id_product,
                'amazon'           => $amazon,
                'flipkart'             => $flipkart,
                'snapdeal'             => $snapdeal
            );
            $result = Db::getInstance()->insert($table, $dbData);
            $logger->logError($result);
            return $result;
        }
    }
    
}