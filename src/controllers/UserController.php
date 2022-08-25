<?php 
include "../config.php";
class UserController{
    private $id;
    private $name;
    private $lastname;
    private $email;
    private $birthday;
    private $role;
    private $sex;
    private $celphone;

    public function __construct($id = null,$name = null,$lastname = null,$email = null,$birthday = null,$role = null,$sex = null,$celphone = null)
    {
        $this->id = $id;
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
            "id" => $this->id,
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

    public function update_user($id)
    {
        $data = json_decode(file_get_contents(ABSPATH."/data/user_data.json"));
        foreach ($data as $data_) {
            if ($data_->id == $id) {
                $data_->name = isset($this->name)?$this->name:$data_->name; 
                $data_->lastname = isset($this->lastname)?$this->lastname:$data_->lastname; 
                $data_->email = isset($this->email)?$this->email:$data_->email; 
                $data_->birthday = isset($this->birthday)?$this->birthday:$data_->birthday;
                $data_->role = isset($this->role)?$this->role:$data_->role;
                $data_->sex = isset($this->sex)?$this->sex:$data_->sex;
                $data_->celphone = isset($this->celphone)?$this->celphone:$data_->celphone;
            }
        }
        $data = json_encode($data);
        $archivo = fopen(ABSPATH."/data/user_data.json","w");
        fwrite($archivo,$data);
        fclose($archivo);
        return $data;   
    }

    public static function delete_user($id)
    {
        $data = json_decode(file_get_contents(ABSPATH."/data/user_data.json"));
        foreach ($data as $key => $value) {
            if ($value->id === $id) {
                unset($data[$key]);
            }
        }   
        $data = json_encode($data);
        $archivo = fopen(ABSPATH."/data/user_data.json","w");
        fwrite($archivo,$data);
        fclose($archivo);
        return $data;
    }
}