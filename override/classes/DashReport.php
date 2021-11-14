<?php 
class DashReportCore extends ObjectModel
{
	public $id_address ;
	public $id_child;
	public $id_category;
	public $id_customer;

	public function __construct($id = null, $id_lang = null)
    {
    	$this->id_customer = $_POST['id_customer'];
        $this->id_address = $this->getAddress($id_customer);
        $this->id_child = $this->getChildren($id_customer);
    }

    /** AddressBiasedReports returns the data of purchase details, insoghts and analysis 
		based on the customer's available addresses **/
    public function AddressBiasedReports($date_filter, $city_filter, $address_filter){
    	// M1. Fetch Master Data with address
    	// M2. Fetch Address based monthly expenditure
    	// M3. Fetch categories revenue of customer's addresses
    	// M4. Fetch Top users within customer's available address
    	// M5. Top products of customer's available address

    	/** Filters ***/
    	// F1. City
    	// F2. Date
    	// F3. address

    	return [0 => $this->getMasterAddressBiasedReports($city_filter, $from_date, $to_date),
    			2 => $this->getABR_category($city_filter, $from_date, $to_date, $address_filter),
    			3 => $this->getABR_user($city_filter, $from_date, $to_date, $address_filter),
    			4 => $this->getABR_product($city_filter, $from_date, $to_date, $address_filter)];
    }

    public function CategoryBiasedReports(){
    	
    }

    public function UsersBiasedReports(){
    	
    }

