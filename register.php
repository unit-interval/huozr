<?php
include 'config.php';
include DIR_INC . '/users_functions.php';


if ($_POST['username']!='')
	user_create_basic($_POST['username'], $_POST['passwd'], $_POST['screen_name']);
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Register</title>
</head>

<body>
<h1>注册－活字网</h1>
<form id="form1" name="form1" method="post" action="register.php">
  <label>
    <input type="text" name="username" id="username" />
    username</label>
  <br />
  <label>
    <input type="text" name="passwd" id="passwd" />
  passwd</label>
  <br />
  <label>
    <input type="text" name="screen_name" id="screen_name" />
    screen_name</label>
  <br />
  <label>
    <input type="submit" name="button" id="button" value="Submit" />
  </label>
</form>
</body>
</html>