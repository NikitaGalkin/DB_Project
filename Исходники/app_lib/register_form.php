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
$user_login = isset($data['usrlogin']) ? DecryptString($data['usrlogin']): "";
$user_password = $data['usrpass'];
$user_email = isset($data['usremail']) ? DecryptString($data['usremail']): "";
$user_phone = isset($data['usrphn']) ? DecryptString($data['usrphn']): "";
$user_name = isset($data['usrname']) ? DecryptString($data['usrname']): "";
$user_surl = isset($data['usrsurl']) ? DecryptString($data['usrsurl']): "";
$user_sid = isset($data['usrsid']) ? DecryptString($data['usrsid']): "";

if($method_req == "mreg")
{
$sql = "SELECT login FROM admin_data WHERE login = '%s'";
$query = sprintf($sql, mysqli_real_escape_string($dbh, $user_login));
$result = mysqli_query($dbh, $query);
$row = mysqli_fetch_array($result);
if($row['login'] == $user_login)
    echo EncryptString("login_full");
else
{
    $sql = "SELECT email FROM admin_data WHERE email = '%s'";
    $query = sprintf($sql, mysqli_real_escape_string($dbh, $user_email));
    $result = mysqli_query($dbh, $query);
    $row = mysqli_fetch_array($result);
    if($row['email'] == $user_email)
    echo EncryptString("email_full");
    else
    {
        if($user_login && $user_password)
        {
            $link;
            $sql = "INSERT INTO admin_data (login, password, email, phone, name, shoplink, shopid) VALUES ('%s', '%s', '%s', '%s', '%s', '%s', '%s')";
            $query = sprintf($sql, mysqli_real_escape_string($dbh, $user_login)
            , mysqli_real_escape_string($dbh, $user_password)
            , mysqli_real_escape_string($dbh, $user_email)
            , mysqli_real_escape_string($dbh, $user_phone)
            , mysqli_real_escape_string($dbh, $user_name)
            , mysqli_real_escape_string($dbh, $user_surl)
            , mysqli_real_escape_string($dbh, $user_sid));
            $result = mysqli_query($dbh, $query);
            if ($result) 
            {
                $sql = mysqli_query($dbh, "INSERT INTO shop_data (shopid, imagelink) VALUES ('$user_sid', 'def_logo.png')");
                echo EncryptString("succses");
            }
                else 
                echo EncryptString("fail");
        }
    }
}
} 
else if($method_req == "mchl")
{
$sql = "SELECT login, email FROM admin_data WHERE login = '%s'";
$query = sprintf($sql, mysqli_real_escape_string($dbh, $user_login));
$result = mysqli_query($dbh, $query);
$row = mysqli_fetch_array($result);
if($row['login'] == $user_login)
echo EncryptString("found:".$row['email']);
else
echo EncryptString("not_found");
}
else if($method_req == "mche")
{
$sql = "SELECT email FROM admin_data WHERE email = '%s'";
$query = sprintf($sql, mysqli_real_escape_string($dbh, $user_email));
$result = mysqli_query($dbh, $query);
$row = mysqli_fetch_array($result);
if($row['email'] == $user_email)
echo EncryptString("found");
else
echo EncryptString("not_found");
}
else if($method_req == "mspl")
{
 $sql = "UPDATE admin_data SET password = '%s' WHERE login = '%s'";
 $query = sprintf($sql, mysqli_real_escape_string($dbh, $user_password), mysqli_real_escape_string($dbh, $user_login));
 if (mysqli_query($dbh, $query)) 
     echo EncryptString("succses");
 else 
    echo EncryptString("fail");
}
else if($method_req == "mspe")
{
 $sql = "UPDATE admin_data SET password = '%s' WHERE email = '%s'";
 $query = sprintf($sql, mysqli_real_escape_string($dbh, $user_password), mysqli_real_escape_string($dbh, $user_email));
 if (mysqli_query($dbh, $query)) 
     echo EncryptString("succses");
 else 
    echo EncryptString("fail");
}

// Закрываем соединение
mysqli_close($dbh);
?>