<?php require_once "inc/header.php";
    if(isset($_GET['category'])){
        $slug =$_GET['category'];
        $post =Post::articldByCategory($slug);
    }elseif(isset($_GET['language'])){
        $slug =$_GET['language'];
        $post =Post::languageByCategory($slug);
    }
    elseif(isset($_GET['search'])){
        $search = $_GET['search'];
        $post = Post::search($search);
    }
    else{
        $post = Post::all();
    }
    // print_r($post);


?>
                    <div class="card card-dark">
                        <div class="card-body">
                            <a href="<?php echo $post['pre_page'];?>" class="btn btn-danger">Prev Posts</a>
                            <a href="<?php echo $post['next_page']; ?>" class="btn btn-danger float-right">Next Posts</a>
                        </div>
                    </div>
                    <div class="card card-dark">
                        <div class="card-body">
                            <div
                                class="row">
                                <!-- Loop this -->
                                <?php
                            //    echo "<pre>";
                            //    print_r( Post::all());
                            //     die();
                                // $articles = DB::table('articles')->orderBy('id','DESC')->paginate(2);
                                // $articles['data'][0]->like_count =1;
                                // $articles['data'][0]->comment_count =1;
                                // echo "<pre>";
                                // print_r($articles);
                                foreach($post['data'] as $a){
                                ?>
                                 <div class="col-md-4 mt-2">
                                    <div class="card" style="width: 18rem;">
                                        <img class="card-img-top" src="<?php echo $a->image; ?>" alt="Card image cap">
                                        <div class="card-body">
                                            <h5 class="text-dark"><?php echo $a->title; ?></h5>
                                        </div>
                                        <div class="card-footer">
                                            <div class="row">
                                                <div class="col-md-4 text-center">
                                                    <i class="fas fa-heart text-warning"></i>
                                                    <small class="text-muted"><?php echo $a->like_count; ?></small>
                                                </div>
                                                <div class="col-md-4 text-center">
                                                    <i class="far fa-comment text-dark"></i>
                                                    <small class="text-muted"><?php echo $a->comment_count; ?></small>
                                                </div>
                                                <div class="col-md-4 text-center">
                                                    <a href="detail.php?slug=<?php echo $a->slug; ?>" class="badge badge-warning p-1">View</a>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                                <?php
                                }
                                ?>
                               
                              
                            </div>
                        </div>
                    </div>
               <?php require_once "inc/footer.php"; ?>