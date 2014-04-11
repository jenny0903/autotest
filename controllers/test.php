<?php
include_once('../libraries/controller.php');
$controller = new Controller();
// $result = $controller->update_user_info();
// $result = $controller->set_avatar();
// $result = $controller->get_avatar();
$result = $controller->get_album_info();
echo $result;