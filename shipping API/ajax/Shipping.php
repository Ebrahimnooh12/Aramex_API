<?php
extract($_POST); 




if(isset($client_username)){

    
        error_reporting(E_ALL);
        ini_set('display_errors', '1');
        
        //Test Soap URL 
        $soapClient = new SoapClient('https://ws.dev.aramex.net/ShippingAPI.V2/Shipping/Service_1_0.svc?singleWsdl');
       
        //Live Soap URL
        //$soapClient = new SoapClient('https://ws.aramex.net/ShippingAPI.V2/Shipping/Service_1_0.svc?singleWsdl');
        

        //Get Product Group
        if($shipper_country == $receiver_country){
            $product_group ="DOM";
            $shipment_product_type = "OND";
        }
        else{
            $product_group ="EXP";
        }

        $params = array(
            //include shipment object
            'Shipments' => array(
                //Shipment object
                'Shipment' => array(
                        //Party opject
                        'Shipper'	=> array(
                                        //Any general detail the customer would like to add about the shipment
                                        'Reference1' 	=> $shipper_ref1,
                                        'Reference2' 	=> $shipper_ref2,
                                        'Reference3' 	=> $shipper_ref3,
                                        //Reference1 to Reference3 -> optional
    
                                        //The Same Account number entered in the Client Info
                                        // 'AccountNumber' => $client_acccount,
                                        
                                        //test account
                                        'AccountNumber' => '20016',
                                        //AccountNumber -> conditional
                                        
                                        //Address object
                                        'PartyAddress'	=> array(
                                            //Additional Address information, such as the building number, block, street name
                                            //allowed values More than 3 characters ,(50)
                                            'Line1'					=> $shipper_line1,
                                            //Line1 -> mandatory
                                            
                                            //Other lines 
                                            'Line2' 				=>$shipper_line2,
                                            'Line3' 				=> '',
                                            //optional
    
                                            //Conditional: Required if the post code is not given.
                                            'City'					=> $shipper_city,
                                            //City -> conditional
    
                                            //Address State or province code. Required if The country code and city require a State or Province Code
                                            'StateOrProvinceCode'	=> $shipper_state,
                                            //StateOrProvinceCode -> conditional
    
                                            //Postal Code, if there is a postal code in the country code and city then it must be given.
                                            'PostCode'				=> $shipper_postal,
                                            //PostCode -> conditional
    
                                            //2-Letter Standard ISO Country Code
                                            'CountryCode'			=> $shipper_country,
                                            //CountryCode -> mandatory
                                        ),
                                        //PartyAddress -> optional
    
                                        //Contact object
                                        'Contact'		=> array(
    
                                            //User’s Work Department
                                            'Department'			=> '',
                                            //Department -> optional
    
                                            //User’s Name, Sent By or in the case of the consignee, to the Attention of
                                            'PersonName'			=> $shipper_person,
                                            //PersonName -> mandatory
                                            
                                            //User’s Title
                                            'Title'					=> '',
                                            //Title -> optional
    
                                            //Company or Person name
                                            'CompanyName'			=> $shipper_company,
                                            //CompanyName -> mandatory
    
                                            //Valid Phone Number
                                            'PhoneNumber1'			=> $shipper_phone,
                                            //PhoneNumber1 -> mandatory
    
                                            //Valid Extension to the phone number
                                            'PhoneNumber1Ext'		=> $shipper_phone_ext,
                                            //PhoneNumber1Ext -> optional
    
                                            //others
                                            'PhoneNumber2'			=> '',
                                            'PhoneNumber2Ext'		=> '',
                                            'FaxNumber'				=> '',
                                            //others  -> optional
    
                                            //Cell Phone Number
                                            'CellPhone'				=> $shipper_mobile,
                                            //CellPhone -> mandatory
    
                                            //Email Address
                                            'EmailAddress'			=> $shipper_email,
                                            //EmailAddress -> mandatory
    
                                            //Type
                                            'Type'					=> ''
                                            //Type -> optional
                                        ),
                                        //Contact -> optional
                        ),
                        //Shipper -> mandatory
                        
                        //Party opjects
                        'Consignee'	=> array(
                                        'Reference1'	=> $receiver_ref1,
                                        'Reference2'	=> $receiver_ref2,
                                        'AccountNumber' => '',
                                        'PartyAddress'	=> array(
                                            'Line1'					=> $receiver_line1,
                                            'Line2'					=> $receiver_line1,
                                            'Line3'					=> '',
                                            'City'					=> $receiver_city,
                                            'StateOrProvinceCode'	=> $receiver_state,
                                            'PostCode'				=> $receiver_postal,
                                            'CountryCode'			=> $receiver_country
                                        ),
                                        
                                        'Contact'		=> array(
                                            'Department'			=> '',
                                            'PersonName'			=> $receiver_company,
                                            'Title'					=> '',
                                            'CompanyName'			=> $receiver_company,
                                            'PhoneNumber1'			=> $receiver_phone,
                                            'PhoneNumber1Ext'		=> $receiver_phone_ext,
                                            'PhoneNumber2'			=> '',
                                            'PhoneNumber2Ext'		=> '',
                                            'FaxNumber'				=> '',
                                            'CellPhone'				=> $receiver_mobile,
                                            'EmailAddress'			=> $receiver_email,
                                            'Type'					=> ''
                                        ),
                        ),
                        //Consignee -> mandatory
    
                        //Party opjects - Based on PaymentType = "3"
                        'ThirdParty' => array(
                                        'Reference1' 	=> '',
                                        'Reference2' 	=> '',
                                        'AccountNumber' => '',
                                        'PartyAddress'	=> array(
                                            'Line1'					=> '',
                                            'Line2'					=> '',
                                            'Line3'					=> '',
                                            'City'					=> '',
                                            'StateOrProvinceCode'	=> '',
                                            'PostCode'				=> '',
                                            'CountryCode'			=> ''
                                        ),
                                        'Contact'		=> array(
                                            'Department'			=> '',
                                            'PersonName'			=> '',
                                            'Title'					=> '',
                                            'CompanyName'			=> '',
                                            'PhoneNumber1'			=> '',
                                            'PhoneNumber1Ext'		=> '',
                                            'PhoneNumber2'			=> '',
                                            'PhoneNumber2Ext'		=> '',
                                            'FaxNumber'				=> '',
                                            'CellPhone'				=> '',
                                            'EmailAddress'			=> '',
                                            'Type'					=> ''							
                                        ),
                        ),
                        //ThirdParty -> conditional
    
                        //Any general detail the customer would like to add about the shipment
                        'Reference1' 				=> $shipment_ref1,
                        //Reference1 to Reference3 -> optional
                        
                        //Client’s shipment number if present.If filled this field must be unique for each shipment.
                        'ForeignHAWB'				=> $shipment_HAWB,
                        //ForeignHAWB -> conditional
    
                        //0 or 1 , 0 by Default
                        'TransportType'				=> 0,
                        //TransportType -> optional
    
                        //The date aramex receives the shipment to be shipped out
                        'ShippingDateTime' 			=> time(),
                        //ShippingDateTime -> mandatory
                        
                        //The date specified for shipment to be delivered to the consignee.
                        'DueDate'					=> time(),
                        //DueDate -> optional
    
                        //The location from where the shipment should be picked up, such as the reception desk.
                        'PickupLocation'			=> '',
                        //PickupLocation -> optional
                        'PickupGUID'				=> '',
    
                        //Any comments on the shipment
                        'Comments'					=> $shipment_comments,
                        //Comments -> optional
    
                        //Instructions on how to handle payment specifics.
                        'AccountingInstrcutions' 	=> '',
                        //AccountingInstrcutions -> optional
    
                        //Instructions on how to handle the shipment
                        'OperationsInstructions'	=> '',
                        //OperationsInstructions -> optional
                        
                        //ShipmentDetails
                        'Details' => array(
                                    
                                        //Dimensions object Measurements required in calculating the Chargeable Weight, 
                                        //If any of the dimensional values are filled then the rest must be filled.
                                        'Dimensions' => array(
                                            'Length'				=> 0,
                                            'Width'					=> 0,
                                            'Height'				=> 0,
                                            'Unit'					=> 'cm',
                                            
                                        ),
                                        //Dimensions -> optional
    
                                        //Weight object ,Total actual shipment weight. If the Dimensions are filled, 
                                        //charging weight is compared to actual and the highest value is filled here
                                        'ActualWeight' => array(
                                            'Value'					=> $shipment_weight,
                                            'Unit'					=> $weight_unit
                                        ),
                                        //ActualWeight -> mandatory
                                        
                                        //EXP = Express DOM = Domestic
                                        'ProductGroup' 			=> $product_group,
                                        //ProductGroup -> mandatory
    
                                        //ProductType
                                        'ProductType'			=> $shipment_product_type,
                                        //ProductType -> mandatory
    
                                        //Method of payment for shipment. Refer to Appendix B for more details.
                                        // P , C or 3
                                        'PaymentType'			=> 'P',
                                        //PaymentType -> mandatory
    
                                        //Conditional - Based on the Payment Type "C" ASCC = Needs Shipper Account Number to be filled. 
                                        //ARCC = Needs Consignee Account Number to be filled. 
                                        //Optional - Based on the Payment Type "P" then it is optional to fill. CASH = Cash ACCT = Account
                                        //PPST = Prepaid Stock CRDT = Credit
                                        //Payment Type = C -> ASCC ARCC 
                                        //Payment Type = P  -> CASH ACCT PPST CRDT
                                        'PaymentOptions' 		=> $pay_method,
                                        //PaymentOptions -> conditional
                                        
                                        //Additional Services used in shipping the package, Separate by comma when selecting multiple services. 
                                        //Refer to Appendix C (Service Codes) for valid codes.
                                        'Services'				=> '',
                                        //Services -> optional
    
                                        //Number of shipment pieces, max 100
                                        'NumberOfPieces'		=> $shipment_pieces,
                                        //NumberOfPieces -> mandatory
    
                                        //The Nature of Shipment Contents. Example: Clothes, Electronic Gadgets …..
                                        'DescriptionOfGoods' 	=> $desc_goods,
                                        //DescriptionOfGoods mandatory
    
                                        //The Origin of which the product in the shipment came from
                                        'GoodsOriginCountry' 	=> $origin_goods,
                                        //GoodsOriginCountry -> mandatory
                                        
                                        //Money object
                                        //Amount of Cash that is paid by the receiver of the package. 
                                        //Conditional - Based on the Services "COD" being filled
                                        'CashOnDeliveryAmount' 	=> array(
                                            'Value'					=> 0,
                                            'CurrencyCode'			=> ''
                                        ),
                                        //CashOnDeliveryAmount -> conditional
    
                                        //Money object
                                        //Insurance Amount charged on shipment.
                                        'InsuranceAmount'		=> array(
                                            'Value'					=> 0,
                                            'CurrencyCode'			=> ''
                                        ),
                                        //InsuranceAmount -> optional
                                        
                                        //Money object
                                        //Transportation Charges to be collected from consignee. 
                                        //Conditional - Based on the PaymentType "C" + PaymentOptions "ARCC"
                                        'CollectAmount'			=> array(
                                            'Value'					=> 0,
                                            'CurrencyCode'			=> ''
                                        ),
                                        //CollectAmount -> conditional
                                        
                                        //Money object
                                        //Additional Cash that can be required for miscellaneous purposes.
                                        'CashAdditionalAmount'	=> array(
                                            'Value'					=> 0,
                                            'CurrencyCode'			=> ''							
                                        ),
                                        //CashAdditionalAmount -> optional
                                        
                                        //Conditional - Based on the PaymentType "3" AND Cash Additional Amount is filled
                                        'CashAdditionalAmountDescription' => '',
                                        //CashAdditionalAmountDescription -> conditional
    
                                        //Value Charged by Destination Customs. Conditional - Based on the ProductType "Dutible"
                                        'CustomsValueAmount' => array(
                                            'Value'					=> 0,
                                            'CurrencyCode'			=> ''								
                                        ),
                                        //CustomsValueAmount -> conditional
                                        
                                        //Details of the Items within a shipment. Several items can be added for a single shipment
                                        'Items' 				=> array()
                                        //Items -> optional
    
                        ),
                        //Details -> mandatory
                ),
                //Shipment -> mandatory
            ),
            //Shipments -> mandatory    
            
            // ClientInfo Credentials
            'ClientInfo'  			=> array(
                                        // 'AccountCountryCode'	=> $client_country,
                                        // 'AccountEntity'		 	=> $client_entity,
                                        // 'AccountNumber'		 	=> $client_acccount,
                                        // 'AccountPin'		 	=> $client_pin,
                                        // 'UserName'			 	=> $client_username,
                                        // 'Password'			 	=> $client_password,
                                        // 'Version'			 	=> 'v1'

                                        //Test Credentials
                                        'AccountCountryCode'	=> 'JO',
                                        'AccountEntity'		 	=> 'AMM',
                                        'AccountNumber'		 	=> '20016',
                                        'AccountPin'		 	=> '331421',
                                        'UserName'			 	=> 'testingapi@aramex.com',
                                        'Password'			 	=> 'R123456789$r',
                                        'Version'			 	=> 'v1'
                                    ),
            //ClientInfo -> mandatory
        
            //Transaction -> Contains the data sent in the request by the user, used mainly for identification purposes.
            'Transaction' 			=> array(
                                        'Reference1'			=> 	$transaction_ref1,
                                        'Reference2'			=> 	$transaction_ref2,
                                        'Reference3'			=> 	$transaction_ref3,
                                        'Reference4'			=> 	$transaction_ref4,								
                                        'Reference5'			=> 	$transaction_ref5,								
                                    ),
            // Reference1 to Reference5 -> optional
            
            //Label Info
            'LabelInfo'				=> array(
                                        //The Template of the report to be generated. Allowd value 9201 
                                        'ReportID' 				=> $label_report,
                                        //Either by URL or a streamed file (RPT).URL by Default
                                        'ReportType'			=> $label_report_type,
            ),
            //Label Info -> mandatory
    );
    
    
        
        // $params['Shipments']['Shipment']['Details']['Items'][] = array(
        //     'PackageType' 	=> 'Box',
        //     'Quantity'		=> 1,
        //     'Weight'		=> array(
        //             'Value'		=> 0.5,
        //             'Unit'		=> 'Kg',		
        //     ),
        //     'Comments'		=> 'Docs',
        //     'Reference'		=> ''
        // );
        
        
        try {
            $auth_call = $soapClient->CreateShipments($params);
            
            //Redirect Url after response
            $auth_call->redirectUrl = "shippingResult.html";
            // print_r($auth_call);
            echo json_encode($auth_call);
            die();
        } catch (SoapFault $fault) {
            die('Error : ' . $fault->faultstring);
        }
}

?>
