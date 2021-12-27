<?php
define('IN_PAGE', TRUE);
include 'app_lib/db_connect.php';

mysqli_set_charset($dbh, 'utf8');

$item_key = $_GET['item_key'];
$shop_id = $_GET['shop_id'];
$shop_item_code = $_GET['item_code'];
$email = $_GET['email'];

//парсим с БД название товара, цену и статус
$sql = "SELECT item_name, item_price, item_status, item_inst FROM item_data WHERE shopid = '%s' and item_code = '%s'";
$query = sprintf($sql, mysqli_real_escape_string($dbh, $shop_id), mysqli_real_escape_string($dbh, $shop_item_code));
$result = mysqli_query($dbh, $query);
$row = mysqli_fetch_array($result);
$item_status = $row['item_status'];
$item_name = $item_status == 1 ? $row['item_name'] : $row['item_name']." - продажи выключены!";
$item_inst = $row['item_inst'];

//Выгружаем лого
$sql = "SELECT imagelink FROM shop_data WHERE shopid = '%s'";
$query = sprintf($sql, mysqli_real_escape_string($dbh, $shop_id));
$result = mysqli_query($dbh, $query);
$row = mysqli_fetch_array($result);
$shop_photo = $row['imagelink'] != "" ? $row['imagelink'] : "def_logo.png";

//Парсим ссылку магазина
$sql = "SELECT shoplink FROM admin_data WHERE shopid = '%s'";
$query = sprintf($sql, mysqli_real_escape_string($dbh, $shop_id));
$result = mysqli_query($dbh, $query);
$row = mysqli_fetch_array($result);
$shop_link = $row['shoplink'];
?>


<html>

<head>
<title>Order - <?=$shop_link?> Payment Service</title>
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
	font-size:10pt;
	}
	
	.buy-btn:focus{
	border: 0;
	outline:0;
	}
	
	
	a.buy-btn {
    text-decoration: none;
    color: white;
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
	margin-bottom: 10px;
	margin-top: 10px;
}


.tg  {border-collapse:collapse;border-spacing:0;}
.tg td{border-color: black;
    font-family: Arial, sans-serif;
    font-size: 14px;
    overflow: hidden;
    color: white;
    border: 1px solid #334573;
    text-align: center;
    padding: 10px 5px;
    border-left: none;
    word-break: normal;
    border-right: none;}
.tg th{border-color:black;color:#ffffff;text-align: center;font-family:Arial, sans-serif;font-size:14px;
  font-weight:normal;overflow:hidden;padding:10px 5px;word-break:normal;}
