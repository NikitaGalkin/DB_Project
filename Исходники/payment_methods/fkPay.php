<?php
define('IN_PAGE', TRUE);
include '../app_lib/db_connect.php';

  $m_fields = $_GET['fields'];
  $shop_id;
  $item_code;
  list($shop_id, $item_code) = explode(':', $m_fields);

  $sql = "SELECT freekey, fk_id FROM shop_data WHERE shopid = '%s'";
  $query = sprintf($sql, mysqli_real_escape_string($dbh, $shop_id));
  $result = mysqli_query($dbh, $query);
  $row = mysqli_fetch_array($result);
  
  $m_shopid = $row['fk_id'];
  $m_key =  $row['freekey'];

  $m_orderid = rand()+time();
  
  $m_amount = $_GET['amount'];
  $m_reffer = $_GET['reffer'];
  $m_email = $_GET['email'];

  $m_sign = md5($m_shopid.':'.$m_amount.':'.$m_key.':'.$m_orderid); 
  $link = 'https://www.free-kassa.ru/merchant/cash.php?m='.$m_shopid;

header('Location: '.$link.
 '&oa='.$m_amount.
 '&o='.$m_orderid.
 '&em='.$m_email.
 '&us_desc='.$m_fields.
 '&us_reffer='.$m_reffer.
 '&s='.$m_sign);
?>
