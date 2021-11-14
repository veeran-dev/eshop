	<?php
	Class MailAlerts{

		public function fetchAllPendingPayments(){

			$sql = 'SELECT kgl.id_group,kgl.`name` as company_name,kc.`id_customer` ,kc.firstname as cus_name,ko.`id_order`,kosl.name, koi.`total_paid_tax_incl` as invoice_amount,koi.number as invoice_number,ko.`credit_days`,DATEDIFF(NOW(),koi.`date_add`) AS age ,DATE_FORMAT(koi.date_add, "%d-%m-%Y") as invoice_submitted,DATE_FORMAT(koi.date_add, "%D %M %Y") as invoice_submitted_text,DATE_FORMAT(DATE_ADD(koi.date_add,INTERVAL ko.credit_days Day), "%D %M %Y") AS due_date_text,DATE_FORMAT(DATE_ADD(koi.date_add,INTERVAL ko.credit_days Day), "%d-%m-%Y") AS due_date,kc.email as cus_email, ke_rm.email as rm_email,ke_rm.firstname as rm_name, ke_rm.phone as rm_phone,ke_kam.email as kam_email,kc2.email as first_approver_email,kc3.email as second_approver_email,kcs.email as esc_email,kcs.firstname as esc_name
						FROM kob_orders ko
						LEFT JOIN kob_order_invoice koi on koi.id_order = ko.id_order
						left join kob_order_history koha on koha.id_order = ko.id_order
						left join kob_order_history kohb on kohb.id_order = koha.id_order
					    LEFT JOIN kob_order_state_lang kosl on kosl.id_order_state=kohb.id_order_state and kosl.id_lang=1
						LEFT JOIN kob_customer kc on kc.id_customer = ko.id_customer
						LEFT JOIN kob_group_lang kgl ON kgl.id_group = kc.id_default_group
					    LEFT JOIN kob_group kg on kg.id_group=kgl.id_group
					    LEFT JOIN kob_customer_escalation kcs on kcs.id_group=kgl.id_group
					    LEFT JOIN kob_employee ke_rm on ke_rm.id_employee=kg.id_relationship_manager
					    LEFT JOIN kob_employee ke_kam on ke_kam.id_employee=kg.id_kam
						LEFT JOIN kob_customer kc2 on kc2.id_customer = (SELECT MIN(id_parent) from kob_customer_parent where id_customer=ko.id_customer)
						LEFT JOIN kob_customer kc3 on kc3.id_customer = (SELECT MAX(id_parent) from kob_customer_parent where id_customer=ko.id_customer)

						WHERE koha.id_order in(select id_order from kob_order_history oh where oh.id_order=ko.id_order and oh.id_order_state=40)
						AND kohb.id_order_history in( select max(id_order_history) from kob_order_history ohb where ohb.id_order=koha.id_order)
						AND kohb.id_order_state NOT IN(6,7,38,36)
						AND kgl.id_lang=1
						AND ko.date_add >= "2017-07-01 00:00:00"
						AND kgl.id_group NOT IN(1,0)
						AND koi.deny_alerts = 0
					    AND ko.invoice_number!=0
						GROUP BY ko.id_order
						ORDER BY kgl.id_group,kc.id_customer ';

			$result = Db::getInstance()->ExecuteS($sql);
			return $result;
		}

	public function classifyEmails($data){
		$esc_data = "";
		$cus_data = "";
		$esc_billed_date = "";
		$esc_due_date = "";
		$user_billed_date = "";
		$user_due_date = "";
		$esc_total_invoice_amount = 0;
		$user_total_invoice_amount = 0;
		$user_pending_invoice_amount = 0;
		$esc_pending_invoice_amount = 0;
		$k = 0;
		$l = 0;
		$mail_type = 8;
		$esc_mail_type = 8;
		$to = array();
		$cc = array();
		$to_esc = array();
		$cc_esc = array();
		$condition_esc_1 = "";
		$condition_esc_2 = "";
		$condition_user_1 = "";
		$condition_user_2 = "";

		for($i=0; $i<=sizeof($data);$i++){
			if($data[$i]['credit_days']-$data[$i]['age'] <= 7){
				$l++;
				$k++;
				$m_type = $data[$i]['credit_days']-$data[$i]['age'];
				$esc_data .= ""."<tr style='background-color:".$m_type."'><td style='text-align:center;vertical-align:top;padding:.6em;'>".$k."</td><td style='text-align:left;vertical-align:top;padding:.6em;'> #IN00".$data[$i]['invoice_number']."<br/><span style='color:#777;'>billed on </span>".$data[$i]['invoice_submitted']."</td><td style='text-align:center;vertical-align:top;padding:.6em;'>Unpaid</td><td style='text-align:center;vertical-align:top;padding:.6em;'>".$data[$i]['due_date']."</td><td style='text-align:right;vertical-align:top;padding:.6em;'>₹ ".round($data[$i]['invoice_amount'],2)."</td></tr>";

				$cus_data .= ""."<tr style='background-color:".$m_type."'><td style='text-align:center;vertical-align:top;padding:.6em;'>".$l."</td><td style='text-align:left;vertical-align:top;padding:.6em;'> #IN00".$data[$i]['invoice_number']."<br/><span style='color:#777;'>billed on </span>".$data[$i]['invoice_submitted']."</td><td style='text-align:center;vertical-align:top;padding:.6em;'>Unpaid</td><td style='text-align:center;vertical-align:top;padding:.6em;'>".$data[$i]['due_date']."</td><td style='text-align:right;vertical-align:top;padding:.6em;'>₹ ".round($data[$i]['invoice_amount'],2)."</td></tr>";


				if($data[$i]['credit_days']-$data[$i]['age'] == 7 || $data[$i]['credit_days']-$data[$i]['age'] == 2 || $data[$i]['credit_days']-$data[$i]['age'] == 0 || $data[$i]['credit_days']-$data[$i]['age'] == -1 || $data[$i]['credit_days']-$data[$i]['age'] == -3 || $data[$i]['credit_days']-$data[$i]['age'] == -6 || $data[$i]['credit_days']-$data[$i]['age'] == -9 || $data[$i]['credit_days']-$data[$i]['age'] == -12 || $data[$i]['credit_days']-$data[$i]['age'] == -15){


					$user_total_invoice_amount = $user_total_invoice_amount + $data[$i]['invoice_amount'];
					$esc_total_invoice_amount = $esc_total_invoice_amount + $data[$i]['invoice_amount'];

					if($data[$i]['credit_days']-$data[$i]['age'] == $mail_type){
						$user_pending_invoice_amount = $user_pending_invoice_amount + $data[$i]['invoice_amount'];
						$esc_pending_invoice_amount = $esc_pending_invoice_amount + $data[$i]['invoice_amount'];
					}
					else if($data[$i]['credit_days']-$data[$i]['age'] < $mail_type){
						$user_pending_invoice_amount = 0;
						$esc_pending_invoice_amount = 0;

						$user_pending_invoice_amount = $user_pending_invoice_amount + $data[$i]['invoice_amount'];
						$esc_pending_invoice_amount = $esc_pending_invoice_amount + $data[$i]['invoice_amount'];
						$condition_esc_1 = "have also informed the same to ".$data[$i]['cus_name']." and";
						$condition_esc_2 = "".$data[$i]['cus_name']." and";
					}

					if($data[$i]['credit_days']-$data[$i]['age'] <= $mail_type){
						$user_billed_date = $data[$i]['invoice_submitted_text'];
						$user_due_date = $data[$i]['due_date_text'];
						$esc_billed_date = $data[$i]['invoice_submitted_text'];
						$esc_due_date = $data[$i]['due_date_text'];
						$mail_type = $data[$i]['credit_days']-$data[$i]['age'];
						$esc_mail_type = $data[$i]['credit_days']-$data[$i]['age'];
					}
				}

				if(($data[$i]['id_group'] != $data[$i+1]['id_group'] && $data[$i]['esc_email'] != "") && ($esc_mail_type == -1 || $esc_mail_type == -3 || $esc_mail_type == -6 || $esc_mail_type == -9 || $esc_mail_type == -12 || $esc_mail_type == -15)){

					array_push($to_esc, $data[$i]['esc_email']);

					if($data[$i]['rm_email'] != "")
						array_push($cc_esc, $data[$i]['rm_email']);

					if($data[$i]['kam_email'] != "")
						array_push($cc_esc, $data[$i]['kam_email']);
					
					if($esc_mail_type < -1){
						$rmHead = Employee::getRmHead();
						foreach($rmHead as $head){
							array_push($cc_esc, $head);
						}

						$salesHead = Employee::getSalesHead();
						foreach($salesHead as $head){
							array_push($cc_esc, $head);	
						}
					}
					$str_to_replace = "background-color:".$esc_mail_type."";
					$new_esc_data = str_replace($str_to_replace,"background-color:#f78b95;color:white;",$esc_data);

					$grp_mail_data = array(
						'{firstname}' => $data[$i]['esc_name'],
						'{company_name}' => $data[$i]['company_name'],
						'{data}' => $new_esc_data,
						'{billed_date}' => $esc_billed_date,
						'{due_date}' => $esc_due_date,
						'{pending_invoice_amount}' => $esc_pending_invoice_amount,
						'{total_invoice_amount}' => $esc_total_invoice_amount,
						'{rm_email}' => $data[$i]['rm_email'],
						'{rm_phone}' => $data[$i]['rm_phone'],
						'{rm_name}' => $data[$i]['rm_name'],
						'{follow_up_user}' => $data[$i]['cus_name'],
						'{user}' => $data[$i]['esc_name'],
						'{follow_up_condition_1}' => $condition_esc_1,
						'{follow_up_condition_2}' => $condition_esc_2,
						);

					$sub = $data[$i]['id_customer']."-".$data[$i]['id_group']."-".date('md');
					$this->sendMail($grp_mail_data, $esc_mail_type, $to_esc, $to_name, $cc_esc, $esc_billed_date,1 ,$sub); // Sends email escalation wise
					$k = 0;
					$new_esc_data = "";
					$esc_mail_type = 8;
					$esc_data = "";
					$esc_billed_date = "";
					$esc_due_date = "";
					$esc_pending_invoice_amount = 0;
					$esc_total_invoice_amount = 0;
					$cc_esc = array();
					$to_esc = array();
					$condition_esc_1 = "";
					$condition_esc_2 = "";
				}

				if(($data[$i]['id_customer'] != $data[$i+1]['id_customer'] && $data[$i]['cus_email'] != "") && ($mail_type == 7 || $mail_type == 2 || $mail_type == 0 || $mail_type == -1 || $mail_type == -3 || $mail_type == -6 || $mail_type == -9 || $mail_type == -12 || $mail_type == -15)){

					array_push($to, $data[$i]['cus_email']);

					if($data[$i]['rm_email'] != "")
						array_push($cc, $data[$i]['rm_email']);

					if($data[$i]['kam_email'] != "")
						array_push($cc, $data[$i]['kam_email']);

					if($data[$i]['first_approver_email'] != $data[$i]['esc_email'] && $mail_type < 0 && $data[$i]['first_approver_email'] !="")
						array_push($cc, $data[$i]['first_approver_email']);

					if($data[$i]['second_approver_email'] != $data[$i]['esc_email'] && $mail_type < 0 && $data[$i]['second_approver_email'] != "")
						array_push($cc, $data[$i]['second_approver_email']);

					if($data[$i]['esc_name'] != ""){
						$condition_user_1 = "have also informed the same to ".$data[$i]['esc_name']." and";
						$condition_user_2 = "".$data[$i]['esc_name']." and";
					}
					else{
						$condition_user_1 = "";
						$condition_user_2 = "";
					}

					if($mail_type < -1){
						$rmHead = Employee::getRmHead();
						foreach($rmHead as $head){
							array_push($cc, $head);
						}

						$salesHead = Employee::getSalesHead();
						foreach($salesHead as $head){
							array_push($cc, $head);	
						}
					}

					$str_to_replace = "background-color:".$mail_type."";
					$new_user_data = str_replace($str_to_replace,"background-color:#f78b95;color:white;",$cus_data);

					$cus_mail_data = array(
						'{firstname}' => $data[$i]['cus_name'],
						'{company_name}' => $data[$i]['company_name'],
						'{data}' => $new_user_data,
						'{billed_date}' => $user_billed_date,
						'{due_date}' => $user_due_date,
						'{pending_invoice_amount}' => $user_pending_invoice_amount,
						'{total_invoice_amount}' => $user_total_invoice_amount,
						'{rm_email}' => $data[$i]['rm_email'],
						'{rm_phone}' => $data[$i]['rm_phone'],
						'{rm_name}' => $data[$i]['rm_name'],
						'{follow_up_user}' => $data[$i]['esc_name'],
						'{user}' => $data[$i]['cus_name'],
						'{follow_up_condition_1}' => $condition_user_1,
						'{follow_up_condition_2}' => $condition_user_2,
						);
					$sub = $data[$i]['id_customer']."-".$data[$i]['id_group']."-".date('md');
					$this->sendMail($cus_mail_data, $mail_type, $to, $to_name, $cc, $user_billed_date, 0, $sub); // Sends email escalation wise

					$mail_type = 8;
					$l = 0;
					$cus_data = "";
					$new_user_data = "";
					$user_billed_date = "";
					$user_due_date = "";
					$user_pending_invoice_amount = 0;
					$user_total_invoice_amount = 0;
					$cc = array();
					$to = array();
					$condition_user_1 = "";
					$condition_user_2 = "";
				}
				if($data[$i]['id_group'] != $data[$i+1]['id_group']){
					$k = 0;
					$new_esc_data = "";
					$esc_mail_type = 8;
					$esc_data = "";
					$esc_billed_date = "";
					$esc_due_date = "";
					$esc_pending_invoice_amount = 0;
					$esc_total_invoice_amount = 0;
					$cc_esc = array();
					$to_esc = array();
					$condition_esc_1 = "";
					$condition_esc_2 = "";
				}
				if($data[$i]['id_customer'] != $data[$i+1]['id_customer']){
					$mail_type = 8;
					$l = 0;
					$cus_data = "";
					$new_user_data = "";
					$user_billed_date = "";
					$user_due_date = "";
					$user_pending_invoice_amount = 0;
					$user_total_invoice_amount = 0;
					$cc = array();
					$to = array();
					$condition_user_1 = "";
					$condition_user_2 = "";
				}
			}
			else{
			    if(($data[$i]['id_group'] != $data[$i+1]['id_group'] && $data[$i]['esc_email'] != "") && ($esc_mail_type == -1 || $esc_mail_type == -3 || $esc_mail_type == -6 || $esc_mail_type == -9 || $esc_mail_type == -12 || $esc_mail_type == -15)){

					array_push($to_esc, $data[$i]['esc_email']);

					if($data[$i]['rm_email'] != "")
						array_push($cc_esc, $data[$i]['rm_email']);

					if($data[$i]['kam_email'] != "")
						array_push($cc_esc, $data[$i]['kam_email']);

					if($esc_mail_type < -1){
						$rmHead = Employee::getRmHead();
						foreach($rmHead as $head){
							array_push($cc_esc, $head);
						}

						$salesHead = Employee::getSalesHead();
						foreach($salesHead as $head){
							array_push($cc_esc, $head);	
						}
					}

					$str_to_replace = "background-color:".$esc_mail_type."";
					$new_esc_data = str_replace($str_to_replace,"background-color:#f78b95;color:white;",$esc_data);

					$grp_mail_data = array(
						'{firstname}' => $data[$i]['esc_name'],
						'{company_name}' => $data[$i]['company_name'],
						'{data}' => $new_esc_data,
						'{billed_date}' => $esc_billed_date,
						'{due_date}' => $esc_due_date,
						'{pending_invoice_amount}' => $esc_pending_invoice_amount,
						'{total_invoice_amount}' => $esc_total_invoice_amount,
						'{rm_email}' => $data[$i]['rm_email'],
						'{rm_phone}' => $data[$i]['rm_phone'],
						'{rm_name}' => $data[$i]['rm_name'],
						'{follow_up_user}' => $data[$i]['cus_name'],
						'{user}' => $data[$i]['esc_name'],
						'{follow_up_condition_1}' => $condition_esc_1,
						'{follow_up_condition_2}' => $condition_esc_2,
						);

					$sub = $data[$i]['id_customer']."-".$data[$i]['id_group']."-".date('md');
					$this->sendMail($grp_mail_data, $esc_mail_type, $to_esc, $to_name, $cc_esc, $esc_billed_date,1 ,$sub); // Sends email escalation wise
					$k = 0;
					$new_esc_data = "";
					$esc_mail_type = 8;
					$esc_data = "";
					$esc_billed_date = "";
					$esc_due_date = "";
					$esc_pending_invoice_amount = 0;
					$esc_total_invoice_amount = 0;
					$cc_esc = array();
					$to_esc = array();
					$condition_esc_1 = "";
					$condition_esc_2 = "";
				}

				if(($data[$i]['id_customer'] != $data[$i+1]['id_customer'] && $data[$i]['cus_email'] != "") && ($mail_type == 7 || $mail_type == 2 || $mail_type == 0 || $mail_type == -1 || $mail_type == -3 || $mail_type == -6 || $mail_type == -9 || $mail_type == -12 || $mail_type == -15)){

					array_push($to, $data[$i]['cus_email']);

					if($data[$i]['rm_email'] != "")
						array_push($cc, $data[$i]['rm_email']);

					if($data[$i]['kam_email'] != "")
						array_push($cc, $data[$i]['kam_email']);

					if($data[$i]['first_approver_email'] != $data[$i]['esc_email'] && $mail_type < 0 && $data[$i]['first_approver_email'] !="")
						array_push($cc, $data[$i]['first_approver_email']);

					if($data[$i]['second_approver_email'] != $data[$i]['esc_email'] && $mail_type < 0 && $data[$i]['second_approver_email'] != "")
						array_push($cc, $data[$i]['second_approver_email']);

					if($data[$i]['esc_name'] != ""){
						$condition_user_1 = "have also informed the same to ".$data[$i]['esc_name']." and";
						$condition_user_2 = "".$data[$i]['esc_name']." and";
					}
					else{
						$condition_user_1 = "";
						$condition_user_2 = "";
					}

					if($mail_type < -1){
						$rmHead = Employee::getRmHead();
						foreach($rmHead as $head){
							array_push($cc, $head);
						}

						$salesHead = Employee::getSalesHead();
						foreach($salesHead as $head){
							array_push($cc, $head);	
						}
					}
					$str_to_replace = "background-color:".$mail_type."";
					$new_user_data = str_replace($str_to_replace,"background-color:#f78b95;color:white;",$cus_data);

					$cus_mail_data = array(
						'{firstname}' => $data[$i]['cus_name'],
						'{company_name}' => $data[$i]['company_name'],
						'{data}' => $new_user_data,
						'{billed_date}' => $user_billed_date,
						'{due_date}' => $user_due_date,
						'{pending_invoice_amount}' => $user_pending_invoice_amount,
						'{total_invoice_amount}' => $user_total_invoice_amount,
						'{rm_email}' => $data[$i]['rm_email'],
						'{rm_phone}' => $data[$i]['rm_phone'],
						'{rm_name}' => $data[$i]['rm_name'],
						'{follow_up_user}' => $data[$i]['esc_name'],
						'{user}' => $data[$i]['cus_name'],
						'{follow_up_condition_1}' => $condition_user_1,
						'{follow_up_condition_2}' => $condition_user_2,
						);
					$sub = $data[$i]['id_customer']."-".$data[$i]['id_group']."-".date('md');
					$this->sendMail($cus_mail_data, $mail_type, $to, $to_name, $cc, $user_billed_date, 0, $sub); // Sends email escalation wise

					$mail_type = 8;
					$l = 0;
					$cus_data = "";
					$new_user_data = "";
					$user_billed_date = "";
					$user_due_date = "";
					$user_pending_invoice_amount = 0;
					$user_total_invoice_amount = 0;
					$cc = array();
					$to = array();
					$condition_user_1 = "";
					$condition_user_2 = "";
				}
				if($data[$i]['id_group'] != $data[$i+1]['id_group']){
					$k = 0;
					$new_esc_data = "";
					$esc_mail_type = 8;
					$esc_data = "";
					$esc_billed_date = "";
					$esc_due_date = "";
					$esc_pending_invoice_amount = 0;
					$esc_total_invoice_amount = 0;
					$cc_esc = array();
					$to_esc = array();
					$condition_esc_1 = "";
					$condition_esc_2 = "";
				}
				if($data[$i]['id_customer'] != $data[$i+1]['id_customer']){
					$mail_type = 8;
					$l = 0;
					$cus_data = "";
					$new_user_data = "";
					$user_billed_date = "";
					$user_due_date = "";
					$user_pending_invoice_amount = 0;
					$user_total_invoice_amount = 0;
					$cc = array();
					$to = array();
					$condition_user_1 = "";
					$condition_user_2 = "";
				}
			}
		}
	}

		public function sendMail($data, $mail_type, $to, $to_name, $cc, $billed_date, $esc, $sub){
		    
		    $logger = new FileLogger();
		    $logger->setFilename('check.txt');
		    $logger->logError('SEND MAILS');
		    $logger->logError($to);
		    $logger->logError($cc);
		    $logger->logError($esc);
		    $logger->logError($data);
		    $logger->logError($mail_type);
		        
			if($mail_type == 7){
				$template ="aps_reminder_1";
				$subject = "There are still 7 days to pay your invoices billed on ".$billed_date." | Kobster.com"." [".$sub."]";
			}
			else if($mail_type == 2){
				$template ="aps_reminder_2";
				$subject = "Two days left to pay your invoices billed on ".$billed_date." | Kobster.com"." [".$sub."]";
			}
			else if($mail_type == 0){
				$template ="aps_reminder_3";
				$subject = "Last day to pay your invoices billed on ".$billed_date." | Kobster.com"." [".$sub."]";
			}
			else if($mail_type == -1){
				$template ="aps_warning";
				$subject = "Payment pending for invoices billed on ".$billed_date." | Kobster.com"." [".$sub."]";
			}
			else if($mail_type == -3 && $esc == 1){
				$template ="aps_escalation_1";
				$subject = "First Invoice Overdue Notice | Kobster.com"." [".$sub."]";
			}
			else if($mail_type == -6 && $esc == 1){
				$template ="aps_escalation_2";
				$subject = "Second Invoice Overdue Notice | Kobster.com"." [".$sub."]";
			}
			else if($mail_type == -9 && $esc == 1){
				$template ="aps_escalation_3";
				$subject = "Third Invoice Overdue Notice | Kobster.com"." [".$sub."]";
			}
			else if($mail_type == -12 && $esc == 1){
				$template ="aps_final_reminder";
				$subject = "Final Invoice Overdue Notice | Kobster.com"." [".$sub."]";
			}
			else if($mail_type == -15 && $esc == 1){
				$template ="aps_block_account";
				$subject = "Invoice(s) are long overdue | Kobster.com"." [".$sub."]";
			}
			else if($mail_type == -3){
				$template ="aps_escalation_1_user";
				$subject = "First Invoice Overdue Notice | Kobster.com"." [".$sub."]";
			}
			else if($mail_type == -6){
				$template ="aps_escalation_2_user";
				$subject = "Second Invoice Overdue Notice | Kobster.com"." [".$sub."]";
			}
			else if($mail_type == -9){
				$template ="aps_escalation_3_user";
				$subject = "Third Invoice Overdue Notice | Kobster.com"." [".$sub."]";
			}
			else if($mail_type == -12){
				$template ="aps_final_reminder_user";
				$subject = "Final Invoice Overdue Notice | Kobster.com"." [".$sub."]";
			}
			else if($mail_type == -15){
				$template ="aps_block_account_user";
				$subject = "Invoice(s) are long overdue | Kobster.com"." [".$sub."]";
			}

			Mail::Send(1, $template, $subject, $data, $to, $to_name,"noreply@kobster.com","Kobster Payment Alerts", null, null, _PS_MAIL_DIR_, false, null, null, null, $cc);
		}
	}


?>
