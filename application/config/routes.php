<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	https://codeigniter.com/userguide3/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There are three reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router which controller/method to use if those
| provided in the URL cannot be matched to a valid route.
|
|	$route['translate_uri_dashes'] = FALSE;
|
| This is not exactly a route, but allows you to automatically route
| controller and method names that contain dashes. '-' isn't a valid
| class or method name character, so it requires translation.
| When you set this option to TRUE, it will replace ALL dashes in the
| controller and method URI segments.
|
| Examples:	my-controller/index	-> my_controller/index
|		my-controller/my-method	-> my_controller/my_method
*/
$route['default_controller'] = 'Home__Controller';
//Login field
$route['DashBoard']='Home__Controller/DashBoard';
//Logout Fields
$route['LogOut']='Home__Controller/LogOut';

//customer route
$route['Customer']='Customer__Controller';
//Customer Lead
$route['LeadCT'] ='Customer__Controller/CustomerLead__Table';
$route['CLeadTable']='Customer__Controller/CustomerLead__Table__GetData';
//Customer Demo Activation
$route['Customer-Demo']='Customer__Controller/Customer__Demo__Activation';
$route['Customer-Profile']='Customer__Controller/Customer__Profile';
$route['CDemoTable']='Customer__Controller/CustomerDemo__Table__GetData';
//Customer Live Activation
$route['Customer-Activation']='Customer__Controller/Customer__Activation';
$route['Customer-Profile-Activation']='Customer__Controller/Customer__Profile__Activation';
$route['Customer-Demo-Extend']='Customer__Controller/Customer__Demo__Extended';
$route['ActivationCustomerT']='Customer__Controller/Customer__Activation__Table';
$route['ActivationCustomerTable']='Customer__Controller/ActivationsCustomer__Table__GetData';
//Activation Update
$route['CustomerActivationU/(:num)']='Customer__Controller/Customer__Activation__Update';
$route['CustomerT']='Customer__Controller/Customer__Table';//running
//table data routing
$route['myCustomerTable']='Customer__Controller/Customer__Table__GetData';//running
//Customer All Information API
$route['Customer-get-Details/(:num)']='Customer__Controller/Customer__Details__API';
/************************************************************************************** */



$route['Customer_SerialKey']='Customer__Controller/Customer__SerialKey__Check';
//CustomerUpdate
$route['CustomerU/(:num)']='Customer__Controller/Customer__Update';

//Table route

$route['AMCExpiredT'] ='Customer__Controller/AMCExpired__Table';

$route['DemoCT'] ='Customer__Controller/CustomerDemo__Table';
$route['LiveCT'] ='Customer__Controller/CustomerLive__Table';
$route['PaymentRCT'] ='Customer__Controller/CustomerPaymentRecived__Table';
$route['PaymentPCT'] ='Customer__Controller/CustomerPaymentPending__Table';
$route['AMCExpiredThirtyDaysT'] ='Customer__Controller/Customer__AfterDays__AMCExpired';


$route['myCustomerAMCExpiredTable'] ='Customer__Controller/AMCExpiredCustomer__Table__GetData';

$route['CLiveTable']='Customer__Controller/CustomerLive__Table__GetData';

$route['CPPendingTable']='Customer__Controller/CustomerPaymentPending__Table__GetData';
$route['CPReciviedTable']='Customer__Controller/CustomerPaymentRecived__Table__GetData';
$route['AMCExpiredthirtydaysCustomer'] ='Customer__Controller/AMCExpiredthirtydaysCustomer__Table__GetData';

//Customer Status change route
$route['ChangeCustomerStatusAPI']='Customer__Controller/Change__Customer__Status';
//Active Customer Status change route
$route['ChangeActiveCustomerStatusAPI']='Customer__Controller/Change__ActiveCustomer__Status';
//************************************************************************************** */
//Employee route
$route['EmployeeRegister']='Employee__Controller';
//Employee Update
$route['EmployeeU/(:num)']='Employee__Controller/Employee__Update';
//Employee Table route
$route['EmployeeT']='Employee__Controller/Employee__Table';
//Employee table data route
$route['myEmployeeTable']='Employee__Controller/Employee__Table__GetData';
//employee status change route
$route['ChangeEmployeeStatusAPI']='Employee__Controller/Change__Employee__Status';


