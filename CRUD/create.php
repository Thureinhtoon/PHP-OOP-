
<?php require_once("inc/header.php"); ?>
                <a href="index.php" class="btn btn-info mb-3">Back</a>
                    <form action="" method="POST" enctype="multipart/form-data">
                        <div class="form-group">
                        <label for="name">Enter Name</label>
                        <input type="text"class="form-control" name="name" id="name">
                        </div>

                        <div class="form-group">
                        <label for="name">Choose Image</label>
                        <input type="file"class="form-control" name="image" id="name">
                        </div>

                        <input type="submit" name="submit" class="btn btn-success" value="Submit">
                    </form>

                    <?php
                    if(isset($_POST['submit'])){
                        $name = $_POST['name'];
                        $image_name = $_FILES['image']['name'];
                        $tmp_name = $_FILES['image']['tmp_name'];
                        $path = "image/".$image_name;

                        move_uploaded_file($tmp_name,$path);

                        $sql = "insert into crud(name,image) value(?,?)";
                        $res = $pdo->prepare($sql);
                        $res->execute([$name,$image_name]);

                        header('location:index.php?create=success');
                    }
                    ?>
<?php require_once("inc/footer.php"); ?>            