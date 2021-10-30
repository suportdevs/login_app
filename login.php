<?php
    include "inc/header.php";
    include "lib/User.php";
    Session::checkLogin();
?>
<?php
    $user = new User();
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["login"])) {
        $userLogin = $user->userLogin($_POST);
    }
?>
        <div class="row">
            <div class="col-md-12">
                <div class="panel-wrap">
                    <div class="pane-heading">
                        <h4>User Registration <span class="float-right"><strong>Wellcome ! </strong></span></h4>
                    </div>
                    <div class="panel-body">
                        <div style="max-width: 600px; margin: 0 auto; padding: 30px 0;">
                            <?php
                                if (isset($userLogin)) {
                                    echo $userLogin;
                                }
                            ?>
                            <form action="" method="POST">
                                <div class="form-group">
                                    <label for="email">Email</label>
                                    <input class="form-control" type="email" name="email" placeholder="Enter your Email">
                                </div>
                                <div class="form-group">
                                    <label for="password">Password</label>
                                    <input class="form-control" type="password" name="password" placeholder="Enter your Password">
                                </div>
                                <button type="submit" name="login" class="btn btn-success">Login</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>


<?php include "inc/footer.php" ?>