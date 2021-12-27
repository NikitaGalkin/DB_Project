<?php
define('IN_PAGE', TRUE);
include '../app_lib/db_connect.php';

//Static
$m_fields = $_GET['fields'];
$shop_id;
$item_code;
list($shop_id, $item_code) = explode(':', $m_fields);

$sql = "SELECT cardkey, card_id FROM shop_data WHERE shopid = '%s'";
$query = sprintf($sql, mysqli_real_escape_string($dbh, $shop_id));
$result = mysqli_query($dbh, $query);
$row = mysqli_fetch_array($result);
  
$m_shopid = $row['card_id'];
$m_key =  $row['cardkey'];

$m_curr = 'RUB';
$m_orderid = rand(1000, 9999)+time();

//Dinamic
$m_reffer = $_GET['reffer'];
$m_ammount = $_GET['amount'];
$m_email = $_GET['email'];

$postdata = http_build_query([
    'amount' => $m_ammount,
    'description=' => $m_fields,
    'order_id=' => $m_orderid,
    'type' => 'normal',
    'shop_id' => $m_shopid,
    'name' => $m_reffer,
    'custom' => $m_fields.':'.$m_email.':'.$m_reffer,
    'currency_in' => $m_curr,
    'currency_out' => $m_curr,
]);

$opts = [
    'http' =>
        [
            'method' => 'POST',
            'header' => [
                'Content-type: application/x-www-form-urlencoded',
                'Authorization: Bearer ' . $m_key
            ],
            'content' => $postdata
        ]
];

$result = file_get_contents('https://cardlink.link/api/v1/bill/create', false, stream_context_create($opts));
$object = json_decode($result, true);
header('Location: ' . $object['link_page_url']);
?>