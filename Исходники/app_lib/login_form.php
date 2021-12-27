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
$user_password = $data['usrpass'];
$user_email = isset($data['usremail']) ? DecryptString($data['usremail']) : "";
$user_shop_id = isset($data['usrshid']) ? DecryptString($data['usrshid']) : "";

if($method_req == "logl")
{
	$sql = "SELECT id, login, password, email, phone, name, shoplink, shopid FROM admin_data WHERE login = '%s'";
	$query = sprintf($sql, mysqli_real_escape_string($dbh, $user_login));
	$result = mysqli_query($dbh, $query);
	$row = mysqli_fetch_array($result);
	//Проверям есть ли такой логин
	if($row['login'] == $user_login)
	{
		if($row['password'] == $user_password)
		echo EncryptString($row['id'].":".$row['email'].":".$row['phone'].":".$row['name'].":".$row['shoplink'].":".$row['shopid']);
		else
		echo EncryptString("pass_fail");
	}
	else
	{
		echo EncryptString("login_fail");	
	}
}
else if($method_req == "loge")
{
    $sql = "SELECT id, login, password, email, phone, name, shoplink, shopid FROM admin_data WHERE email = '%s'";
    $query = sprintf($sql, mysqli_real_escape_string($dbh, $user_email));
	$result = mysqli_query($dbh, $query);;
	$row = mysqli_fetch_array($result);
	//Проверям есть ли такой логин
	if($row['email'] == $user_email)
	{
		if($row['password'] == $user_password)
		echo EncryptString($row['id'].":".$row['login'].":".$row['phone'].":".$row['name'].":".$row['shoplink'].":".$row['shopid']);
		else
		echo EncryptString("pass_fail");
	}
	else
	{
		echo EncryptString("email_fail");	
	}
}
else if($method_req == "geti")
{
    $sql = "SELECT id, shopid, bottoken, tgchatid, imagelink, anykey, any_id, cardkey, card_id, freekey, fk_id FROM shop_data WHERE shopid = '%s'";
	$query = sprintf($sql, mysqli_real_escape_string($dbh, $user_shop_id));
	$result = mysqli_query($dbh, $query);;
	$row = mysqli_fetch_array($result);
	//Проверям есть ли такой логин
	if($row['shopid'] == $user_shop_id)
	{
		echo EncryptString($row['shopid'].":".$row['bottoken'].":".$row['tgchatid'].":".$row['imagelink'].":".$row['anykey'].":".$row['any_id'].":".$row['cardkey'].":".$row['card_id'].":".$row['freekey'].":".$row['fk_id']);
	}
	else
	{
		echo EncryptString("shop_fail");	
	}
}
else
echo EncryptString("method_fail");

// Закрываем соединение
mysqli_close($dbh);
?>