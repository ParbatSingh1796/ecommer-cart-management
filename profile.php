<?php
session_start();
if (! empty($_SESSION["userId"])) {
    require_once 'dbconnect.php';
    $dbconnect = new dbconnect();
    $memberResult = $dbconnect->getMemberById($_SESSION["userId"]);
    //$memberResult=$memberResult->fetch_assoc()
    if(! empty($memberResult[0]["display_name"])) {
        $displayName = ucwords($memberResult[0]["display_name"]);
    } else {
        $displayName = $memberResult[0]["user_name"];
    }
}
?>
<html>
<head>
<title>User Login</title>
<link href="./view/css/style.css" rel="stylesheet" type="text/css" />
</head>
<body>
    <div>
        <div class="dashboard">
            <div class="member-dashboard">Welcome <b><?php echo $displayName; ?></b>, You have successfully logged in!<br>
                Click to <a href="logout.php" class="logout-button">Logout</a>
            </div>
        </div>
    </div>
</body>
</html>