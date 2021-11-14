<?php

class SearchController extends SearchControllerCore
{
     public function initContent()
    {
        $original_query = Tools::getValue('q');
        $id_customer = Tools::getValue('id_customer');
        $query = Tools::replaceAccentedChars(urldecode($original_query));

        if ($this->ajax_search) 
        {
            $searchResults = Search::customAllSearch($query, $id_customer, 0, 10, $suggestion = true);
            
            $result_not_found = array();

            if($searchResults) {
                if (is_array($searchResults)) {
                    $result = array();
                    $category_tmp = array();
                    $brand_tmp = array();
                    $pr_key = 0;
                    $b_key = 0;
                    $c_key = 0;
                    $product_suggestion = array();
                    $category_suggestion = array();
                    $brand_suggestion = array();
                    $display_each = Tools::getValue('suggest');
                    foreach ($searchResults as $key => $product) { 
                        if($pr_key < $display_each) {
                            $product_suggestion[$pr_key]['name'] = $product['pname'];
                            $product_suggestion[$pr_key]['link'] = $this->context->link->getProductLink($product['id_product']);
                            $product_suggestion[$pr_key]['id'] = $product['id_product'];
                            //$product_suggestion[$pr_key]['image_link'] = $this->context->link->getImageLink($product['link_rewrite'], $product['product_cover'], 'small');
                            //$product_suggestion[$pr_key]['query'] = $query;
                            $product_suggestion[$pr_key]['type'] = "2";//product page
                            $pr_key++;
                        }
                        if($c_key < $display_each) {
                            if(!in_array($product['id_category'], $category_tmp)) {
                                $category_tmp[] = $product['id_category'];
                                $category_suggestion[$c_key]['name'] = $product['c_name'];
                                $category_suggestion[$c_key]['link'] = $this->context->link->getCategoryLink($product['id_category']);
                                $category_suggestion[$c_key]['id'] = $product['id_category'];
                                //$category_suggestion[$c_key]['query'] = $query;
                                $category_suggestion[$c_key]['type'] = "1";//category page
                                $c_key++;
                            }
                        }
                        if($b_key < $display_each) {
                            if(!in_array($product['brand'], $brand_tmp)) {
                                $brand_tmp[] = $product['brand'];
                                $brand_suggestion[$b_key]['name'] = $product['m_name'];
                                $brand_suggestion[$b_key]['link'] = $this->context->link->getManufacturerLink($product['brand']);
                                $brand_suggestion[$b_key]['id'] = $product['brand'];
                                //$brand_suggestion[$b_key]['query'] = $query;
                                $brand_suggestion[$b_key]['type'] = "3";//brand page
                                $b_key++;
                            }
                        }
                    }

                    $result = array(
                        'Products' => $product_suggestion,
                        'Categories' => $category_suggestion,
                        'Brands' => $brand_suggestion
                    );

                   Hook::exec('actionSearch', array('expr' => $query, 'total' => count($searchResults)));
                }
            }
            else {
                $result_not_found[0]['name'] = "Please press 'Enter' for detailed Search";
                $result_not_found[0]['type'] = 0;
                $result = array(
                    'No results found. Please press "Enter" for detailed search.' => $result_not_found
                );
            }
            
            $this->ajaxDie(Tools::jsonEncode($result));
		 
        }
        else if ($this->internal_search) 
        {
            $searchResults = Search::find((int)(Tools::getValue('id_lang')), $query, 0, 20, 'position', 'desc', true, false, null, null, null);
            
            $link = new Link();

            if (is_array($searchResults) && $searchResults != "") {
                foreach ($searchResults as &$product) {
                    $productObj = new Product((int)($product['id_product']));
                    $images = $productObj->getImages(1);
                    $product['price'] = Product::getPriceStatic($productObj->id, true);
                    $product['product_link'] = $this->context->link->getProductLink($productObj->id, $productObj->link_rewrite, $product['crewrite']);
                    $product['image_link'] = $link->getImageLink($productObj->link_rewrite[1], $product['product_cover'], 'small');
                    $product['buyingPrice'] = ZonalPrice::getPricebyProductId($product['id_product']);
                }

                Hook::exec('actionSearch', array('expr' => $query, 'total' => count($searchResults)));
            }

            $this->ajaxDie(Tools::jsonEncode($searchResults));
        }
        else if($this->scn_internal_search) {
            $regions = Tools::getValue('regions');
            $link = new Link();
            $searchResults = Search::customSearchInternal(1, $query, 0, 20, 'position', 'desc', true, false, null, null, null, $regions);
            if (is_array($searchResults) && $searchResults != "") {
                foreach ($searchResults as &$product) {
                    $productObj = new Product((int)($product['id_product']));
                    $product['price'] = Product::getPriceStatic($productObj->id, true);
                    $product['product_link'] = $this->context->link->getProductLink($productObj->id, $product['link_rewrite'], $product['crewrite']);
                    $product['image_link'] = $link->getImageLink($productObj->link_rewrite[1], $product['product_cover'], 'small');
                    $product['buyingPrice'] = ZonalPrice::getPricebyProductId($product['id_product']);
                }
                Hook::exec('actionSearch', array('expr' => $query, 'total' => count($searchResults)));
            }
            $this->ajaxDie(Tools::jsonEncode($searchResults));
        }

        //Only controller content initialization when the user use the normal search
        parent::initContent();
        
        $product_per_page = isset($this->context->cookie->nb_item_per_page) ? (int)$this->context->cookie->nb_item_per_page : Configuration::get('PS_PRODUCTS_PER_PAGE');

        if ($this->instant_search && !is_array($query)) {
            $this->productSort();
            $this->n = abs((int)(Tools::getValue('n', $product_per_page)));
            $this->p = abs((int)(Tools::getValue('p', 1)));
            $search = Search::find($this->context->language->id, $query, 1,2, 'position', 'desc');
            Hook::exec('actionSearch', array('expr' => $query, 'total' => $search['total']));
            $nbProducts = $search['total'];
            $this->pagination($nbProducts);

            $this->addColorsToProductList($search['result']);

            $this->context->smarty->assign(array(
                'products' => $search['result'], // DEPRECATED (since to 1.4), not use this: conflict with block_cart module
                'search_products' => $search['result'],
                'nbProducts' => $search['total'],
                'search_query' => $original_query,
                'instant_search' => $this->instant_search,
                'homeSize' => Image::getSize(ImageType::getFormatedName('home'))));
        } elseif (($query = Tools::getValue('search_query', Tools::getValue('ref'))) && !is_array($query)) {
            
            //require_once(_PS_MODULE_DIR_.'/productcomments/ProductComment.php');
            $id_category = Tools::getValue('search_category');
            $this->productSort();
            $this->n = abs((int)(Tools::getValue('n', $product_per_page)));
            $this->p = abs((int)(Tools::getValue('p', 1)));
            $original_query = $query;
            $query = Tools::replaceAccentedChars(urldecode($query));
            $search = Search::find($this->context->language->id, $query, $this->p, $this->n, $this->orderBy, $this->orderWay,false,true,null,$id_category);
            if (is_array($search['result'])) {
                foreach ($search['result'] as &$product) {
                    $product['link'] .= (strpos($product['link'], '?') === false ? '?' : '&').'search_query='.urlencode($query).'&results='.(int)$search['total'];
                }
            }
            Hook::exec('actionSearch', array('expr' => $query, 'total' => $search['total']));
            $nbProducts = $search['total'];
            $this->pagination($nbProducts);

            $this->addColorsToProductList($search['result']);

            $this->context->smarty->assign(array(
                'products' => $search['result'], // DEPRECATED (since to 1.4), not use this: conflict with block_cart module
                'search_products' => $search['result'],
                'nbProducts' => $search['total'],
                'search_query' => $original_query,
                'homeSize' => Image::getSize(ImageType::getFormatedName('home'))));
        } elseif (($tag = urldecode(Tools::getValue('tag'))) && !is_array($tag)) {
            $nbProducts = (int)(Search::searchTag($this->context->language->id, $tag, true));
            $this->pagination($nbProducts);
            $result = Search::searchTag($this->context->language->id, $tag, false, $this->p, $this->n, $this->orderBy, $this->orderWay);
            Hook::exec('actionSearch', array('expr' => $tag, 'total' => count($result)));

            $this->addColorsToProductList($result);

            $this->context->smarty->assign(array(
                'search_tag' => $tag,
                'products' => $result, // DEPRECATED (since to 1.4), not use this: conflict with block_cart module
                'search_products' => $result,
                'nbProducts' => $nbProducts,
                'homeSize' => Image::getSize(ImageType::getFormatedName('home'))));
        } else {
            $this->context->smarty->assign(array(
                'products' => array(),
                'search_products' => array(),
                'pages_nb' => 1,
                'nbProducts' => 0));
        }
        $this->context->smarty->assign(array('add_prod_display' => Configuration::get('PS_ATTRIBUTE_CATEGORY_DISPLAY'), 'comparator_max_item' => Configuration::get('PS_COMPARATOR_MAX_ITEM')));

        $this->setTemplate(_PS_THEME_DIR_.'search.tpl');
    }
}
    ?>