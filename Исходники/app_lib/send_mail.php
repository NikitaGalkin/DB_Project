<?php

$g_email = $_POST['email'];
$r_code = $_POST['rcode'];

$headers = 'From: Reset@reset.ru'. "\r\n" .
'Reply-To: info@Reset'. "\r\n" .
'X-Mailer: PHP/' . phpversion();

$message = "Приветсвую тебя дорогой Администратор!\n\nКод восстановление:\n".$r_code;
mail($g_email, 'Востановления пароля', $message, $headers);
?>