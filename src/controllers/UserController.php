<?php 
include "../config.php";
class UserController{
    private $name;
    private $lastname;
    private $email;
    private $birthday;
    private $role;
    private $sex;
    private $celphone;

    public function __construct($name,$lastname,$email,$birthday,$role,$sex,$celphone = null)
    {
        $this->name = $name;
        $this->lastname = $lastname;
        $this->email = $email;
        $this->birthday = $birthday;
        $this->role = $role;
        $this->sex = $sex;
        $this->celphone = $celphone;
    }

    public function insert_users()
    {
        $all_users = file_get_contents(ABSPATH."/data/user_data.json");
        $insert_data = json_decode($all_users);
        $data = array(
            "name" => $this->name,
            "lastname" => $this->lastname,
            "email" => $this->email,
            "birthday" => $this->birthday,
            "role" => $this->role,
            "sex" => $this->sex,
            "celphone" => $this->celphone
        );
        array_push($insert_data,$data);
        $archivo = fopen(ABSPATH."/data/user_data.json","w");
        fwrite($archivo,json_encode($insert_data));
        fclose($archivo);
        return $insert_data;
    }

    public static function get_all_users()
    {
        return json_decode(file_get_contents(ABSPATH."/data/user_data.json"));
    }

    public static function get_users_by_condition($id = false,$name = false, 
    $lastname = false, 
    $email = false, 
    $birthday = false, 
    $role = false, 
    $sex = false, 
    $celphone = false)
    {
        $data = json_decode(file_get_contents(ABSPATH."/data/user_data.json"));
        $data_return = [];
        foreach ($data as $data_) {
            if ($data_->id == $id 
            || $data_->name == $name 
            || $data_->lastname == $lastname 
            || $data_->email == $email 
            || $data_->birthday == $birthday
            || $data_->role == $role
            || $data_->sex == $sex
            || $data_->celphone == $celphone
            ) {
                array_push($data_return,$data_);
            }
        }
        return $data_return;
    }

}