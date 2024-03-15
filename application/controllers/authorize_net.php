<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

$sitedata=getsitedata();



// Authorize.net Account Info
//$config['api_login_id'] = '';
//$config['api_transaction_key'] = '';
$config['api_login_id'] = $sitedata[0]['login_id'];
$config['api_transaction_key'] = $sitedata[0]['transaction_key'];

$config['api_url'] = 'https://test.authorize.net/gateway/transact.dll'; // TEST URL
//$config['api_url'] = 'https://secure.authorize.net/gateway/transact.dll'; // PRODUCTION URL

/* EOF */