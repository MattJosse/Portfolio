<?php

$cfg['PmaAbsoluteUri'] = '';
$cfg['DefaultConnectionCollation'] = 'utf8_general_ci';
$cfg['DefaultCharset'] = 'utf8_general_ci';
$cfg['blowfish_secret'] = 'qsdf4545JKghjf;:sdfkhjkljkejhrkjHJHJGhjgdfsjkhdfsj';

/**
 * Server(s) configuration
 */
$i = 0;

/* Server: localhost [1] */

$i++;
$cfg['Servers'][$i]['verbose'] = '';
$cfg['Servers'][$i]['host'] = '0.0.0.0';
$cfg['Servers'][$i]['port'] = '3306';
$cfg['Servers'][$i]['connect_type'] = 'tcp';
$cfg['Servers'][$i]['auth_type'] = 'cookie';
