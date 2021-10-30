<?php
    include "inc/header.php";
    include "lib/User.php";
    Session::checkSession();
?>
<?php
    if (isset($_GET['id'])) {
        $userid = (int)$_GET['id'];
    }
    $user = new User();
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["update"])) {
        $userUpdate = $user->userUpdatedata($userid, $_POST);
    }
?>
        <div class="row">
            <div class="col-md-12">
                <div class="panel-wrap">
                    <div class="pane-heading">
                        <h4>User Profile <span class="float-right"><strong>Wellcome ! </strong>
                        <?php
                            $username = Session::get("username");
                            if (isset($username)) {
                                echo $username;
                            }
                        ?>
                        </span></h4>
                    </div>
                    <div class="panel-body">
                        <div style="max-width: 600px; margin: 0 auto; padding: 30px 0;">
                        <?php
                            if (isset($userUpdate)) {
                                echo $userUpdate;
                            }
                        ?>
                        <?php
                            $userData = $user->getUserbyId($userid);
                            if ($userData) { ?>
                            <form action="" method="POST">
                                <div class="form-group">
                                    <label for="firstname">Name</label>
                                    <input class="form-control" type="text" name="name" value="<?php echo $userData->name; ?>">
                                </div>
                                <div class="form-group">
                                    <label for="username">User Name</label>
                                    <input class="form-control" type="text" name="username" value="<?php echo $userData->username; ?>">
                                </div>
                                <div class="form-group">
                                    <label for="email">Email</label>
                                    <input class="form-control" type="email" name="email" value="<?php echo $userData->email; ?>">
                                </div>
                                <?php
                                    $sesid = Session::get("id");
                                    if ($userid == $sesid) { ?>
                                <button type="submit" name="update" class="btn btn-success">Uptate</button>
                                <a href="changepassword.php?id=<?php echo $userid; ?>" class="btn btn-info">Change Password</a>
                                    <?php } ?>
                            </form>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>


<?php include "inc/footer.php" ?>