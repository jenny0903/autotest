<?php
include_once('../libraries/controller.php');
$controller = new Controller();
// $result = $controller->update_user_info();
// $result = $controller->set_avatar();
// $result = $controller->get_avatar();
// $result = $controller->get_album_info();
// $result = $controller->list_albums();
// $result = $controller->create_album();
// $result = $controller->update_album();
// $result = $controller->del_album();
// $result = $controller->get_file_list();
// $result = $controller->get_file_info();
// $result = $controller->download_file();
// $result = $controller->upload_file();
// $result = $controller->del_file();
// $result = $controller->copy_file();
$result = $controller->thumbnail();
echo $result;