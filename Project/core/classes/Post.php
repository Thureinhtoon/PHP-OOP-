<?php 
class Post{
    public static function all(){
        $data = DB::table('articles')->orderBy('id','DESC')->paginate(2);
        foreach($data['data'] as $k=>$d){
            $data['data'][$k]->comment_count = DB::table('articles_comment')->where('article_id',$d->id)->count();
            $data['data'][$k]->like_count = DB::table('articles_like')->where('article_id',$d->id)->count();
        }
        return $data;
    }

    public static function detail($slug){
        $data = DB::table('articles')->where('slug',$slug)->getOne();
        //try to get languages
        $data->languages = DB::raw("SELECT languages.id,languages.slug,languages.name FROM article_language 
        LEFT JOIN
        languages
        ON languages.id=article_language.language_id
    where article_id ={$data->id}")->get();
        //try to get comment
        $data->comments = DB::table('articles_comment')->where('article_id',$data->id)->get();
        //try to get category
        $data->category =DB::table('category')->where('id',$data->category_id)->getOne();
        //try to get like_count and 
         $data->comment_count = DB::table('articles_comment')->where('article_id',$data->id)->count();
            $data->like_count = DB::table('articles_like')->where('article_id',$data->id)->count();
        return $data;
    }

    public static function articldByCategory($slug){
        $category_id =DB::table('category')->where('slug',$slug)->getOne()->id;
        $data = DB::table('articles')->where('category_id',$category_id)->orderBy('id', 'DESC')->paginate(2,"category=$slug");
            foreach ($data['data'] as $k => $d) {
                $data['data'][$k]->comment_count = DB::table('articles_comment')->where('article_id', $d->id)->count();
                $data['data'][$k]->like_count = DB::table('articles_like')->where('article_id', $d->id)->count();
            }
            return $data;

    }

    public static function languageByCategory($slug){
        $language_id = DB::table('languages')->where('slug', $slug)->getOne()->id;
        $data = DB::raw("
        select * from article_language
        LEFT JOIN articles 
        ON articles.id =article_language.article_id
        WHERE article_language.language_id ={$language_id}
        ")->orderBy('articles.id', 'DESC')->paginate(2, "language=$slug");
        foreach ($data['data'] as $k => $d) {
            $data['data'][$k]->comment_count = DB::table('articles_comment')->where('article_id', $d->id)->count();
            $data['data'][$k]->like_count = DB::table('articles_like')->where('article_id', $d->id)->count();
        }
return $data;

    }

    public static function create($request){
     //image upload

     $image = $_FILES['image'];
     $image_name  = $image['name'];
     $path ="asset/images/$image_name";
     $tmp_name =$image['tmp_name'];
     if(move_uploaded_file($tmp_name,$path)){
         $article = DB::create('articles',[
             'user_id'=>User::auth()->id,
             'category_id'=>$request['category_id'],
             'slug'=>Helper::slug($request['title']),
             'title'=>$request['title'],
             'image'=>$path,
             'description'=>$request['description']
         ]);

         if($article){
             foreach($request['language_id'] as $id){
                 DB::create('article_language',[
                     'article_id'=>$article->id,
                     'language_id'=>$id,
                 ]);
                 return "success";
             }
         }else{
             return false;
         }
     }else{
         return false;
     }
    }

    public static function search($search){
        $data = DB::table('articles')->where("title","like","%$search%")->orderBy('id', 'DESC')->paginate(2,"search=$search");
foreach ($data['data'] as $k => $d) {
    $data['data'][$k]->comment_count = DB::table('articles_comment')->where('article_id', $d->id)->count();
    $data['data'][$k]->like_count = DB::table('articles_like')->where('article_id', $d->id)->count();
}
return $data;

    }
}