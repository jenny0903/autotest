<?php
include_once('../libraries/controller2.php');
$controller = new Controller2();
// $result = $controller->get_member_list(); // finish
// $result = $controller->join_album(); // finish
// $result = $controller->leave_album(); // finish
// $result = $controller->set_member_role(); // finish
// $result = $controller->get_member_role(); // finish
// $result = $controller->get_album_activities(); // finish

// $result = $controller->link(); // finish

// $result = $controller->event(); // finish

// $result = $controller->list_comment(); // finish
// $result = $controller->count_comment(); // finish
// $result = $controller->post_comment(); // finish
// $result = $controller->reply_comment(); // finish
// $result = $controller->del_comment(); // finish

// $result = $controller->list_like(); // finish
// $result = $controller->count_like(); // finish
// $result = $controller->post_like(); // finish
$result = $controller->del_like(); // finish
// $result = $controller->like_flag(); // finish

echo $result;