    public function getMasterAddressBiasedReports($city, $from_date, $to_date){

        $city = $city ? 'AND ka.city LIKE "%'.$city.'%"':'';
        $date = $from_date && $to_date ? 'AND koha.date_add BETWEEN "'.$from_date.'" AND "'.$to_date.'"':'';

    	$sql = 'SELECT ka.id_address, ka.alias, ka.city, kc.id_customer, kc.firstname,kcl.name, kod.product_name,kod.product_quantity, kod.product_quantity, kod.total_price_tax_incl,koha.date_add,koha.id_order_state FROM kob_customer_address kca
				LEFT JOIN kob_address ka on ka.id_address=kca.id_address
				LEFT JOIN kob_orders ko on ko.id_address_delivery=ka.id_address
				LEFT JOIN kob_order_history koh on koh.id_order=ko.id_order
				LEFT JOIN kob_order_history koha on koha.id_order=koh.id_order
				LEFT JOIN kob_order_detail kod on kod.id_order=ko.id_order
				LEFT JOIN kob_product kp on kp.id_product=kod.product_id
				LEFT JOIN kob_category_lang kcl on kcl.id_category=kp.id_category_default AND kcl.id_lang=1
				LEFT JOIN kob_customer kc on kc.id_customer=ko.id_customer
			WHERE kca.id_customer in('.$this->id_customer.'
			AND koh.id_order_history in(SELECT max(id_order_history) FROM kob_order_history WHERE id_order=ko.id_order)
			AND koh.id_order_state NOT IN(x6,7)
			AND koha.id_order_history in(SELECT id_order_history FROM kob_order_history WHERE id_order=koh.id_order AND id_order_state=25)
            '.$city.' '.$date.'';
    }

    public function getABR_category($city_filter, $from_date, $to_date, $address_filter){
        
        $city = $city ? 'AND ka.city LIKE "%'.$city.'%"':'';
        $date = $from_date && $to_date ? 'AND koha.date_add BETWEEN "'.$from_date.'" AND "'.$to_date.'"':'';
        $address = $address_filter ? 'AND ka.id_address ='.$address_filter.'':'';

        $sql = 'SELECT kcl.name, SUM(kod.total_price_tax_incl) as share FROM kob_customer_address kca
                LEFT JOIN kob_address ka on ka.id_address=kca.id_address
                LEFT JOIN kob_orders ko on ko.id_address_delivery=ka.id_address
                LEFT JOIN kob_order_history koh on koh.id_order=ko.id_order
                LEFT JOIN kob_order_history koha on koha.id_order=koh.id_order
                LEFT JOIN kob_order_detail kod on kod.id_order=ko.id_order
                LEFT JOIN kob_product kp on kp.id_product=kod.product_id
                LEFT JOIN kob_category_lang kcl on kcl.id_category=kp.id_category_default AND kcl.id_lang=1
                LEFT JOIN kob_customer kc on kc.id_customer=ko.id_customer
            WHERE kca.id_customer in('.$this->id_customer.'
            AND koh.id_order_history in(SELECT max(id_order_history) FROM kob_order_history WHERE id_order=ko.id_order)
            AND koh.id_order_state NOT IN(x6,7)
            AND koha.id_order_history in(SELECT id_order_history FROM kob_order_history WHERE id_order=koh.id_order AND id_order_state=25)
             '.$city.' '.$date.' '.$address.'
            GROUP BY kcl.name
            ORDER BY share DESC '
    }

    public function getABR_product($city_filter, $from_date, $to_date, $address_filter){
        
        $city = $city ? 'AND ka.city LIKE "%'.$city.'%"':'';
        $date = $from_date && $to_date ? 'AND koha.date_add BETWEEN "'.$from_date.'" AND "'.$to_date.'"':'';
        $address = $address_filter ? 'AND ka.id_address ='.$address_filter.'':'';

        $sql = 'SELECT kod.product_id, kod.product_name, SUM(kod.total_price_tax_incl) as share FROM kob_customer_address kca
                LEFT JOIN kob_address ka on ka.id_address=kca.id_address
                LEFT JOIN kob_orders ko on ko.id_address_delivery=ka.id_address
                LEFT JOIN kob_order_history koh on koh.id_order=ko.id_order
                LEFT JOIN kob_order_history koha on koha.id_order=koh.id_order
                LEFT JOIN kob_order_detail kod on kod.id_order=ko.id_order
                LEFT JOIN kob_product kp on kp.id_product=kod.product_id
                LEFT JOIN kob_category_lang kcl on kcl.id_category=kp.id_category_default AND kcl.id_lang=1
                LEFT JOIN kob_customer kc on kc.id_customer=ko.id_customer
            WHERE kca.id_customer in('.$this->id_customer.'
            AND koh.id_order_history in(SELECT max(id_order_history) FROM kob_order_history WHERE id_order=ko.id_order)
            AND koh.id_order_state NOT IN(x6,7)
            AND koha.id_order_history in(SELECT id_order_history FROM kob_order_history WHERE id_order=koh.id_order AND id_order_state=25)
             '.$city.' '.$date.' '.$address.'
            GROUP BY kod.product_id
            ORDER BY share DESC '
    }
    public function getABR_user($city_filter, $from_date, $to_date, $address_filter){
        
        $city = $city ? 'AND ka.city LIKE "%'.$city.'%"':'';
        $date = $from_date && $to_date ? 'AND koha.date_add BETWEEN "'.$from_date.'" AND "'.$to_date.'"':'';
        $address = $address_filter ? 'AND ka.id_address ='.$address_filter.'':'';

        $sql = 'SELECT kc.id_customer,kc.email, SUM(kod.total_price_tax_incl) as share FROM kob_customer_address kca
                LEFT JOIN kob_address ka on ka.id_address=kca.id_address
                LEFT JOIN kob_orders ko on ko.id_address_delivery=ka.id_address
                LEFT JOIN kob_order_history koh on koh.id_order=ko.id_order
                LEFT JOIN kob_order_history koha on koha.id_order=koh.id_order
                LEFT JOIN kob_order_detail kod on kod.id_order=ko.id_order
                LEFT JOIN kob_product kp on kp.id_product=kod.product_id
                LEFT JOIN kob_category_lang kcl on kcl.id_category=kp.id_category_default AND kcl.id_lang=1
                LEFT JOIN kob_customer kc on kc.id_customer=ko.id_customer
            WHERE kca.id_customer in('.$this->id_customer.'
            AND koh.id_order_history in(SELECT max(id_order_history) FROM kob_order_history WHERE id_order=ko.id_order)
            AND koh.id_order_state NOT IN(x6,7)
            AND koha.id_order_history in(SELECT id_order_history FROM kob_order_history WHERE id_order=koh.id_order AND id_order_state=25)
             '.$city.' '.$date.' '.$address.'
            GROUP BY kc.id_customer
            ORDER BY share DESC '
    }

}
?>