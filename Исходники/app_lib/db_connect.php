<?php
if( !defined("IN_PAGE") )
{
	header("location: https://www.google.ru/");
	die();
}

function getConnection()
{
    $ini_array = parse_ini_file("con_data/connect.ini");
    $host= $ini_array['host'];
    $database= $ini_array['database'];
    $user= $ini_array['user'];
    $pswd= $ini_array['pswd']; 
    return mysqli_connect($host, $user, $pswd, $database);
}

function send_telegram_message($message, $id, $tokken){
    $filename = "https://api.telegram.org/bot".$tokken."/sendMessage?chat_id=".$id."&text=".urlencode($message)."&parse_mode=html";
	file_get_contents($filename);
}

function send_item_email($g_email, $g_item, $g_shopid, $g_key, $g_domain){
    $headers = 'From: info@'.$g_domain . "\r\n" .
    'Reply-To: info@'.$g_domain. "\r\n" .
    'X-Mailer: PHP/' . phpversion();
        
        $message = "Приветсвую тебя дорогой покупатель!\n\nИнструкция по использованию и ключ доступен по ссылке ниже:\nhttps://npanel.ru/CourseWork/order.php?email="
      	.$g_email."&item_code=".$g_item."&item_key=".$g_key."&shop_id=".$g_shopid."\nТехическая поддержка доступна на сайте: https://".$g_domain."\n\nС уважением команда,\n".$g_domain;
	
	mail($g_email, 'Ключ активации продуктов '.$g_domain, $message, $headers);
}


function EncryptString($data_str)
{
    $ini_array = parse_ini_file("con_data/connect.ini");
    $password = $ini_array['cryptek'];
    $password = substr(hash('sha256', $password, true), 0, 32);
    $iv = chr($ini_array['crypteb'][0]) . chr($ini_array['crypteb'][1]) . chr($ini_array['crypteb'][2]) . chr($ini_array['crypteb'][3]) . chr($ini_array['crypteb'][4])
    . chr($ini_array['crypteb'][5]) . chr($ini_array['crypteb'][6]) . chr($ini_array['crypteb'][7]) . chr($ini_array['crypteb'][8]) . chr($ini_array['crypteb'][9])
    . chr($ini_array['crypteb'][10]) . chr($ini_array['crypteb'][11]) . chr($ini_array['crypteb'][12]) . chr($ini_array['crypteb'][13]) . chr($ini_array['crypteb'][14])
    . chr($ini_array['crypteb'][15]);
    return base64_encode(openssl_encrypt($data_str, 'aes-256-cbc', $password, OPENSSL_RAW_DATA, $iv));
}

function DecryptString($data_str)
{
    $ini_array = parse_ini_file("con_data/connect.ini");
    $password = $ini_array['cryptek'];
    $password = substr(hash('sha256', $password, true), 0, 32);
  $iv = chr($ini_array['crypteb'][0]) . chr($ini_array['crypteb'][1]) . chr($ini_array['crypteb'][2]) . chr($ini_array['crypteb'][3]) . chr($ini_array['crypteb'][4])
    . chr($ini_array['crypteb'][5]) . chr($ini_array['crypteb'][6]) . chr($ini_array['crypteb'][7]) . chr($ini_array['crypteb'][8]) . chr($ini_array['crypteb'][9])
    . chr($ini_array['crypteb'][10]) . chr($ini_array['crypteb'][11]) . chr($ini_array['crypteb'][12]) . chr($ini_array['crypteb'][13]) . chr($ini_array['crypteb'][14])
    . chr($ini_array['crypteb'][15]);
    return openssl_decrypt(base64_decode($data_str), 'aes-256-cbc', $password, OPENSSL_RAW_DATA, $iv);
}

$dbh = getConnection();

?>