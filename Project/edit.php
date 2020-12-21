<?php require_once "inc/header.php";
    if(isset($_GET['user'])){
        $slug = $_GET['user'];
        $user =DB::table('users')->where('slug',$slug)->getOne();
        if(!$user){
            Helper::redirect('404.php');
        }
        if($_SERVER['REQUEST_METHOD']=="POST"){
            $res = User::update($_POST);
            Helper::redirect("edit.php?user=".$slug);
        }
    }else{
        Helper::redirect('404.php');
    }
?>
<div class="card card-dark">
    <div class="card-header bg-warning">
        <h3>Edit User</h3>
    </div>
    <div class="card-body">
        <form action="" method="post" enctype="multipart/form-data">
        <?php if (isset($res) and $res == "success") {
    ?>
                                <div class="alert alert-success">Article Updated Successful!</div>
                              <?php
}?>
            <div class="form-group">
                <input type="hidden" name="slug" value="<?php echo $user->slug; ?>">
                <label for="" class="text-white">Enter Username</label>
                <input type="name" name="name" value="<?php echo $user->name; ?>" class="form-control" placeholder="enter username">
            </div>
            <div class="form-group">
                <label for="" class="text-white">Enter Email</label>
                <input type="email" name="email" value="<?php echo $user->email; ?>" class="form-control" placeholder="enter username">
            </div>
            <div class="form-group">
                <label for="" class="text-white">Enter Password</label>
                <input type="password" name="password" class="form-control" placeholder="enter username">
            </div>
             <div class="form-group">
                <label for="" class="text-white">Choose Image</label>
                <input type="file"  name="image" class="form-control">
                <img src="<?php echo $user->image; ?>" alt="User" style="width:100px;border-radius:50%;">
            </div>
            <input type="submit" name="submit" value="Update" class="btn  btn-outline-warning">
        </form>
    </div>
</div>
<?php require_once "inc/footer.php";?>