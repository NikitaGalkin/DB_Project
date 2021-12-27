<?php
define('IN_PAGE', TRUE);
include 'db_connect.php';

// Проверка результата подключения
if (!$dbh) {
    die(EncryptString("Connetction error!"));
}

parse_str(file_get_contents('php://input'), $data);

//Меняем кодировку файла
header('Content-type: text/plain; charset=utf-8'); 
mysqli_set_charset($dbh, 'utf8');

//Переменные
$method_req = isset($data['metreq']) ? DecryptString($data['metreq']) : "";
$user_login = isset($data['usrlogin']) ? DecryptString($data['usrlogin']) : "";
$user_email = isset($data['usremail']) ? DecryptString($data['usremail']) : "";
$user_phone = isset($data['usrphn']) ? DecryptString($data['usrphn']) : "";
$user_shopl = isset($data['usrshpl']) ? DecryptString($data['usrshpl']) : "";
$user_image = isset($data['usrimg']) ? DecryptString($data['usrimg']) : "";
//переменные для ключей
$bt_tkn = isset($data['btkn']) ? DecryptString($data['btkn']) : "";
$bt_id = isset($data['btid']) ? DecryptString($data['btid']) : "";
$akey = isset($data['akey']) ? DecryptString($data['akey']) : "";
$aid = isset($data['aid']) ? DecryptString($data['aid']) : "";
$ckey = isset($data['ckey']) ? DecryptString($data['ckey']) : "";
$cid = isset($data['cid']) ? DecryptString($data['cid']) : "";
$fkey = isset($data['fkey']) ? DecryptString($data['fkey']) : "";
$fid = isset($data['fid']) ? DecryptString($data['fid']) : "";

if($method_req == "edte")
{
	$sql = "SELECT login FROM admin_data WHERE login = '%s'";
	$query = sprintf($sql, mysqli_real_escape_string($dbh, $user_login));
	$result = mysqli_query($dbh, $query);
	$row = mysqli_fetch_array($result);
	//Проверям есть ли такой логин
	if($row['login'] == $user_login)
	{
	    $sql = "UPDATE admin_data SET email = '%s' WHERE login = '%s'";
	    $query = sprintf($sql, mysqli_real_escape_string($dbh, $user_email), mysqli_real_escape_string($dbh, $user_login));
	    if (mysqli_query($dbh, $query)) 
	    echo EncryptString("succses");
	    else 
	    echo EncryptString("fail");
	}
}
else if($method_req == "edtp")
{
   	$sql = "SELECT login FROM admin_data WHERE login = '%s'";
	$query = sprintf($sql, mysqli_real_escape_string($dbh, $user_login));
	$result = mysqli_query($dbh, $query);
	$row = mysqli_fetch_array($result);
	//Проверям есть ли такой логин
	if($row['login'] == $user_login)
	{
	    $sql = "UPDATE admin_data SET phone = '%s' WHERE login = '%s'";
	    $query = sprintf($sql, mysqli_real_escape_string($dbh, $user_phone), mysqli_real_escape_string($dbh, $user_login));
	    if (mysqli_query($dbh, $query)) 
	    echo EncryptString("succses");
	    else 
	    echo EncryptString("fail");
	}
}
else if($method_req == "edtl")
{
    $sql = "SELECT login FROM admin_data WHERE login = '%s'";
	$query = sprintf($sql, mysqli_real_escape_string($dbh, $user_login));
	$result = mysqli_query($dbh, $query);
	$row = mysqli_fetch_array($result);
	//Проверям есть ли такой логин
	if($row['login'] == $user_login)
	{
	    $sql = "UPDATE admin_data SET shoplink = '%s' WHERE login = '%s'";
	    $query = sprintf($sql, mysqli_real_escape_string($dbh, $user_shopl), mysqli_real_escape_string($dbh, $user_login));
	    if (mysqli_query($dbh, $query)) 
	    echo EncryptString("succses");
	    else 
	    echo EncryptString("fail");
	}
}
else if($method_req == "insph")
{
    $sql = "SELECT shopid FROM shop_data WHERE shopid = '%s'";
	$query = sprintf($sql, mysqli_real_escape_string($dbh, $user_shopl));
	$result = mysqli_query($dbh, $query);
	$row = mysqli_fetch_array($result);
	//Проверям есть ли такой логин
	if($row['shopid'] == $user_shopl)
	{
	    mysqli_set_charset($dbh, 'cp1251');
	    $sql = "UPDATE shop_data SET imagelink = '%s' WHERE shopid = '%s'";
	    $query = sprintf($sql, mysqli_real_escape_string($dbh, $user_image), mysqli_real_escape_string($dbh, $user_shopl));
	    if (mysqli_query($dbh, $query)) 
	    echo EncryptString("succses");
	    else 
	    echo EncryptString("fail");
	}
}
else if($method_req == "insinf")
{
    $sql = "SELECT shopid FROM shop_data WHERE shopid = '%s'";
	$query = sprintf($sql, mysqli_real_escape_string($dbh, $user_shopl));
	$result = mysqli_query($dbh, $query);
	$row = mysqli_fetch_array($result);
	//Проверям есть ли такой логин
	if($row['shopid'] == $user_shopl)
	{
	    $sql = "UPDATE shop_data SET bottoken = '%s', tgchatid = '%s', 
	    anykey = '%s', any_id = '%s', cardkey = '%s', card_id = '%s', freekey = '%s', fk_id = '%s' WHERE shopid = '%s'";
	    $query = sprintf($sql, mysqli_real_escape_string($dbh, $bt_tkn), mysqli_real_escape_string($dbh, $bt_id)
	    , mysqli_real_escape_string($dbh, $akey), mysqli_real_escape_string($dbh, $aid), mysqli_real_escape_string($dbh, $ckey)
	    , mysqli_real_escape_string($dbh, $cid), mysqli_real_escape_string($dbh, $fkey), mysqli_real_escape_string($dbh, $fid)
	    , mysqli_real_escape_string($dbh, $user_shopl));
	    if (mysqli_query($dbh, $query)) 
	    echo EncryptString("succses");
	    else 
	    echo EncryptString("fail");
	}
}

// Закрываем соединение
mysqli_close($dbh);
?>