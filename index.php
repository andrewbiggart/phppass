<?php require('_includes/check.php'); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Welcome, <?php echo $_SESSION['uname']; ?></title>
<link rel="stylesheet" type="text/css" href="_assets/css/style.css">
</head>

<body>
    <h1>Admin area</h1>
    <p>Welcome, <?php echo $_SESSION['uname']; ?><p>
</body>
</html>
