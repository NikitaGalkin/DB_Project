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
$item_shopl = isset($data['itmshpid']) ? DecryptString($data['itmshpid']) : "";
$item_name = isset($data['itmnm']) ? DecryptString($data['itmnm']) : "";
$item_code = isset($data['itmcd']) ? DecryptString($data['itmcd']) : "";
$item_price = isset($data['itmpr']) ? DecryptString($data['itmpr']) : "";
$item_inst = isset($data['itminst']) ? DecryptString($data['itminst']) : "";
$item_status = isset($data['itmsts']) ? DecryptString($data['itmsts']) : "";
$item_key = isset($data['itmk']) ? DecryptString($data['itmk']) : "";
$shop_promo = isset($data['spromo']) ? DecryptString($data['spromo']) : "";
$shop_promoper = isset($data['spromoper']) ? DecryptString($data['spromoper']) : "";
$shop_promod = isset($data['spromod']) ? DecryptString($data['spromod']) : "";

if($method_req == "setitm")
{
    $sql = "SELECT shopid, item_code FROM item_data WHERE item_code = '%s'";
    $query = sprintf($sql, mysqli_real_escape_string($dbh, $item_code));
	$result = mysqli_query($dbh, $query);
    $row = mysqli_fetch_array($result);
    if($row['item_code'] == $item_code && $row['shopid'] == $item_shopl)
    echo EncryptString("itm_full");
    else
    {
        $sql = "INSERT INTO item_data (shopid, item_name, item_code, item_price, item_inst, item_status) VALUES ('%s', '%s', '%s', '%s', '%s', '1')";
       $query = sprintf($sql, mysqli_real_escape_string($dbh, $item_shopl)
       , mysqli_real_escape_string($dbh, $item_name)
       , mysqli_real_escape_string($dbh, $item_code)
       , mysqli_real_escape_string($dbh, $item_price)
       , mysqli_real_escape_string($dbh, $item_inst));
       $result = mysqli_query($dbh, $query);
        if ($result) 
        echo EncryptString("succses");
        else 
        echo EncryptString("fail");
    }
}
else if($method_req == "upditm")
{
    $sql = "UPDATE item_data SET item_name = '%s', item_price = '%s', item_inst = '%s', item_status = '%d' WHERE item_code = '%s' and shopid = '%'";
   $query = sprintf($sql, mysqli_real_escape_string($dbh, $item_name)
       , mysqli_real_escape_string($dbh, $item_price)
       , mysqli_real_escape_string($dbh, $item_inst)
       , mysqli_real_escape_string($dbh, $item_status)
       , mysqli_real_escape_string($dbh, $item_code)
        , mysqli_real_escape_string($dbh, $item_shopl));
    if (mysqli_query($dbh, $query)) 
    echo EncryptString("succses");
    else 
    echo EncryptString("fail");
}
else if($method_req == "getitm")
{
    $sql = "SELECT shopid, item_name, item_code, item_price, item_inst, item_status FROM item_data WHERE shopid = '%s'";
    $query = sprintf($sql, mysqli_real_escape_string($dbh, $item_shopl));
	$result = mysqli_query($dbh, $query);
    $row = mysqli_fetch_array($result);
    echo EncryptString($row['item_name'].":".$row['item_code'].":".$row['item_price'].":".$row['item_inst'].":".$row['item_status']."\n");
    while ($row = mysqli_fetch_array($result)) 
    {
        echo EncryptString($row['item_name'].":".$row['item_code'].":".$row['item_price'].":".$row['item_inst'].":".$row['item_status']."\n");
    }
}
else if($method_req == "setk")
{
    $sql = "SELECT shopid, item_code, item_key FROM keys_data WHERE item_key = '%s'";
    $query = sprintf($sql, mysqli_real_escape_string($dbh, $item_key));
	$result = mysqli_query($dbh, $query);
    $row = mysqli_fetch_array($result);
    if($row['item_code'] == $item_code && $row['shopid'] == $item_shopl && $row['item_key'] == $item_key )
    echo EncryptString("key_full");
    else
    {
        $sql = "INSERT INTO keys_data (shopid, item_code, item_key) VALUES ('%s', '%s', '%s')";
         $query = sprintf($sql, mysqli_real_escape_string($dbh, $item_shopl)
         , mysqli_real_escape_string($dbh, $item_code)
         , mysqli_real_escape_string($dbh, $item_key));
         $result = mysqli_query($dbh, $query);
        if ($result) 
        echo EncryptString("succses");
        else 
        echo EncryptString("fail");
    }
}
else if($method_req == "delk")
{
    $sql = "DELETE FROM keys_data WHERE item_code = '%s' and shopid = '%s' and item_key = '%s'";
     $query = sprintf($sql, mysqli_real_escape_string($dbh, $item_code)
         , mysqli_real_escape_string($dbh, $item_shopl)
         , mysqli_real_escape_string($dbh, $item_key));
         $result = mysqli_query($dbh, $query);
        if ($result) 
    echo EncryptString("succses");
        else 
        echo EncryptString("fail");
}
else if($method_req == "getitmk")
{
    $sql = "SELECT shopid, item_code, item_key FROM keys_data WHERE shopid = '%s' and item_code = '%s'";
    $query = sprintf($sql, mysqli_real_escape_string($dbh, $item_shopl)
    , mysqli_real_escape_string($dbh, $item_shopl));
	$result = mysqli_query($dbh, $query);
    $row = mysqli_fetch_array($result);
    echo EncryptString($row['item_key']."\n");
    while ($row = mysqli_fetch_array($result)) 
    {
        echo EncryptString($row['item_key']."\n");
    }
}
else if($method_req == "getitmsel")
{
    $sql = "SELECT shopid, item_code, item_price, item_seller, item_percent, sell_data FROM sell_data WHERE shopid = '%s' and item_code = '%s'";
    $query = sprintf($sql, mysqli_real_escape_string($dbh, $item_shopl)
    , mysqli_real_escape_string($dbh, $item_code));
	$result = mysqli_query($dbh, $query);
    $row = mysqli_fetch_array($result);
    echo EncryptString($row['item_price'].":".$row['item_seller'].":".$row['item_percent'].":".$row['sell_data']."\n");
    while ($row = mysqli_fetch_array($result)) 
    {
        echo EncryptString($row['item_price'].":".$row['item_seller'].":".$row['item_percent'].":".$row['sell_data']."\n");
    }
}
else if($method_req == "getprm")
{
    $sql = "SELECT shopid, promo_data, percent_data, promo_expired FROM promo_data WHERE shopid = '%s'";
    $query = sprintf($sql, mysqli_real_escape_string($dbh, $item_shopl));
	$result = mysqli_query($dbh, $query);
    $row = mysqli_fetch_array($result);
    echo EncryptString($row['promo_data'].":".$row['percent_data'].":".$row['promo_expired']."\n");
    while ($row = mysqli_fetch_array($result)) 
    {
        echo EncryptString($row['promo_data'].":".$row['percent_data'].":".$row['promo_expired']."\n");
    }
}
else if($method_req == "updprm")
{
    $sql = "UPDATE promo_data SET promo_data = '%s', percent_data = '%s', promo_expired = '%s' WHERE promo_data = '%s' and shopid = '%s'";
   $query = sprintf($sql, mysqli_real_escape_string($dbh, $shop_promo)
   , mysqli_real_escape_string($dbh, $shop_promoper)
   , mysqli_real_escape_string($dbh, $shop_promod)
   , mysqli_real_escape_string($dbh, $item_shopl));
	$result = mysqli_query($dbh, $query);
    if ($result) 
    echo EncryptString("succses");
    else 
    echo EncryptString("fail");
}
else if($method_req == "addprm")
{
    $sql = "INSERT INTO promo_data (shopid, promo_data, percent_data, promo_expired) VALUES ('%s', '%s', '%s', '%s')";
    $query = sprintf($sql, mysqli_real_escape_string($dbh, $item_shopl)
   , mysqli_real_escape_string($dbh, $shop_promo)
   , mysqli_real_escape_string($dbh, $shop_promoper)
   , mysqli_real_escape_string($dbh, $shop_promod));
	$result = mysqli_query($dbh, $query);
    if ($result) 
    echo EncryptString("succses");
    else 
    echo EncryptString("fail");
}
else if($method_req == "delprm")
{
    $sql = "DELETE FROM promo_data WHERE promo_data = '%s' and shopid = '%s'";
    $query = sprintf($sql, mysqli_real_escape_string($dbh, $shop_promo)
    , mysqli_real_escape_string($dbh, $item_shopl));
	$result = mysqli_query($dbh, $query);
    if ($result)
    echo EncryptString("succses");
    else 
    echo EncryptString("fail");
}
// Закрываем соединение
mysqli_close($dbh);
?>