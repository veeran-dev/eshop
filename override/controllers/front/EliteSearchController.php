<?php
class EliteSearchControllerCore extends FrontController {

        public function ajaxReturn(){
                $query = $_GET['query'];
                $zone = $_GET['zone'];
                $idPage = $_GET['idPage'];
                $category_filter = $_GET['category_filter'];
                $brand_filter = $_GET['brand_filter'];
                $price = $_GET['price'];
                $zone = $_GET['zone'];
                $sort = $_GET['sort'];
                $postcode = "";
                $context = Context::getContext();
                if(!$context->cookie->search_zone || (json_decode($zone)->postcode != "" && json_decode($context->cookie->search_zone)->postcode != json_decode($zone)->postcode)){
                        $context->cookie->search_zone = $zone;
                }
                if($context->cookie->search_zone){
                        $postcode = json_decode($context->cookie->search_zone)->postcode;
                }
                die(json_encode(
                        array(
                        'result' =>InstantSearch::find(1, $query, $idPage, 8,'position' ,'desc', NULL, $category_filter, $brand_filter, $price, $postcode, $sort),
                        'zone' => json_decode($context->cookie->search_zone),
                        )));
        }
}
