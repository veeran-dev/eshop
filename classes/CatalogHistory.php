<?php

class CatalogHistoryCore extends ObjectModel
{
    public      $id_product;

    public      $type;

    public      $from;

    public      $to;

    public      $id_employee;

    public      $read;

    public static $definition = array(
        'table' => 'catalog_history',
        'primary' => 'id_catalog_change',
        'fields' => array(
            'id_product' => array('type' => self::TYPE_INT, 'validate' => 'isUnsignedId', 'required' => true),
            'id_employee' =>    array('type' => self::TYPE_INT, 'validate' => 'isUnsignedId', 'required' => true),
            'type' =>        array('type' => self::TYPE_STRING, 'validate' => 'isGenericName', 'required' => true, 'size' => 32),
            'from' =>        array('type' => self::TYPE_DATE,'required' => true),
            'to' =>        array('type' => self::TYPE_DATE, 'required' => true),
            'read' =>        array('type' => self::TYPE_INT),
        ),
    );  

    public function taggedCustomersProduct($id_employee)
    {
        $query ="select kch.id_catalog_change, ksp.id_group,kpl.id_product,kp.reference,kp.`price` AS product_price,kpl.name,kp.reference, kp.id_product, kch.type, kch.id_zone, kfc.city_name, kch.from, kch.to, DATE_FORMAT(ksp.`to`,'%m-%d-%Y') as expires, ksp.price as sp, kch.date_added as date_added, DATE_FORMAT(kch.date_added,'%Y%m%d') as sort_date,(case  when kchs.status=1 then 1 else 0 END)AS status FROM "._DB_PREFIX_."group kg
                LEFT JOIN "._DB_PREFIX_."group_lang kgl on kgl.id_group=kg.id_group and kgl.id_lang=1
                LEFT JOIN "._DB_PREFIX_."specific_price ksp on ksp.id_group = kg.id_group
                LEFT JOIN "._DB_PREFIX_."product kp on kp.id_product=ksp.id_product
                LEFT JOIN "._DB_PREFIX_."product_lang kpl on kpl.id_product = kp.id_product and kpl.id_lang=1
                LEFT JOIN "._DB_PREFIX_."catalog_history kch on kch.id_product=ksp.id_product
                LEFT JOIN "._DB_PREFIX_."catalog_history_status kchs on kchs.id_catalog_change = kch.id_catalog_change and kchs.id_group=kg.id_group
                LEFT JOIN "._DB_PREFIX_."fulfillment_centre kfc on kfc.id_fulfillment_centre=kch.id_zone
                WHERE kg.id_relationship_manager = ".$id_employee." 
                AND ksp.id_specific_price IN(SELECT MAX(kspa.id_specific_price) FROM "._DB_PREFIX_."specific_price AS kspa WHERE kspa.id_product=ksp.id_product and kspa.id_group=kg.id_group)
                AND kch.id_catalog_change != 'NULL'
                order by ksp.id_group, kch.date_added, ksp.id_product";
                                //var_dump($query);
        $result = Db::getInstance()->executeS($query);
        //var_dump($result);

        $product_details_others = array();
        $product_details_price = array();
        $fulfillment_centre = new FulfillmentCentre();
        foreach ($result as &$data) {

            //date to string for notification date sort

            if($data['type'] == 1){
                $data['notification'] = "MOQ changed from ".$data['from']." to ".$data['to'];
                array_push($product_details_others, $data);
            }
            if($data['type'] == 2){
                $data['notification'] = "Name changed from ".$data['from']." to ".$data['to'];
                array_push($product_details_others, $data);
            }
            if($data['type'] == 5){
                $data['notification'] = "Product is Out of stock";
                array_push($product_details_others, $data);
            }
            if($data['type'] == 6){
                $data['notification'] = "product Discontinued";
                array_push($product_details_others, $data);
            }
            if($data['type'] == 7){
                $data['notification'] = "GST changed from ".$data['from']." to ".$data['to'];
                array_push($product_details_others, $data);
            }

            if($data['type'] == 8) {
                $data['notification'] = "Rate contract price expired. Expiry date changed from ".$data['from']." to ".$data['to'];
                array_push($product_details_others, $data);
            }

            if($data['type'] == 9) {
                $data['notification'] = "Rate contract extended from ".$data['from']." to ".$data['to'];
                array_push($product_details_others, $data);
            }

            if($data['type'] == 10) {
                $data['notification'] = "Product disabled";
                array_push($product_details_others, $data);
            }

            if($data['type'] == 3 || $data['type'] == 4){
                
                $notification = "";
                if($data['type'] == 3){
                    if(!ZonalPrice::getPricebyProductId($data['id_product'])){
                        $notification = "Buying price updated for all region from ".$data['from']." to ".$data['to'];
                    }
                }
                if($data['type'] == 4){
                    $check_address = $fulfillment_centre->getFcForGroup($data['id_group'], $data['id_zone']);
                    if($check_address[0]['city_name'])
                    {
                        $notification = "Buying price updated for ".$check_address[0]['city_name']." zone from ".$data['from']." to ".$data['to']."";
                    }
                }

                $data['notification'] = $notification;
                array_push($product_details_price, $data);
            }
        }
        //var_dump($product_details_price);
        $result = array();
        array_push($result, $product_details_others, $product_details_price);
        return $result;
    }

