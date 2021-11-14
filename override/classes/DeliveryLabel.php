<?php
/*
* 2007-2012 PrestaShop
*
* NOTICE OF LICENSE
*
* This source file is subject to the Open Software License (OSL 3.0)
* that is bundled with this package in the file LICENSE.txt.
* It is also available through the world-wide-web at this URL:
* http://opensource.org/licenses/osl-3.0.php
* If you did not receive a copy of the license and are unable to
* obtain it through the world-wide-web, please send an email
* to license@prestashop.com so we can send you a copy immediately.
*
* DISCLAIMER
*
* Do not edit or add to this file if you wish to upgrade PrestaShop to newer
* versions in the future. If you wish to customize PrestaShop for your
* needs please refer to http://www.prestashop.com for more information.
*
*  @author PrestaShop SA <contact@prestashop.com>
*  @copyright  2007-2012 PrestaShop SA
*  @version  Release: $Revision: 14007 $
*  @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
*  International Registered Trademark & Property of PrestaShop SA
*/
require_once('../tools/tcpdf/examples/tcpdf_include.php');

class DeliveryLabelCore extends ObjectModel
{
	public static function deliveryLabel($order, $kob_box, $other_box, $dr_number, $delivery)
	{
		$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

		// set document information
		$pdf->SetCreator(PDF_CREATOR);
		$pdf->SetAuthor('Nicola Asuni');
		$pdf->SetTitle('TCPDF Example 021');
		$pdf->SetSubject('TCPDF Tutorial');
		$pdf->SetKeywords('TCPDF, PDF, example, test, guide');

		$pdf->setPrintHeader(false);
		$pdf->setPrintFooter(false);

		// set some language-dependent strings (optional)
		if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
			require_once(dirname(__FILE__).'/lang/eng.php');
			$pdf->setLanguageArray($l);
		}

		// set font
		$pdf->SetFont('helvetica', '', 9);
		$style = array(
		    'position' => '',
		    'align' => 'C',
		    'stretch' => false,
		    'fitwidth' => true,
		    'cellfitalign' => '',
		    'border' => false,
		    'hpadding' => 'auto',
		    'vpadding' => 'auto',
		    'fgcolor' => array(0,0,0),
		    'bgcolor' => false, //array(255,255,255),
		    'text' => true,
		    'font' => 'helvetica',
		    'fontsize' => 8,
		    'stretchtext' => 4
		);
		$history = $order->getHistory($order->id_lang);
		foreach($history as $h)
			if ($h['id_order_state'] == Configuration::get('PS_OS_SHIPPING'))
				$shipping_date = $h['date_add'];

		$fc = new FulfillmentCentre((int)($order->id_fc));

		$customer = new Customer((int)($order->id_customer));

		$address = new Address((int)($order->id_address_delivery));

		$state = new State((int)($address->id_state));

// 		$company = $customer->company ? $customer->company : ($customer->firstname ? $customer->firstname : $address->firstname);
        $company = $address->company;

		$loop_value = '';
		$total_box = $kob_box + $other_box;

