<?php 

class DB{
    private static $dbh = null;
    private static $res,$data,$count,$sql;

    public function __construct()
    {
        self::$dbh = new PDO("mysql:host=localhost;dbname=test","root","");
        self::$dbh->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
       
    }

    public function query($params=[]){
        self::$res = self::$dbh->prepare(self::$sql);
        self::$res->execute($params);
       
       
        return $this;
    }

    public function get(){
        $this->query();
        self::$data = self::$res->fetchAll(PDO::FETCH_OBJ);
        return self::$data;
    }

    public function getOne(){
        $this->query();
        self::$data = self::$res->fetch(PDO::FETCH_OBJ);
        return self::$data;
    }

    public function count(){
        self::$count = self::$res->rowCount();
        $this->query();
        return self::$count;
    }

    public static function table($table){
        $sql = "select * from $table";
        self::$sql = $sql;
        $db = new DB();
        // $db->query();
        return $db;//same with $this
    }

    public function orderBy($col,$val){
        self::$sql.= " order by $col $val";
        $this->query();
        return $this;
    }

    public function where($col,$operator,$value=''){
        if(func_num_args() == 2){
            self::$sql .= " where $col='$operator'";
        }
        else{
            self::$sql .= " where $col $operator '$value'";
        }
        
        return $this;
    }

    public function andWhere($col,$operator,$value=''){
        if(func_num_args() == 2){
            self::$sql .= " and $col='$operator'";
        }
        else{
            self::$sql .= " and $col $operator' $value'";
        }
       
        return $this;
    }

    public function orWhere($col,$operator,$value=''){
        if(func_num_args() == 2){
            self::$sql .= " or $col='$operator'";
        }
        else{
            self::$sql .= " or $col $operator' $value'";
        }
       
        return $this;
    }

    public static function create($table,$data){
        $db = new DB();
        $str_col = implode(',',array_keys($data));
        $v ="";
        $x = 1;
        foreach($data as $d){
            $v .= "?";
           if($x < count($data)){
               $v .= ",";
               $x++;
           }
        }
        $sql = "insert into $table($str_col)values($v)";
        self::$sql = $sql;
        $values = array_values($data);
        $db->query($values);
        $id = self::$dbh->lastInsertId();
        return DB::table($table)->where("id",$id)->getOne();
    }

    public static function update($table,$data,$id){
        //update users set name=?,age=?,location=? where id =3
        $db = new DB();
        $sql = "update $table set";
        $value ="";
        $x =1;
        foreach($data as $k=>$v){
            $value .= "$k =?";
            if($x<count($data)){
                $value .= ",";
                $x++;
            }
        }
        $sql .= " $value where id =$id";

        self::$sql = $sql;
        $db->query(array_values($data));
        return DB::table($table)->where('id',$id)->getOne();
    }
    public static function raw($sql){
        self::$sql = $sql;
        $db = new DB();
        return $db;
    }

    public static function delete($table,$id){
        $sql  = "delete from $table where id=$id";
        self::$sql = $sql;
        $db = new DB();
        $db->query();
        return true;
    }
    public function paginate($records_per_page,$append=""){
        if(isset($_GET['page'])){
            $page_no = $_GET['page'];
        }

        if(!isset($_GET['page'])){
            $page_no = 1;
        }

        if(isset($_GET['page']) and $_GET['page'] <1){
            $page_no = 1;
        }
        // 0,5 1 (1-1)*5 =0
        // 5,5 2 (2-1)*5 =5
        // 10,5 3 (3-1)*5 =10
        //get total count
        $this->query();

        $count = self::$res->rowCount();
        $index = ($page_no -1)*$records_per_page;
        // select * from users limit 0,5
        self::$sql .= " limit $index,$records_per_page";
        $this->query();
        self::$data = self::$res->fetchAll(PDO::FETCH_OBJ);
        $prev_no = $page_no - 1;
        $next_no = $page_no + 1;
        $prev_page ="?page=" .$prev_no;
        $next_page ="?page=" .$next_no;

        $data = [
            "data" => self::$data,
            "total" => $count,
            "pre_page" => $prev_page."&$append",
            "next_page" => $next_page."&$append"

        ];
        return $data;
    }
}

// $db = new DB();
// $user =$db->query("select * from users")->get();
// echo $db->query("select * from users")->count();
// print_r($user);

// $user = DB::table('users')->where('id',1)->andWhere("name","Mg Mg")->count();
// echo "<pre>";
// var_dump($user);

// $user = DB::create('users',[
//     'name'=>'Ko Ko edited',
//     'email' =>'sapat@gmail.com',
//     'password' => '123'
// ]);

// echo "<pre>";
// print_r($user);
// if(DB::delete('users',3)){
//     echo "Success delete";
// }

// $user = DB::table('users')->paginate(1);
// echo "<pre>";
// print_r($user);