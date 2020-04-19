<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require('vendor/zendframework/zend-server/src/Client.php');
require('vendor/zendframework/zend-soap/src/Client.php');
require('vendor/zendframework/zend-soap/src/Client/Common.php');


// http://<magento.host>/soap/all?wsdl_list=1

$value = $_REQUEST['type'];

$baseUrl = "http://m2-demo.com/soap/";


$request = new SoapClient($baseUrl."?wsdl&services=integrationAdminTokenServiceV1", array("soap_version" => SOAP_1_2));
$token = $request->integrationAdminTokenServiceV1CreateAdminAccessToken(array("username"=>"admin", "password"=>"admin@123"));

$opts = ['http' => ['header' => "Authorization: Bearer ".$token->result]];
$context = stream_context_create($opts);




/* START GET FUNCTION LIST*/


// $wsdlUrl = $baseUrl.'default?wsdl&services=salesOrderRepositoryV1';

// $request = new SoapClient($baseUrl."?wsdl&services=integrationAdminTokenServiceV1", array("soap_version" => SOAP_1_2));
// $token = $request->integrationAdminTokenServiceV1CreateAdminAccessToken(array("username"=>"admin", "password"=>"admin@123"));

// $opts = ['http' => ['header' => "Authorization: Bearer ".$token->result]];
// $context = stream_context_create($opts);
// $soapClient = new SoapClient($wsdlUrl, ['version' => SOAP_1_2, 'context' => $context,'trace' => 1]);
 
// $soapResponse = $soapClient->__getFunctions();
// echo "<pre>";
// print_r($soapResponse);

// exit;

/* end get functions */




//$wsdlUrl = YOUR_BASE_URL."soap?wsdl&services=customerAccountManagementV1,customerCustomerRepositoryV1,alanKentCalculatorWebServiceCalculatorV1";//To declar multiple