.tg .tg-mk6l{border-color:#000000;color:#ffffff;text-align:left;vertical-align:top}
.tg .tg-hfk9{border-color:#000000;text-align:left;vertical-align:top}
</style>
<body>
<div style="margin: 0 auto;text-align: center;"><img src="pict/<?=$shop_photo?>" alt="<?=$shop_link?>" style="
    width: 200px;
    margin-top: 2em;
    margin-bottom: 2em;
"></div>
    
    <div class="box1">
	
	<div class="info">
		
<table class="tg" style="width: -webkit-fill-available;">
<colgroup>
<col style="width: 320px">
<col style="width: 326px">
</colgroup>

<thead>
  <tr>
    <th class="tg-ntt9">Имя товара</th>
    <th class="tg-ntt9">Ключ товара</th>
  </tr>
</thead>
<tbody>
  <tr>
    <td class="tg-zv4m"><?=$item_name?></td>
    <td class="tg-zv4m"><?=$item_key?></td>
  </tr>
</tbody>
</table>
	</div>
	
	<div style="background-color: #178e14;
    background: linear-gradient( 
45deg
 ,rgb(42 165 40) 0%,rgb(11 128 58) 100%);
    border-radius: 15px;
    text-shadow: 0 0 3px black;
    padding: 5px 9px;
    float: right;
    font-size: 10pt;
    margin-top: -129px;
    color: #fff;
    margin-right: -1px;"><img src="data:image/svg+xml;base64,PD94bWwgdmVyc2lvbj0iMS4wIiA/PjwhRE9DVFlQRSBzdmcgIFBVQkxJQyAnLS8vVzNDLy9EVEQgU1ZHIDEuMS8vRU4nICAnaHR0cDovL3d3dy53My5vcmcvR3JhcGhpY3MvU1ZHLzEuMS9EVEQvc3ZnMTEuZHRkJz48c3ZnIGVuYWJsZS1iYWNrZ3JvdW5kPSJuZXcgMCAwIDMyIDMyIiB2ZXJzaW9uPSIxLjEiIHZpZXdCb3g9IjAgMCAzMiAzMiIgeG1sOnNwYWNlPSJwcmVzZXJ2ZSIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIiB4bWxuczp4bGluaz0iaHR0cDovL3d3dy53My5vcmcvMTk5OS94bGluayI+PGcgaWQ9IkxheWVyXzEiLz48ZyBpZD0iTGF5ZXJfMiI+PGc+PGxpbmUgZmlsbD0ibm9uZSIgc3Ryb2tlPSIjMDAwMDAwIiBzdHJva2UtbGluZWNhcD0icm91bmQiIHN0cm9rZS1saW5lam9pbj0icm91bmQiIHN0cm9rZS1taXRlcmxpbWl0PSIxMCIgc3Ryb2tlLXdpZHRoPSIyIiB4MT0iMTYiIHgyPSIxNiIgeTE9IjEwIiB5Mj0iMTIiLz48bGluZSBmaWxsPSJub25lIiBzdHJva2U9IiMwMDAwMDAiIHN0cm9rZS1saW5lY2FwPSJyb3VuZCIgc3Ryb2tlLWxpbmVqb2luPSJyb3VuZCIgc3Ryb2tlLW1pdGVybGltaXQ9IjEwIiBzdHJva2Utd2lkdGg9IjIiIHgxPSIxNiIgeDI9IjE2IiB5MT0iMjAiIHkyPSIyMiIvPjxwYXRoIGQ9IiAgICBNMTQsMjBoM2MxLjEsMCwyLTAuOSwyLTJzLTAuOS0yLTItMmgtMmMtMS4xLDAtMi0wLjktMi0yczAuOS0yLDItMmgzIiBmaWxsPSJub25lIiBzdHJva2U9IiMwMDAwMDAiIHN0cm9rZS1saW5lY2FwPSJyb3VuZCIgc3Ryb2tlLWxpbmVqb2luPSJyb3VuZCIgc3Ryb2tlLW1pdGVybGltaXQ9IjEwIiBzdHJva2Utd2lkdGg9IjIiLz48cGF0aCBkPSIgICAgTTE2LDZjNS41LDAsMTAsNC41LDEwLDEwcy00LjUsMTAtMTAsMTBTNiwyMS41LDYsMTZ2LTMiIGZpbGw9Im5vbmUiIHN0cm9rZT0iIzAwMDAwMCIgc3Ryb2tlLWxpbmVjYXA9InJvdW5kIiBzdHJva2UtbGluZWpvaW49InJvdW5kIiBzdHJva2UtbWl0ZXJsaW1pdD0iMTAiIHN0cm9rZS13aWR0aD0iMiIvPjxwb2x5bGluZSBmaWxsPSJub25lIiBwb2ludHM9IiAgICAxMCwxNyA2LDEzIDIsMTcgICAiIHN0cm9rZT0iIzAwMDAwMCIgc3Ryb2tlLWxpbmVjYXA9InJvdW5kIiBzdHJva2UtbGluZWpvaW49InJvdW5kIiBzdHJva2UtbWl0ZXJsaW1pdD0iMTAiIHN0cm9rZS13aWR0aD0iMiIvPjxwYXRoIGQ9IiAgICBNMTYsMmM3LjcsMCwxNCw2LjMsMTQsMTRzLTYuMywxNC0xNCwxNCIgZmlsbD0ibm9uZSIgc3Ryb2tlPSIjMDAwMDAwIiBzdHJva2UtbGluZWNhcD0icm91bmQiIHN0cm9rZS1saW5lam9pbj0icm91bmQiIHN0cm9rZS1taXRlcmxpbWl0PSIxMCIgc3Ryb2tlLXdpZHRoPSIyIi8+PC9nPjwvZz48L3N2Zz4=" style="    width: 20px;
    padding: 2px;
    margin-right: 4px;
    filter: invert(1);">оплачено</div>	
	
		<div style="background-color: #0b1b3d;
    background: linear-gradient( 
45deg
 ,rgb(35 72 152) 0%,rgb(23 28 99) 100%);
    border-radius: 15px;
    text-shadow: 0 0 3px black;
    padding: 5px 9px;
    float: left;
    font-size: 10pt;
    margin-top: -129px;
    color: #fff;"><img src="data:image/svg+xml;base64,PD94bWwgdmVyc2lvbj0iMS4wIiA/PjxzdmcgZGF0YS1uYW1lPSJMaXZlbGxvIDEiIGlkPSJMaXZlbGxvXzEiIHZpZXdCb3g9IjAgMCAxMjggMTI4IiB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciPjx0aXRsZS8+PHBhdGggZD0iTTExNi43MywzMS44M2EzLDMsMCwwLDAtNC4yLS42MUw2NC4xNCw2Ny4zNGExLDEsMCwwLDEtMS4yLDBMMTUuNSwzMS4wNmEzLDMsMCwxLDAtMy42NCw0Ljc3TDQ5LjE2LDY0LjM2LDEyLjI3LDkyLjE2QTMsMywwLDEsMCwxNS44OCw5N0w1NC4xMSw2OC4xNGw1LjE4LDRhNyw3LDAsMCwwLDguNDMuMDZsNS40NC00LjA2TDExMS44NCw5N2EzLDMsMCwxLDAsMy41OS00LjgxTDc4LjE3LDY0LjM1LDExNi4xMiwzNkEzLDMsMCwwLDAsMTE2LjczLDMxLjgzWiIvPjxwYXRoIGQ9Ik0xMTMsMTlIMTVBMTUsMTUsMCwwLDAsMCwzNFY5NGExNSwxNSwwLDAsMCwxNSwxNWg5OGExNSwxNSwwLDAsMCwxNS0xNVYzNEExNSwxNSwwLDAsMCwxMTMsMTlabTksNzVhOSw5LDAsMCwxLTksOUgxNWE5LDksMCwwLDEtOS05VjM0YTksOSwwLDAsMSw5LTloOThhOSw5LDAsMCwxLDksOVoiLz48L3N2Zz4=" style="    width: 20px;
    padding: 2px;
    margin-right: 4px;
    filter: invert(1);"><?=$email?></div>	
	
	
	
<p style="font-size: 11pt;
    font-weight: 600;
    padding: 16px;margin-bottom: 0;
    text-align:left;">
	
	<span style="color:red;">Инструкция</span><br/>
<?=$item_inst?>
</p>
    
<hr>

<p style="font-size: 9pt;font-weight: 600;"><a href="https://<?=$shop_link?>" style="color: #122149;" target="_blank"/><?=$shop_link?></a> LLC 2021</p>
	
	</div>
</body></html>