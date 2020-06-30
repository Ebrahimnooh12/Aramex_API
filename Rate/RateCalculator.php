<?php	



extract($_POST);

function createRateRequestParam($data){
	return array(
		//Use Aramex Account Username and Password 
		'ClientInfo'  			=> array(
									'UserName'			 	=> 'Your Email',
									'Password'			 	=> 'Your Password',
									'Version'			 	=> 'v1.0'
								),
								
		'Transaction' 			=> array(
									'Reference1'			=> '001' 
								),
								
		'OriginAddress' 	 	=> array(
									'City'					=> $data['from_city'],
									'CountryCode'			=> $data ['from_country'] 
								),
								
		'DestinationAddress' 	=> array(
									'City'					=> $data['to_city'],
									'CountryCode'			=> $data['to_country']
								),
		'ShipmentDetails'		=> array(
									'PaymentType'			 => 'P',
									//EXP = Express , DOM = Domestic 
									'ProductGroup'			 => $data['product_group'],
									//OND for Domestic 
									'ProductType'			 => $data['product_type'],
									'ActualWeight' 			 => array('Value' => $data['weight'], 'Unit' => $data['unit']),
									'ChargeableWeight' 	     => array('Value' => $data['weight'], 'Unit' => $data['unit']),
									'NumberOfPieces'		 => 1
								)
	);;
};

if(isset($unit))
	{	
		if(isset($domestic_sub)) {			
			$data=[
					'from_city' =>$from_city,'from_country' => $from_country ,
					'to_city' =>$to_city,'to_country' => $from_country ,
					'product_group'=> 'DOM','product_type' => 'OND',
					'weight' => $weight, 'unit' => $unit
				];
		}
		else{
			$data=[
				'from_city' =>$from_city,'from_country' => $from_country ,
				'to_city' =>$to_city,'to_country' => $to_country ,
				'product_group'=>'EXP' ,'product_type' => $s_type,
				'weight' => $weight, 'unit' => $unit
			];
		}

		$soapClient = new SoapClient('aramex-rates-calculator-wsdl.wsdl');
		
		try{
			
		
			// Aramex default testing credential
			$params = createRateRequestParam($data); 
		
			$results = $soapClient->CalculateRate($params);

			$notifications = json_decode(json_encode($results->Notifications), true);

			if(isset($notifications["Notification"]["Message"])){
				$results->success = "false"; 
			}
			else {
				$results->success = "true"; 
			}	
			echo json_encode($results);
			die();
		}
		catch (SoapFault $fault) {
			
			// echo "TRY FAILED";
	
			die('Error : ' . $fault->faultstring);
		}
	}
?>