		if($kob_box && $kob_box != 0)
		{
			for($i = 1; $i <= $kob_box; $i++)
			{
				// add a page
				$pdf->AddPage('P','A6');
				$pdf->SetLineStyle( array('width'=>0.40,'color'=> array(0,0,0)));

				$pdf->Line(5,5, $pdf->getPageWidth()-5,5); 

				$pdf->Line($pdf->getPageWidth()-5,5, $pdf->getPageWidth()-5,  $pdf->getPageHeight()-5);
				$pdf->Line(5, $pdf->getPageHeight()-5, $pdf->getPageWidth()-5, $pdf->getPageHeight()-5);
				$pdf->Line(5,5,5, $pdf->getPageHeight()-5);

				$pdf->write1DBarcode(''.Configuration::get('PS_DELIVERY_PREFIX', 1).sprintf('%06d', $dr_number).'', 'C39', 15, '', '', 18, 0.4, $style, 'N');

				// create some HTML content
				$tbl = '
				<table cellspacing="0" cellpadding="1" border="">
				    <tr>
				        <td align="left">
				        	Ship To:<br>
				        	<b style="font-size:13pt;">'.$company.'</b><br>
				        	'.$address->address1.'<br>
				        	'.$address->city.' - '.$address->postcode.'<br>
				        	'.$state->name.'<br>
				        	'.Country::getNameById(Configuration::get('PS_LANG_DEFAULT'), (int)($address->id_country)).'<br>
				        	Mobile: '.$address->phone_mobile.'
				        </td>
				    </tr>
				</table>
				<table cellspacing="0" cellpadding="1" border="">
				    <tr>
				        <td align="center" style="font-size:40pt;color:black;font-weight:bold;">'.$i.'</td>
				    </tr>
				</table>
				<table cellspacing="0" cellpadding="1" border="">
				    <tr>
				       <td align="left">
				       	<b style="font-size:15pt;">Order: #'.$order->id.'</b><br>
				       	<b>Shipped On: '.Tools::displayDate($shipping_date, $order->id_lang).'</b><br>
				       	<b>Fulfilled At: Kobster '.$fc->city_name.' FC</b><br>
				       	<b>Box Number: '.$i.' / '.$total_box.'</b><br>
				       </td>
				    </tr>
				</table><br />
				<table cellspacing="0" cellpadding="1" border="">
				    <tr>
				        <td align="center"><img src="../img/kobster-box-label.png" width="160" align="center" height="40"></td>
				    </tr>
				</table>';
	
				$pdf->writeHTML($tbl, true, false, false, false, '');

				// $bMargin = $pdf->getBreakMargin();
				// get current auto-page-break mode
				// $auto_page_break = $pdf->getAutoPageBreak();
				// disable auto-page-break
				
				// set bacground image
				$img_file = '../img/kob-black-logo.png';
				$pdf->Image($img_file, 12, 40, 60, 55, '', '', 'C', false, 100, 'C', false, false, 0);
				// restore auto-page-break status
				// $pdf->SetAutoPageBreak($auto_page_break, $bMargin);
				// set the starting point for the page content
				// $pdf->setPageMark();
				$pdf->SetAutoPageBreak(false);
				// reset pointer to the last page
				$pdf->lastPage();
			}

			$loop_value = $i;
		}

		if($other_box && $other_box != 0)
		{
			if($loop_value == "")
				$loop_value = 1;
			for($i = $loop_value; $i < ($loop_value+$other_box); $i++)
			{
				// add a page
				$pdf->AddPage('P','A6');
				$pdf->SetLineStyle( array('width'=>0.40,'color'=> array(0,0,0)));

				$pdf->Line(5,5, $pdf->getPageWidth()-5,5); 

				$pdf->Line($pdf->getPageWidth()-5,5, $pdf->getPageWidth()-5,  $pdf->getPageHeight()-5);
				$pdf->Line(5, $pdf->getPageHeight()-5, $pdf->getPageWidth()-5, $pdf->getPageHeight()-5);
				$pdf->Line(5,5,5, $pdf->getPageHeight()-5);

				$pdf->write1DBarcode(''.Configuration::get('PS_DELIVERY_PREFIX', 1).sprintf('%06d', $dr_number).'', 'C39', 15, '', '', 18, 0.4, $style, 'N');

				// create some HTML content
				$tbl = '
				<table cellspacing="0" cellpadding="1" border="">
				    <tr>
				        <td align="left">
				        	Ship To:<br>
				        	<b style="font-size:15pt;">'.$company.'</b><br>
				        	'.$address->address1.'<br>
				        	'.$address->city.' - '.$address->postcode.'<br>
				        	'.$state->name.'<br>
				        	'.Country::getNameById(Configuration::get('PS_LANG_DEFAULT'), (int)($address->id_country)).'<br>
				        	Mobile: '.$address->phone_mobile.'
				        </td>
				    </tr>
				</table>
				<table cellspacing="0" cellpadding="1" border="">
				    <tr>
				        <td align="center" style="font-size:40pt;color:black;font-weight:bold;">'.$i.'</td>
				    </tr>
				</table>
				<table cellspacing="0" cellpadding="1" border="">
				    <tr>
				       <td align="left">
				       	<b style="font-size:15pt;">Order: #'.$order->id.'</b><br>
				       	<b>Shipped On: '.Tools::displayDate($shipping_date, $order->id_lang).'</b><br>
				       	<b>Fulfilled At: Kobster '.$fc->city_name.' FC</b><br>
				       	<b>Box Number: '.$i.' / '.$total_box.'</b><br>
				       </td>
				    </tr>
				</table>';

				$pdf->writeHTML($tbl, true, false, false, false, '');
				$pdf->Ln(1);
			}
		}

		if($kob_box == 0 && $other_box == 0){
			$pdf->AddPage('P','A6');
			$tbl = 'No data found.';
			$pdf->writeHTML($tbl, true, false, false, false, '');
		}

		$pdf->Output('LBL'.sprintf('%06d', $dr_number).'.pdf', 'D');
	}
}