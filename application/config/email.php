<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*$config['protocol'] = 'smtp';
$config['smtp_host'] = 'ssl://smtp.gmail.com';
$config['smtp_port'] = 465;
$config['smtp_user'] = 'cah7x.jogja@gmail.com';
$config['smtp_pass'] = '';
$config['charset'] = 'iso-8859-1';*/

$config['protocol'] = 'sendmail';
//$config['mailpath'] = '/usr/sbin/sendmail';
$config['charset'] = 'iso-8859-1';
$config['wordwrap'] = TRUE;
$config['mailtype'] = 'html';