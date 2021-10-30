<?php
    include "inc/header.php";
    include "lib/User.php";
?>
<?php
    if (isset($_GET['id'])) {
        $userid = (int)$_GET['id'];
        $sesid = Session::get("id");
        if ($userid != $sesid) {
            header("Location: index.php");
        }
    }


    $user = new User();
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["changepassword"])) {
        $changePassword = $user->changePassword($userid, $_POST);
    }
?>
        <div class="row">
            <div class="col-md-12">
                <div class="panel-wrap">
                    <div class="pane-heading">
                        <h4>User Registration <span class="float-right"><a class="btn btn-primary" href="profile.php?id=<?php echo $userid; ?>">Back</a></span></h4>
                    </div>
                    <div class="panel-body">
                        <div style="max-width: 600px; margin: 0 auto; padding: 30px 0;">
                            <?php
                                if (isset($changePassword)) {
                                    echo $changePassword;
                                }
                            ?>
                            <form action="" method="POST">
                                <div class="form-group">
                                    <label for="email">Old Password</label>
                                    <input class="form-control" type="password" name="old_password" placeholder="Enter your Old Password">
                                </div>
                                <div class="form-group">
                                    <label for="password">Password</label>
                                    <input class="form-control" type="password" name="new_password" placeholder="Enter your New Password">
                                </div>
                                <button type="submit" name="changepassword" class="btn btn-info">Change Password</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>


<?php include "inc/footer.php" ?>