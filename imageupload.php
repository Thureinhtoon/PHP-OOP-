<form  method="POST" enctype="multipart/form-data">
    <input type="file" name="image[]" multiple><br>
    <input type="submit" name="submit" value="Upload">
</form>

<?php 
echo "<pre>";
if(isset($_POST['submit'])){
    $file = $_FILES;
    foreach($file as $img){
        // print_r($img);
        foreach($img['name'] as $k=>$image_name){
            $tmp_name =  $img['tmp_name'][$k];
            $target_file = 'image/'.$image_name;
            move_uploaded_file($tmp_name,$target_file);
            echo 'Success';
        }
    }
}