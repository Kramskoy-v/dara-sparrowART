<?php
// Файлы phpmailer
require 'phpmailer/PHPMailer.php';
require 'phpmailer/SMTP.php';
require 'phpmailer/Exception.php';

// Переменные, которые отправляет пользователь
$name = $_POST['username'];
$email = $_POST['useremail'];
$textarea = $_POST['usertext'];

// Формирование самого письма
$title = "Обращение с сайта Dara Sparrow art";
$body = "
<h2>Новое Обращение с сайта Dara Sparrow art</h2>
<b>Имя:</b> $name<br>
<b>Электронная почта:</b> $email<br><br>
<b>Текст обращения:</b> $textarea<br>";

// Настройки PHPMailer
$mail = new PHPMailer\PHPMailer\PHPMailer();
try {
    $mail->isSMTP();   
    $mail->CharSet = "UTF-8";
    $mail->SMTPAuth   = true;
    //$mail->SMTPDebug = 2;
    $mail->Debugoutput = function($str, $level) {$GLOBALS['status'][] = $str;};

    // Настройки вашей почты
    $mail->Host       = 'smtp.mail.ru'; // SMTP сервера вашей почты
    $mail->Username   = 'kramskoy_va@mail.ru'; // Логин на почте
    $mail->Password   = '******'; // Пароль на почте
    $mail->SMTPSecure = 'ssl';
    $mail->Port       = 465;
    $mail->setFrom('kramskoy_va@mail.ru', 'Сайт Dara Sparrow'); // Адрес самой почты и имя отправителя

    // Получатель письма
    $mail->addAddress('example@gmail.com');  
    //$mail->addAddress('');

// Отправка сообщения
$mail->isHTML(true);
$mail->Subject = $title;
$mail->Body = $body;    

// Проверяем отравленность сообщения
if ($mail->send()) {$result = "success";} 
else {$result = "error";}

} catch (Exception $e) {
    $result = "error";
    $status = "Сообщение не было отправлено. Причина ошибки: {$mail->ErrorInfo}";
}

// Отображение результата
echo json_encode(["result" => $result, "resultfile" => $rfile, "status" => $status]);
