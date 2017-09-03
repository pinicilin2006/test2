<?php
require_once('../function.php');
foreach($_POST as $key => $val){
	$$key = htmlspecialchars(strip_tags($val), ENT_XML1);
}
$result = '';
//Проверка данных
if(!$id_message || !is_numeric($id_message))
{
	$err[]='Не указано ID сообщения или оно имеет недопустимый формат';
}

if(!$edit_user_message)
{
	$err[] = 'Отсутствует текст сообщения';
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

if(edit_message($id_message, $edit_user_message))
{
	echo 'success';
} else {
	echo 'Произошла ошибка при сохранение данных в файл базы данных';
}
?>