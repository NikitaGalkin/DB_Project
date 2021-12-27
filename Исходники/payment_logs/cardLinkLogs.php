<?php
define('IN_PAGE', TRUE);
include '../app_lib/db_connect.php';

$g_status = $_POST['Status'];
$g_tran = $_POST['TrsId'];
$g_ammout= $_POST['OutSum'];
$m_fields  = $_POST['custom'];
$shop_id;
$item_code;
$g_email;
$g_reffer;

list($shop_id, $item_code, $g_email, $g_reffer) = explode(':',$m_fields);

//парсим с БД название товара, цену и статус
$sql = "SELECT item_name FROM item_data WHERE shopid = '%s' and item_code = '%s'";
$query = sprintf($sql, mysqli_real_escape_string($dbh, $shop_id)
, mysqli_real_escape_string($dbh, $item_code));
$result = mysqli_query($dbh, $query);
$row = mysqli_fetch_array($result);
$item_name = $row['item_name'];

//Парсим ссылку магазина
$sql = "SELECT shoplink FROM admin_data WHERE shopid = '%s'";
$query = sprintf($sql, mysqli_real_escape_string($dbh, $shop_id));
$result = mysqli_query($dbh, $query);
$row = mysqli_fetch_array($result);
$g_domain = $row['shoplink'];
$g_key;

if($g_status == "SUCCESS")
{
    if($g_ammout && $item_name)
    {
     //Подключаемся к БД
    $sql = "SELECT item_key FROM keys_data WHERE shopid = '%s' and item_code = '%s'";
    $query = sprintf($sql, mysqli_real_escape_string($dbh, $shop_id)
    , mysqli_real_escape_string($dbh, $item_code));
	$result = mysqli_query($dbh, $query);
    $row = mysqli_fetch_array($result);
    $g_key = $row['item_key'];

    $sql = "INSERT INTO sell_data (shopid, item_code, item_price, item_seller, item_percent, sell_data) VALUES ('".$shop_id."', '".$item_code."', '".$g_ammout."', '".$g_reffer."', 'none', '".date("d.m.y")."' )";
    $status = mysqli_query($dbh, $sql);
     
    //Отправка письма 
    send_item_email($g_email, $item_code, $shop_id, $g_key, $g_domain);

     //текст телеграмма
    $message = "<b>👑[Any Logs]</b>\n🎯Номер транзакции: ".
    $g_tran."\n✉️E-mail: ".$g_email."\n💵Сумма: "
    .$g_ammout." ₽\n".
    "🔑Выданный ключ: ".$g_key.
    "\n📤Код товара: ".$item_code.
    "\n🎯Имя товара: ".$item_name.
    "\n👨Продавец: ".$g_reffer.
    "\n📤Ссылка на товар: https://npanel.ru/CourseWork/order.php?email="
      	.$g_email."&item_code=".$g_item."&item_key=".$g_key."&shop_id=".$shop_id;
    
    $sql = "SELECT bottoken, tgchatid FROM shop_data WHERE shopid = '$shop_id'";
    $result = mysqli_query($dbh, $sql);
    $row = mysqli_fetch_array($result);

    //отправка сообщений
    send_telegram_message($message, $row['tgchatid'],$row['bottoken']);
    
    //Удалить ключ
    $sql = mysqli_query($dbh, "DELETE FROM keys_data WHERE item_key = '$g_key'");
    
    // Возвращаем, что платеж был успешно обработан
   die("OK");
   
   //закрыть соеденение
   $result->close();
   mysqli_close($dbh);
}
}
?>