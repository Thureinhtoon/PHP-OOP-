
<?php 
require_once("inc/header.php");
if(isset($_GET['id'])){
    $id = $_GET['id'];
    $sql = "select * from crud where id=?";
    $res = $pdo->prepare($sql);
    $res->execute([$id]);
    $data = $res->fetch(PDO::FETCH_ASSOC);

}
?>
                <a href="index.php" class="btn btn-info mb-3">Back</a>
                    <form action="" method="POST" enctype="multipart/form-data">
                        <div class="form-group">
                        <label for="name">Enter Name</label>
                        <input type="text"class="form-control" name="name" id="name" value="<?php echo $data['name'];?>">
                        </div>

                        <div class="form-group">
                        <label for="name">Choose Image</label>
                        <input type="file"class="form-control" name="image" id="name" >
                        <img src="image/<?php echo $data['image']; ?>" alt="" style="width: 100px; height:100px;">
                        </div>

                        <input type="submit" name="submit" class="btn btn-success" value="Update">
                    </form>

<?php require_once("inc/footer.php"); 
    if(isset($_POST['submit'])){
        $name = $_POST['name'];
         if($_FILES['image']['tmp_name'] !=''){
             $tmp_name = $_FILES['image']['tmp_name'];
             $image_name = $_FILES['image']['name'];
             $path = "image/".$image_name;
             move_uploaded_file($tmp_name,$path);
         }else{
             $image_name =$data['image'];
         }

         $sql = "update  crud set  name=?,image=? where id=?";
         $res =$pdo->prepare($sql);
         $res->execute([$name,$image_name,$id]);

         header('location:index.php?update=success');
    }
?>            