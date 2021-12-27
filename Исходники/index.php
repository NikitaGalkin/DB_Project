<?php
define('IN_PAGE', TRUE);
include 'app_lib/db_connect.php';
mysqli_set_charset($dbh, 'utf8');
//получаем данные с сгенирированной ссылки
$shop_id = isset($_GET['shop_id']) ? DecryptString($_GET['shop_id']) : "";
$shop_item_code = isset($_GET['item_code']) ? DecryptString($_GET['item_code']) : "";

if(isset($_GET['shop_id']) && isset($_GET['item_code']))
{
//парсим с БД название товара, цену и статус
$sql = "SELECT item_name, item_price, item_status FROM item_data WHERE shopid = '%s' and item_code = '%s'";
$query = sprintf($sql, mysqli_real_escape_string($dbh, $shop_id)
, mysqli_real_escape_string($dbh, $shop_item_code));
$result = mysqli_query($dbh, $query);
$row = mysqli_fetch_array($result);
$item_price = $row['item_price'];
$item_status = $row['item_status'];
$item_name = $item_status == 1 ? $row['item_name'] : "Продажи выключены!";


//Парсим ссылку магазина
$sql = "SELECT shoplink FROM admin_data WHERE shopid = '%s'";
$query = sprintf($sql, mysqli_real_escape_string($dbh, $shop_id));
$result = mysqli_query($dbh, $query);
$row = mysqli_fetch_array($result);
$shop_link = $row['shoplink'];
$shop_reffer = isset($_GET['reffer']) ? $_GET['reffer'] : $shop_link;

$sql = "SELECT imagelink FROM shop_data WHERE shopid = '%s'";
$query = sprintf($sql, mysqli_real_escape_string($dbh, $shop_id));
$result = mysqli_query($dbh, $query);
$row = mysqli_fetch_array($result);
$shop_photo = $row['imagelink'] != "" ? $row['imagelink'] : "def_logo.png";

 if( isset( $_POST['nazvanie_knopki'] ) )
 {
    if($item_price != "" && $item_status == 1)
    {
        $pay_link = "https://npanel.ru/CourseWork/payment_methods/";
        $pay_n = $_POST['mlist'];
        $get_promo = $_POST['promo'];
        
        $sql = "SELECT percent_data FROM promo_data WHERE shopid = '%s' and promo_data = '%s'";
        $query = sprintf($sql, mysqli_real_escape_string($dbh, $shop_id)
        , mysqli_real_escape_string($dbh, $get_promo));
        $result = mysqli_query($dbh, $query);
        $row = mysqli_fetch_array($result);
        $item_price = $item_price - ($item_price*$row['percent_data']/100);
        
        if($pay_n == 0)
        $pay_link = $pay_link.'anyPay.php?amount=';
        if($pay_n == 1)
        $pay_link = $pay_link.'fkPay.php?amount=';
        if($pay_n == 2)
        $pay_link = $pay_link.'cardLink.php?amount=';
        
        $pay_link = $pay_link.$item_price."&fields=".$shop_id.":".$shop_item_code."&reffer=".$shop_reffer."&email=".$_POST['email'];;
        header('Location: '.$pay_link);
    }
    else
    $item_name = "Продажи выключены!";
 }
}
else
{
    $item_name = "Пустые данные!";
    $shop_reffer = "Пустые данные!";
    $item_price  = "Пустые данные!";
}

?>

<html>

<head>
<title><?=$shop_link?> Payment Service</title>
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</head>

<style>
body {
background: #081e5d;
    background: radial-gradient(circle,rgb(22 42 97) 30%,rgb(5 18 41) 100%);
    font-family: sans-serif;
    max-width: 600px;
    margin: 0 auto;
}

.buy-btn {
background-color: #122149;
    border: 0;
    border-radius: 14px;
    padding: 8px 13px;
    color: white;
    margin: 10px;
	}
	
	.buy-btn:focus{
	border: 0;
	outline:0;
	}
	
	.buy-btn:hover {
	cursor:pointer;
	background-color: #122149;
	background: linear-gradient( 
45deg
 ,rgb(8 22 52) 0%,rgb(18 46 121) 100%);
	}
	
	.form-control {
	border-radius: 7px;
    border: 1px solid #122149;
    font-size: 13pt;
    margin: 5px;
    box-sizing: border-box;
	width: 65%;
	margin: 0 auto;
    padding: 6px;
    background: #eaeaea;
	}
	
	.form-control:focus{
	outline: 0;
    box-sizing: border-box;
	background: #fff;
	border-color:#061058;
	}
	
	.box1{
	background-color: #e9e9e9;padding: 7px 24px;text-align: center;width: fit-content;border-radius: 21px;margin: 0 auto;
	}
	
	.card-header {
    background-color: #333333;
}

button.btn.btn-link {
    color: white;
}

.info {
background-color: #0b1b3e;
    background: linear-gradient(
45deg
,rgb(8 22 52) 0%,rgb(22 42 96) 100%);
    border-radius: 5px;
    border: 1px solid #071531;
    font-family: sans-serif;
    font-size: 10pt;
    text-align: left;
    padding: 5px 17px;
    color: white;
    text-shadow: 0 0 3px #060606;
	margin-bottom: 20px;
}
</style>
<body>
<div style="margin: 0 auto;text-align: center;"><img src="pict/<?=$shop_photo != "" ? $shop_photo : "def_logo.png"  ?>" alt="<?=$shop_link?>" style="
    width: 200px;
    margin-top: 2em;
    margin-bottom: 2em;
"></div>
    
    <div class="box1">
<p style="font-size: 11pt;
    font-weight: 600;
    padding: 16px;margin-bottom: 0;">Вам необходимо ввести email и произвести оплату. Ключ и инструкции придут вам на почту. Внимание письмо может придти в папку <span style="color:red">СПАМ</span></p>
    
	
	<div class="info">Продавец: <?=$shop_reffer?> <br/> Сумма: <?=$item_price?> RUB<br/>
	</div>
	
<form id="foobar" method="POST">
<label class="form-label" >Выбранный вами продукт:</label>
</br>
<input class="form-control" type="text" value='<?=$item_name?>' style="text-align: center;" required readonly>
</br>
<label class="form-label" for="text">Выберите платежный шлюз для оплаты:</label>
</br>
<select class="form-control" style="text-align-last:center;" name="mlist">
    <option value = "0">AnyPay</option>
    <option value = "1">FreeKassa</option>
    <option value = "2">CardLink</option>
 </select>
 </br>
<label class="form-label" for="footer-subscribel-email">Введите свой email:</label>
</br>
<input class="form-control"type="email" name="email" required>
</br>
<label class="form-label" for="footer-subscribel-email">Введите промокод скидки:</label>
</br>
<input class="form-control"type="text" name="promo" required>
</br>
<button class="buy-btn" name="nazvanie_knopki" type="submit">Оплатить</button>
</form>

<hr>

<p style="font-size: 9pt;font-weight: 600;"><a href="https://<?=$shop_link?>" style="color: #122149;" target="_blank"/><?=$shop_link?></a> LLC 2021</p>
	
	</div>
</body></html>

