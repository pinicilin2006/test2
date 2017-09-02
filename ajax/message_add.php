<?php
require_once('../function.php');
// echo '<pre>';
// print_r($_POST);
// echo '</pre>';
//echo 'success';
foreach($_POST as $key => $val){
	$$key = htmlspecialchars($val, ENT_XML1);
	//echo $key."<br>";
}
$result = '';
//Проверка данных
if(!$user_name)
{
	$err[]='Не указано имя пользователя';
}

if(!$user_message)
{
	$err[] = 'Отсутствует текст сообщения';
}

$xml = simplexml_load_file($_SERVER['DOCUMENT_ROOT'].'/data.xml');
$time_last_message = $xml->last_message;
if((time() - $time_last_message) < 10)
{
	$err[] = 'Допускается отправка сообщения не чаще чем раз в 10 секунд';
}
if(isset($err))
{
	$result = '<ul class="list-unstyled">';
	foreach ($err as $val) {
		$result .= '<li class="text-danger">Ошибка! '.$val.'</li>';
	}
	$result .= '</ul>';
	echo $result;
	exit();
}
if(!isset($parent)){
	$parent = false;
}
if(add_message($user_name, $user_message))
{
	echo 'success';
} else {
	echo 'Произошла ошибка при сохранение данных в файл базы данных';
}
?>