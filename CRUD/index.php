<?php require_once("inc/header.php"); ?>
   <a href="create.php" class="btn btn-success float-right mb-3">Create</a>

<?php if(isset($_GET['create'])) {
?>
    <div class="mt-17 alert alert-success alert-dismissible fade show" role="alert">
      <strong>Created Success!</strong>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
    </div>
 <?php  
} 
   ?>  

<?php if(isset($_GET['delete'])) {
    ?>
    <div class="mt-17 alert alert-success alert-dismissible fade show" role="alert">
      <strong>Deleted Success!</strong>
      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
      </button>
</div>
 <?php  
} 
   ?>    

<?php if(isset($_GET['update'])) {
    ?>
    <div class="mt-17 alert alert-success alert-dismissible fade show" role="alert">
  <strong>Updated Success!</strong>
  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
    <span aria-hidden="true">&times;</span>
  </button>
</div>
 <?php  
} 
   ?>    
   
   <table class="table table-striped">
                            <tr>
                                <td>No</td>
                                <td>Image</td>
                                <td>Name</td>
                                <td>Action</td>
                            </tr>
<?php 
    $sql = "select * from crud";
    $data = $pdo->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    foreach($data as $d){
        ?>
        
        <tr>
                            <td><?php echo $d['id']; ?></td>
                            <td><?php echo $d['name']; ?></td>
                            <td><img src="image/<?php echo $d['image'] ?>" width="100px"></td>
                            <td><a href="update.php?id=<?php echo $d['id'] ?>" class="btn btn-sm btn-warning">Update</a>
                            <a href="delete.php?id=<?php echo $d['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete?')">Delete</a></td>
                            </tr>
        <?php
    }
?>
                        </table>
<?php require_once("inc/footer.php"); ?>            