//*************************************************************************** */


//add route
$route['About__Us']='About__Us__Controller';
$route['Career']='Career__Controller';

$route['CFeedbackStatus'] ='CustFeedStatus__Controller';

$route['Product']='Product__Controller';

$route['Software']='Software__Controller';
$route['Business']='Business__Controller';
$route['Enquiry']='Enquiry__Controller';
$route['Subscribe']='Subscribe__Controller';
$route['Contact']='Contact__Controller';
$route['NewProduct']='NewP__Controller';
$route['Service']='ServiceP__Controller';
$route['NewsBlog']='NewsBlog__Controller';


//Table route




$route['ProductT']='Product__Controller/Product__Table';

$route['SoftwareT']='Software__Controller/Software__Table';
$route['BusinessT']='Business__Controller/Business__Table';
$route['EnquiryT']='Enquiry__Controller/Enquiry__Table';
$route['NewProductT']='NewP__Controller/New__Product__Table';
$route['ServiceT']='ServiceP__Controller/ServiceP__Table';
$route['CareerT']='Career__Controller/Career__Table';
$route['NewsBlogT']='NewsBlog__Controller/NewsBlog__Table';




$route['mySoftwareTable']='Software__Controller/Software__Table__GetData';
$route['myBusinessTable']='Business__Controller/Business__Table__GetData';

$route['myProductTable']='Product__Controller/Product__Table__GetData';
$route['myContactTable']='Contact__Controller/Contact__Table__GetData';
$route['mySubscriptionTable']='Subscribe__Controller/Subscribe__Table__GetData';
$route['myCareerTable']='Career__Controller/Career__Table__GetData';
$route['myNewsBlogTable']='NewsBlog__Controller/NewsBlog__Table__GetData';
$route['CustomerRevisitDTable/(:num)']='Customer__Controller/Customer__Revisit__Table__GetData';

//Webservices calling
$route['mySubscription']='Subscribe__Controller/Set__Subscriber';
$route['myContact']='Contact__Controller/Set__Contact';
$route['MyNewsBlog']='NewsBlog__Controller/Get__NewsBlog';

//Update route

$route['ProductU']='Product__Controller/Product__Update';

$route['SoftwareU']='Software__Controller/Software__Update';
$route['BusinessU']='Business__Controller/Business__Update';
$route['EnquiryU']='Enquiry__Controller/Enquiry__Update';
$route['NewProductU']='NewP__Controller/New__Product__Update';
$route['ServiceU']='ServiceP__Controller/ServiceP__Update';
$route['CareerU']='Career__Controller/Career__Update';
$route['NewsBlogU']='NewsBlog__Controller/NewsBlog__Update';

//autocomplete route
$route['CustomerFirmName']='Customer__Controller/FirmName__Get__Autocomplete';

//extra routing
$route['CustomerRevisit']='Customer__Controller/Customer__Revisit';

//under table report
$route['CustomerRevisitTable/(:num)']='Customer__Controller/Customer__Revisit__Table';


//********************************************Portal API calling******************************************//
//$route['dataKrushiSeed/(:any)/(:num)/(:any)']='Nic__Controller/process_krushi_data';
//$route['datatoKrushiseeds/(:any)/(:num)/(:any)']='Nic__Controller/process_krushi_data';
$route['DataToKrushiSeed/(:any)/(:num)/(:any)/(:any)']='Nic__Controller';
//$route['DataToKrushiSeedTo/(:any)/(:num)/(:any)/(:any)']='Nic__Controller/New_Api_Checkup';
//pending Purchase API
//$route['DataToKrushiSeedToPPI/(:any)/(:num)/(:any)/(:any)']='Nic__Controller/New_Api_PPI';

$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;
