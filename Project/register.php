<?php require_once "inc/header.php"; 
if(User::auth()){
    Helper::redirect('index.php');
}
    if(isset($_POST['submit'])){
        $user = new User();
        $user = $user->register($_POST);
        if($user == "success"){
           Helper::redirect("index.php");
        }
    }
?>
<div class="card card-dark">
    <div class="card-header bg-warning">
        <h3>Register</h3>
    </div>
    <div class="card-body">
        <form action="" method="post">
            <?php 
            if(isset($user) and is_array($user)){
                foreach($user as $e){
                    ?>
                    <div class="alert alert-danger"><?php echo $e; ?></div>
                    <?php
                }
            }
            ?>
            <div class="form-group">
                <label for="" class="text-white">Enter Username</label>
                <input type="name" name="name" class="form-control" placeholder="enter username">
            </div>
            <div class="form-group">
                <label for="" class="text-white">Enter Email</label>
                <input type="email" name="email" class="form-control" placeholder="enter username">
            </div>
            <div class="form-group">
                <label for="" class="text-white">Enter Password</label>
                <input type="password" name="password" class="form-control" placeholder="enter username">
            </div>
            <input type="submit" name="submit" value="Register" class="btn  btn-outline-warning">
        </form>
    </div>
</div>
<?php require_once "inc/footer.php"; ?>