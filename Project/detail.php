<?php require_once "inc/header.php";
if(!isset($_GET['slug'])){
    Helper::redirect('404.php');
}else{
    $slug = $_GET['slug'];
    // echo $slug;

    $article = Post::detail($slug);
    // echo "<pre>";
    // print_r($article);
}
?>

<div class="card card-dark">
            <div class="card-body">
              <div class="row">
                <div class="col-md-12">
                  <div class="card card-dark">
                    <div class="card-body">
                      <div class="row">
                        <!-- icons -->
                        <div class="col-md-4">
                          <div class="row">
                            <div class="col-md-4 text-center">
                              <?php 
                              $user_id = User::auth() ? User::auth()->id : 0;
                              $article_id = $article->id;
                              ?>
                              <i id="like" class="fas fa-heart text-warning" user_id="<?php echo $user_id; ?>" article_id="<?php echo $article_id; ?>"> </i>
                              <small id="like_count" class="text-muted"><?php echo $article->like_count; ?></small>
                            </div>
                            <div class="col-md-4 text-center">
                              <i class="far fa-comment text-dark"></i>
                              <small class="text-muted"><?php echo $article->comment_count; ?></small>
                            </div>
                          </div>
                        </div>
                        <!-- Icons -->

                        <!-- Category -->
                        <div class="col-md-4">
                          <div class="row">
                            <div class="col-md-12">
                              <a href="" class="badge badge-primary"><?php echo $article->category->name; ?></a>
                            </div>
                          </div>
                        </div>
                        <!-- Category -->

                        <!-- Languages -->
                        <div class="col-md-4">
                          <div class="row">
                            <div class="col-md-12">
                              <?php 
                              foreach($article->languages as $l){
                                  ?>
                                  <a href="" class="badge badge-success"><?php echo $l->name; ?> </a>
                                  <?php
                              }
                              ?>
                             
                            </div>
                          </div>
                        </div>
                        <!-- Category -->
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <br />
              <div class="col-md-12">
                <h3><?php echo $article->title; ?></h3>
                <p>
                 <?php echo $article->description; ?>
                </p>
              </div>
               <!-- Create Comment                -->
               <div class="card card-dark mb-5">
                 <div class="card-body">
                   <form action="" method="POST" id="formCmt">
                     <input type="text" placeholder="Enter Comment" id="comment" class="form-control"><br>
                     <input type="submit" value="Create" class="btn btn-outline-warning float-right" >
                   </form>
                 </div>
               </div>
              <!-- Comments -->
              <div class="card card-dark">
                <div class="card-header">
                  <h4>Comments</h4>
                </div>
                <div class="card-body">
                  <!-- Loop Comment -->
                  <div id="comment_list">
                     <?php
foreach ($article->comments as $c) {
    ?>
                      <div class="card-dark mt-1">
                    <div class="card-body">
                      <div class="row">
                        <div class="col-md-1">
                          <img
                            src="<?php echo DB::table('users')->where('id', $c->user_id)->getOne()->image;?>"
                            style="width: 50px; border-radius: 50%"
                            alt=""
                          />
                        </div>
                        <div class="col-md-4 d-flex align-items-center">
                         <?php
echo DB::table('users')->where('id', $c->user_id)->getOne()->name;
    ?>
                        </div>
                      </div>
                      <hr />
                      <p>
                       <?php echo $c->comment; ?>
                      </p>
                    </div>
                  </div>
                      <?php
}
?>
                  </div>
                 
                 
                </div>
              </div>
            </div>
          </div>
          <?php require_once "inc/footer.php";?>

          <script>
          //Comment
          var formCmt = document.querySelector('#formCmt');
          formCmt.addEventListener('submit',function(e){
            e.preventDefault();
            var data = new FormData();
            data.append('comment',document.querySelector('#comment').value);
            data.append('article_id',<?php echo $article->id ?>);
            axios.post('api.php',data)
            .then(function(res){
              console.log(res.data);
              document.querySelector('#comment_list').innerHTML = res.data;
            })
          });
            // toastr.warning('Hello');
            //like
            var like = document.getElementById('like');
            var like_count = document.getElementById('like_count');
            like.addEventListener('click',function(){
              var user_id = like.getAttribute("user_id");
              var article_id = like.getAttribute("article_id");

              if(user_id == 0){
                location.href = "login.php";
              }
              axios.get(`api.php?like&user_id=${user_id}&article_id=${article_id}`)
                  .then(function(res){
                    if(res.data == "already Liked"){
                      toastr.warning("Already Liked");
                    }
                  //  if(Number.isInteger(res.data))
                  else{
                     like_count.innerHTML = res.data;
                     toastr.success("liked Success");

                   }
                  });
            })
          </script>
