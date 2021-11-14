<?php
class StateControllerCore extends FrontController
{
	public function setStates()
	{
		$type=$_POST['type'];
		$pincode=$_POST['pincode'];
		//$context=Context::getContext();
		
		if($type==2)
		{
			try
			{
				if (!$pincode) {
					throw new Exception("Error Report: Empty variables / Undefined variables", 1);					
				}
				else
				{					
					$request = 'https://data.gov.in/api/datastore/resource.json?resource_id=6176ee09-3d56-4a3b-8115-21841576b2f6&api-key=c735600fd10bfbdec78db464f1ba8d65&filters[pincode]='.$pincode.'&fields=statename,officename,Districtname';
					$response  = file_get_contents($request);
					$jsonobj  = json_decode($response);
					//var_dump($jsonobj->records);
					if (!empty($jsonobj->records) && $jsonobj->records[0]->statename) {
						$state_id=State::getIdByName($jsonobj->records[0]->statename);

						$this->context->cookie->id_state_vat=$state_id;
						$this->context->cookie->name_state_vat=$jsonobj->records[0]->statename;
						$this->context->cookie->pincode=$pincode;

						/*$context->cookie->__set('id_state_vat',$state_id);
						$context->cookie->__set('name_state_vat',$jsonobj->records[0]->statename);
						$context->cookie->__set('pincode',$pincode);*/	
						$this->context->cookie->write();					
						echo json_encode($this->context->cookie->name_state_vat);
					}
					else{
						echo "678";
					}
				}
				
			}
			catch(Exception $e)
			{
				echo $e->getMessage();
			}
		}
	}
}