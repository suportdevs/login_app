<?php
    include "inc/header.php";
    include "lib/User.php";
    Session::checkSession();
    $user = new User();
?>

<?php
    $loginmsg = Session::get("loginmsg");
    if (isset($loginmsg)) {
        echo $loginmsg;
    }
    Session::set("loginmsg", NULL);
?>
        <div class="row">
            <div class="col-md-12">
                <div class="panel-wrap">
                    <div class="pane-heading">
                        <h4>User List <span class="float-right"><strong>Wellcome ! </strong>
                        <?php
                            $username = Session::get("username");
                            if (isset($username)) {
                                echo $username;
                            }
                        ?>
                    </span></h4>
                    </div>
                    <div class="panel-body">
                        <table style="border-collapse:collapse; width:100%">
                            <tr>
                                <th style="width:20%">Serial</th>
                                <th style="width:20%">Name</th>
                                <th style="width:20%">Username</th>
                                <th style="width:20%">Email Address</th>
                                <th style="width:20%">Action</th>
                            </tr>
                            <?php
                                $userData = $user->userData();
                                if ($userData) {
                                    $i = 0;
                                    foreach($userData as $sData){
                                        $i++;
                            ?>
                            <tr>
                                <td><?php echo $i; ?></td>
                                <td><?php echo $sData['name']; ?></td>
                                <td><?php echo $sData['username']; ?></td>
                                <td><?php echo $sData['email']; ?></td>
                                <td><a class="btn btn-primary" href="profile.php?id=<?php echo $sData['id']; ?>">View</a></td>
                            </tr>
                                    <?php } } else {?>
                                <tr>
                                    <td colspan="5"><h2>Sorry ! Not user Data found...</h2></td>
                                </tr>
                                <?php } ?>
                        </table>
                    </div>
                </div>
            </div>
        </div>


<?php include "inc/footer.php" ?>