switch ($value) {
	case 'test':
		try{  		
			// $proxy = new SoapClient($baseUrl.'default?wsdl&services=inchooHelloV1');
			// $result = $proxy->inchooHelloV1Name(array("name"=>"Jim"));
			// var_dump($result);

			// exit;

			$wsdlurl = $baseUrl.'default?wsdl&services=inchooHelloV1';
			$soapClient = new \Zend\Soap\Client($wsdlurl);
			$soapClient->setSoapVersion(SOAP_1_2);
			// $soapClient->setStreamContext($context);

			$serviceArgs = array("name"=>"Manoj");

			$result = $soapClient->inchooHelloV1Name($serviceArgs);
		}catch(Exception $e){
			echo "<h1>";
			echo '<b>Un-authorized Req: </b> ---->   '.$e->getMessage();
			echo "</h1>";
		}
		break;
	case 'get_by_id':
		try{  
			// get single customer
			$wsdlurl = $baseUrl.'default?wsdl&services=customerCustomerRepositoryV1';
			$soapClient = new \Zend\Soap\Client($wsdlurl);
			$soapClient->setSoapVersion(SOAP_1_2);
			$soapClient->setStreamContext($context);

			$serviceArgs = array('customerId' => 1);

			$result = $soapClient->customerCustomerRepositoryV1GetById($serviceArgs);
		}catch(Exception $e){
			echo "<h1>";
			echo '<b>Un-authorized Req: </b> ---->   '.$e->getMessage();
			echo "</h1>";
		}
	break;

	case 'get_list':
		try{  
			// order list -- salesOrderRepositoryV1
			// $wsdlurl = $baseUrl.'default?wsdl&services=catalogProductRepositoryV1';
			$wsdlurl = $baseUrl.'default?wsdl&services=salesOrderRepositoryV1';
			$soapClient = new \Zend\Soap\Client($wsdlurl);
			$soapClient->setSoapVersion(SOAP_1_2);
			$soapClient->setStreamContext($context);

			$serviceArgs = array('searchCriteria'=> 
				array('filterGroups' => 
					array ('filters' =>
						array('field' =>'increment_id',
							'value' => '000000002' , 
							'condition_type' => 'eq'
						)
					)
				)
			);
			$result = $soapClient->salesOrderRepositoryV1GetList($serviceArgs);
			// https://devdocs.magento.com/guides/v2.3/rest/performing-searches.html

			// $serviceArgs = array(
			// 	'searchCriteria'=> 
			// 	array(
			// 		'filterGroups' => 
			// 		array (
			// 			'filters' =>
			// 			array(
			// 				'field' =>'price',
			// 				'value' => 99 , 
			// 				'condition_type' => 'lt'
			// 			)
			// 		)
			// 	)
			// );
			// $result = $soapClient->catalogProductRepositoryV1GetList($serviceArgs);
			
		}catch(Exception $e){
			echo "<h1>";
			echo '<b>Un-authorized Req: </b> ---->   '.$e->getMessage();
			echo "</h1>";
		}
	break;

	case 'create':
		try{  
			// create customer
			$wsdlurl = $baseUrl.'default?wsdl&services=customerCustomerRepositoryV1';
			$soapClient = new \Zend\Soap\Client($wsdlurl);
			$soapClient->setSoapVersion(SOAP_1_2);
			$soapClient->setStreamContext($context);

			$serviceArgs = [
				'customer'=>
				[
					'email'=> 'customer-mail@example.org',
					'firstname' => 'Dough',
					'lastname' => 'Deeks',
					'password' => 'test@123',
					'promotion_code' => 'test123',
					'regulation' => '1',
					'website_id' => 1,
					'store_id' => 1,
					'group_id' => 1
				]
			];

			$result = $soapClient->customerCustomerRepositoryV1Save($serviceArgs);
			
		}catch(Exception $e){
			echo "<h1>";
			echo '<b>Un-authorized Req: </b> ---->   '.$e->getMessage();
			echo "</h1>";
			echo "<pre>";
			print_r($serviceArgs);
		}
	break;

	case 'delete':
		try{  
			// delete single customer
			$wsdlurl = $baseUrl.'default?wsdl&services=customerCustomerRepositoryV1';
			$soapClient = new \Zend\Soap\Client($wsdlurl);
			$soapClient->setSoapVersion(SOAP_1_2);
			$soapClient->setStreamContext($context);

			$serviceArgs = array('customerId' => 3);

			$result = $soapClient->customerCustomerRepositoryV1DeleteById($serviceArgs);
		}catch(Exception $e){
			echo "<h1>";
			echo '<b>Un-authorized Req: </b> ---->   '.$e->getMessage();
			echo "</h1>";
		}
	break;

	case 'update':
		try{  
			// update customer
			$wsdlurl = $baseUrl.'default?wsdl&services=customerCustomerRepositoryV1';

			// var_dump ($request->__getFunctions());

			// exit;

			$soapClient = new \Zend\Soap\Client($wsdlurl);
			$soapClient->setSoapVersion(SOAP_1_2);
			$soapClient->setStreamContext($context);
			
			// $serviceArgs = array('searchCriteria'=> 
			// 	array('filterGroups' => 
			// 		array ('filters' =>
			// 			array('field' =>'increment_id',
			// 				'value' => '000000001' , 
			// 				'condition_type' => 'eq'
			// 			)
			// 		)
			// 	)
			// );

			// $result = $soapClient->salesOrderRepositoryV1GetList($serviceArgs);
			
		}catch(Exception $e){
			echo "<h1>";
			echo '<b>Un-authorized Req: </b> ---->   '.$e->getMessage();
			echo "</h1>";
		}
	break;
	
	default:
		echo "no matching type found";exit;
		break;
}

if(isset($result)){
	echo "<pre>"; print_r($result); 
}





?>

<!-- https://magento.stackexchange.com/questions/84795/magento2-soap-api-not-authorized-issue -->

<!-- https://gist.github.com/rafaelstz/ecab668b80fece4d9acdb9c5358b3173 -->

<!-- https://magento.stackexchange.com/questions/99207/how-to-fetch-customer-detail-with-soap-api-in-magento-2 -->


<!-- 
	// Different Servies for Modules
	https://devdocs.magento.com/guides/v2.3/soap/bk-soap.html 

-->


<!--
IMPLEMENTING SOAP & REST API IN MAGENTO 2

https://www.dckap.com/blog/magento-2-webapi/
https://amasty.com/blog/how-to-start-with-magento-2-api/
-->

<!-- https://www.mageplaza.com/devdocs/get-all-order-collection-filters-magento-2.html#method-1 -->


<!-- https://inchoo.net/magento-2/magento-2-custom-api/ -->