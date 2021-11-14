<?php

class EliteQuoteHistory extends ObjectModel
{
    /** @var int Order id */
    public $id_quote_request;

    /** @var int Order status id */
    public $id_quote_status;

    /** @var string Object creation date */
    public $date_add;

    public static $definition = array(
        'table' => 'quote_history',
        'primary' => 'id_quote_history',
        'fields' => array(
            'id_quote_request' =>        array('type' => self::TYPE_INT, 'validate' => 'isUnsignedId', 'required' => true),
            'id_quote_status' => array('type' => self::TYPE_INT, 'validate' => 'isUnsignedId', 'required' => true),
            'date_add' =>        array('type' => self::TYPE_DATE, 'validate' => 'isDate'),
        ),
    );

    const IN_PROCESS = 1;
    const RESPONSE_RECEIVED = 2;
    const NO_RESPONSE = 3;
    const CANCELLED = 4;
    const AWAITS_SUPPLIER_ONBOARRDING = 5;
    const RATECONTRACT_ADDED = 6;
    const REJECTED_BY_SUPPLIER = 7;
    
    public function changeQuoteState($new_quote_state, $id_quote_request)
    {
        global $cookie;
        if (!$new_order_state || !$id_order) {
            return;
        }
        $context = Context::getContext();
        $this->id_quote_status = (int)$new_quote_status;
    }

    public function isQuoted($id_quote_request){
        $sql ="select * from kob_quote_history where id_quote_status = 2 AND id_quote_request=".$id_quote_request;
        $results = Db::getInstance()->getRow($sql);
        return $results == false ? false : true;
    }

    public static function expireAllQuotations(){
        $status = 3;
        $now = date("Y-m-d");
        $sql = "INSERT kob_quote_history (id_quote_request, id_quote_status)
                        select details.id_quote_request, 3 FROM `kob_quote_history` his
                            LEFT JOIN kob_elite_quote_request_details details on details.id_quote_request=his.id_quote_request 
                            LEFT JOIN kob_quote_status_lang kqsl on kqsl.id_quote_status = his.id_quote_status 
                            where his.id_quote_history IN(SELECT MAX(id_quote_history) FROM kob_quote_history kqh WHERE kqh.id_quote_request=details.id_quote_request) 
                            AND his.id_quote_status=1 
                            AND details.deadline < '".$now."'";

        $logger = new FileLogger();
        $logger->setFilename("testbo.txt");
        $logger->logError("expireAllQuotations");
        $logger->logError($sql);
        $results = Db::getInstance()->Execute($sql);
        $logger->logError($results);
        return $results;
    }
    // public function addWithemail($autodate = true, $template_vars = false, $internal_mail = false)
    // {
    //     if (!$this->add($autodate)) {
    //         return false;
    //     }

    //     if (!$this->sendEmail($this->id_quote_request, $template_vars, $internal_mail)) {
    //         return false;
    //     }

    //     return true;
    // }

    // public function sendEmail($id_quote_request, $template_vars = false, $internal_mail = false)
    // {
    //     return true;
    // }

}