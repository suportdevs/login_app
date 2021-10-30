<?php
    $filepath = realpath(dirname(__FILE__));
    include_once $filepath."/../lib/Session.php";
    Session::init();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Register System PHP & OOP</title>
    <link rel="stylesheet" href="inc/bootstrap.min.css"/>
    <script src="inc/jquery-3.2.1.min.js"></script>
    <script src="inc/bootstrap.min.js"></script>
    <link rel="stylesheet" href="inc/style.css"/>
</head>
<?php
    if (isset($_GET['action']) && $_GET['action'] == "logout") {
        Session::destroy();
    }
?>
<body>
    
    <div class="container">
        <div class="header">
            <div class="row">
                <div class="col-md-6">
                    <nav class="mynavbar">
                        <a href="index.php" class="navbar-brand">Login Register System PHP & OOP</a>
                    </nav>
                </div>
                <div class="col-md-6 text-right">
                    <div class="menu">
                        <ul>
                            <?php
                                $id = Session::get("id");
                                $userlogin = Session::get("login");
                                if ($userlogin == true) { ?>                                 
                                    <li><a href="index.php">Home</a></li>
                                    <li><a href="profile.php?id=<?php echo$id; ?>">Profile</a></li>
                                    <li><a href="?action=logout">Logout</a></li>
                                <?php } else { ?>
                                    <li><a href="login.php">Login</a></li>
                                    <li><a href="register.php">Register</a></li>
                                <?php } ?>
                        </ul>
                    </div>
                </div>
            </div>
        </div>