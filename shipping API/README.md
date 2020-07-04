# Content
 - Ajax version : using ajax form submission
 - Non-Ajax version : Using normal from submission

# remark 
### Credentials 
```php
<?php

//Client details 
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
                          
//Shipper details

'Shipper'	=> array(
                
                 //The Same Account number entered in the Client Info
                 // 'AccountNumber' => $client_acccount,

                 //test account
                 'AccountNumber' => '20016',
                 //AccountNumber -> conditional

            ?>
```