    public function affectedCustomers($id_employee){
        $query = "select (sum(case when kch.`id_product` then 1 else 0 end)-sum(case when kchs.`status`=1 then 1 else 0 end))as read_count, 
                        kgl.id_group,kgl.name from "._DB_PREFIX_."catalog_history kch 
                        left join "._DB_PREFIX_."specific_price ksp on ksp.id_product = kch.id_product 
                        LEFT JOIN "._DB_PREFIX_."group kg on kg.id_group = ksp.id_group
                        left join "._DB_PREFIX_."group_lang kgl ON (kgl.id_lang=1 and kgl.id_group = kg.id_group) 
                        left join "._DB_PREFIX_."catalog_history_status kchs on (kchs.id_catalog_change = kch.id_catalog_change and kchs.id_group = ksp.id_group) 
                        where ksp.id_specific_price in(select max(id_specific_price) from "._DB_PREFIX_."specific_price ksp1 where ksp1.id_product = kch.id_product and ksp1.id_group=kgl.id_group AND kg.id_relationship_manager=".$id_employee.") 
                        GROUP by ksp.id_group";

        return Db::getInstance()->executeS($query);
    }

    public static function addHistory($type, $product, $changed_data, $id_zone = null)
    {   
        if($type == "minimal_quantity"){
            $type = '1';
        }
        else if($type == "name"){
            $type = '2';
        }
        else if($type == "wholesale_price"){
            $type = '3';
        }
        else if($type == "zonal_price"){
            $type = '4';
        }
        else if($type == "Out of stock"){
            $type = '5';
        }
        else if($type == "Discontinued"){
            $type = '6';
        }
        else if($type == "Tax group"){
            $type = '7';
        }
        else if($type == "rcp_expired") { // Rate contract price exceeds product price
            $type = '8';
        }
        else if($type == "rcp_extended") {
            $type = '9';
        }
        else if($type == "status") {
            $type = '10';
        }

        $context = Context::getContext();
        $employee = new Employee($context->cookie->id_employee);
        $table = "catalog_history";

        if(is_array($product) && is_array($changed_data))
        {
            for($i=0; $i<sizeof($product); $i++)
            {

                $dbData = array(
                    'id_product'         => $product[$i],
                    'type'           => $type,
                    'id_zone'       => $id_zone,
                    'from'             => $changed_data[$i]['from'],
                    'to'             => $changed_data[$i]['to'],
                    'id_employee'   => isset($changed_data[0]['id_employee']) ? $changed_data[0]['id_employee'] : $context->cookie->id_employee,
                    );
                
                $result = Db::getInstance()->insert($table, $dbData);
            }
        }
        else{
            $dbData = array(
                'id_product'         => $product,
                'type'           => $type,
                'id_zone'       => $id_zone,
                'from'             => $changed_data[0]['from'],
                'to'             => $changed_data[0]['to'],
                'id_employee'   => isset($changed_data[0]['id_employee']) ? $changed_data[0]['id_employee'] : $context->cookie->id_employee,
            );

            $result = Db::getInstance()->insert($table, $dbData);
        }
    }

    public static function read($id, $id_group)
    {
        $status = 0;
        $success = 1;
        if(is_array($id)){
            //var_dump($id);
            foreach($id as $id_catalog_change){
                $query = "select kchs.* from "._DB_PREFIX_."catalog_history_status kchs
                                            left join "._DB_PREFIX_."catalog_history kch on kchs.id_catalog_change = kch.id_catalog_change
                                            where kch.id_catalog_change=".$id_catalog_change." and kchs.id_group =".$id_group."";
                $result = Db::getInstance()->executeS($query);                
                if(empty($result)){
                    $status = 0;
                        $query1 = "insert into "._DB_PREFIX_."catalog_history_status (id_group, id_catalog_change, status) values(".$id_group.",".$id_catalog_change.", 1)";
                }
                else{
                    if($result[0]['status'] == 0){
                        $status = 1;
                    }
                    else{
                        $status =0;
                    }
                    $query1 = "update "._DB_PREFIX_."catalog_history_status kchs  
                                        left join "._DB_PREFIX_."catalog_history kch on kch.id_catalog_change = kchs.id_catalog_change
                                        set kchs.status=".$status."
                                        where kchs.id_group=".$id_group." 
                                        and kch.id_catalog_change = ".$id_catalog_change."";
                }
                
                $result = Db::getInstance()->execute($query1);                
                if(empty($result))
                    $success = 0;
            }
        }
        else{
                $query = "select kchs.* from "._DB_PREFIX_."catalog_history_status kchs
                                            left join "._DB_PREFIX_."catalog_history kch on kchs.id_catalog_change = kch.id_catalog_change
                                            where kch.id_catalog_change=".$id." and kchs.id_group =".$id_group."";
                $result = Db::getInstance()->executeS($query);                

                if(empty($result)){
                    $query1 = "insert into "._DB_PREFIX_."catalog_history_status (id_group, id_catalog_change, status) values(".$id_group.",".$id.", 1)";
                }
                else{
                    if($result[0]['status'] == 0){
                        $status = 1;
                    }
                    else{
                        $status =0;
                    }
                    $query1 = "update "._DB_PREFIX_."catalog_history_status kchs  
                                    left join "._DB_PREFIX_."catalog_history kch on kch.id_catalog_change = kchs.id_catalog_change
                                    set kchs.status=".$status."
                                    where kchs.id_group=".$id_group." 
                                    and kch.id_catalog_change = ".$id."";
                }
                $result = Db::getInstance()->execute($query1);
        }
        if(!$result)
            echo 0;
        else
            echo 1;
    }
}