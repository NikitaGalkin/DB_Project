<?php
define('IN_PAGE', TRUE);
include '../app_lib/db_connect.php';

  $m_fields = $_GET['fields'];
  $m_orderid = time();
  $m_amount = $_GET['amount'];
  $m_reffer = $_GET['reffer'];
  $m_email = $_GET['email'];
  $m_curr = 'RUB';
  $success_url = '';
  $fail_url = '';
  $shop_id;
  $item_code;
  list($shop_id, $item_code) = explode(':', $m_fields);
  
  $sql = "SELECT anykey, any_id FROM shop_data WHERE shopid = '%s'";
  $query = sprintf($sql, mysqli_real_escape_string($dbh, $shop_id));
  $result = mysqli_query($dbh, $query);
  $row = mysqli_fetch_array($result);
  
  $m_shopid = $row['any_id'];
  $m_key =  $row['anykey'];

  
  $arr_sign = array( 
    $m_shopid, 
    $m_orderid,
    $m_amount, 
    $m_curr, 
    $m_fields, 
    $success_url,
    $fail_url,
    $m_key
  );

  $m_sign = hash('sha256', implode(':', $arr_sign)); 
?>

<form id="foobar" action='https://anypay.io/merchant' accept-charset='utf-8' method='post'>
  <input type='hidden' name='merchant_id' value='<?=$m_shopid; ?>'>
  <input type='hidden' name='amount' value='<?=$m_amount; ?>'>
  <input type='hidden' name='currency' value='<?=$m_curr; ?>'>
  <input type='hidden' name='pay_id' value='<?=$m_orderid; ?>'>
  <input type='hidden' name='desc' value='<?=$m_fields; ?>'>
  <input type='hidden' name='reffer' value='<?=$m_reffer?>'>
  <input type='hidden' name='email' value='<?=$m_email; ?>'>
  <input type='hidden' name='sign' value='<?=$m_sign; ?>'>
 </form>
 
 <script>
setTimeout(function () {
    document.getElementById('foobar').submit();
}, 5);
</script>