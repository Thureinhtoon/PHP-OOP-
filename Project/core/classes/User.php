<?php
class User{

    //Login
    public function login($request){
        $error =[];
        $email =Helper::filter($request['email']);
        $password =$request['password'];

        //check email
        $user = DB::table('users')->where('email',$email)->getOne();

        //password verify
        if($user){
            $db_password = $user->password; //hash pass
            if(password_verify($password,$db_password)){
                $_SESSION['user_id'] = $user->id;
                return "success";
            }else{
                $error[] ="Password does not match!";
            }
        }else{
            $error[] ="Wrong Email";
        }
        return $error;
    }
    //Auth 
    public static function auth(){
        if(isset($_SESSION['user_id'])){
            $user_id = $_SESSION['user_id'];
            return DB::table('users')->where('id',$user_id)->getOne();
        }
        return false;
       
    }
    public function register($request){
        $error = [];
        if(isset($request)){
            if(empty($request['name'])){
                $error[] = "Name Field is required";
            }
            if(empty($request['email'])){
                $error[] = "Email Field is required";
            }
            //check email already exist
            $email = DB::table('users')->where('email',$request['email'])->getOne();
            if($email){
                $error[] = "Email is already in use";
            }
            if(!filter_var($request['email'],FILTER_VALIDATE_EMAIL)){
                $error[] = "Email Field is incoorect format";
            }
            if(empty($request['password'])){
                $error[] = "Password Field is required";
            }

            if(count($error)){
                return $error;
            }else{
                //insert data
                $user = DB::create('users',[
                    'name' =>Helper::filter($request['name']),
                    'slug' =>Helper::slug($request['name']),
                    'email' =>Helper::filter($request['email']),
                    'password' => password_hash($request['password'],PASSWORD_BCRYPT)
                ]);
                    // print_r($user);
                    // echo $user;
                //session userid
             
              
                $_SESSION['user_id'] = $user->id;
                return 'success';
            }
           
        }
    }

    public static function update($request){
        $user =DB::table('users')->where('slug',$request['slug'])->getOne();
        if($request['password']){
            //new password
            $password = password_hash($request['password'],PASSWORD_BCRYPT);
        }else{
            //old password
            $password = $user->password;
        }

        if(isset($_FILES['image'])){
            $image =$_FILES['image'];
            $image_name =$image['name'];
            $path = "asset/images/$image_name";
            $tmp_name =$image['tmp_name'];
            move_uploaded_file($tmp_name,$path);
        }else{
            $path = $user->image;
        }

        DB::update("users",[
            "name"=>$request['name'],
            "image"=>$path,
            "email"=>$request['email'],
            "password"=>$password,
        ],$user->id);
        return "success";
    }
}

