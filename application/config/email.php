<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$config['useragent'] = 'CodeIgniter';
$config['protocol'] = 'smtp';

//$config['mailpath'] = '/usr/sbin/sendmail';
$config['smtp_host'] = 'ssl://smtp.gmail.com';
$config['smtp_port'] = 465;
$config['smtp_user'] = '{your_mail@mail.com}';
$config['smtp_pass'] = '{your pass mail app}';
$config['smtp_timeout'] = 60;

$config['charset'] = 'iso-8859-1';
$config['mailtype'] = 'html';
$config['newline'] = "\r\n";
$config['wordwrap'] = TRUE;
$config['validate'] = TRUE;
$config['wrapchars'] = 76;

// $config['priority'] = 3;
// $config['crlf'] = "\r\n";
// $config['bcc_batch_mode'] = FALSE;
// $config['bcc_batch_size'] = 200;

?>
