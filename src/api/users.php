<?php
    header('Content-Type: application/json; charset=utf-8');
    include "../controllers/UserController.php";
    $error = [];
    $mesagge = [];
    switch ($_SERVER["REQUEST_METHOD"]) {
        case 'GET':
            if (count($_GET) > 0) {
                $id = isset($_GET["id"])?htmlspecialchars($_GET["id"]):false;
                $name = isset($_GET["name"])?htmlspecialchars($_GET["name"]):false;
                $lastname = isset($_GET["lastname"])?htmlspecialchars($_GET["lastname"]):false;
                $email = isset($_GET["email"])?htmlspecialchars($_GET["email"]):false;
                $birthday = isset($_GET["birthday"])?htmlspecialchars($_GET["birthday"]):false;
                $role = isset($_GET["role"])?htmlspecialchars($_GET["role"]):false;
                $sex = isset($_GET["sex"])?htmlspecialchars($_GET["sex"]):false;
                $celphone = isset($_GET["celphone"])?htmlspecialchars($_GET["celphone"]):false;
                $data = UserController::get_users_by_condition($id,$name,$lastname,$email,$birthday,$role,$sex,$celphone);
                echo (count($data) > 0) ? json_encode($data): '{"no_data":"there\'s no data or the keys added in the URL don\'t exist"}';
            }else{
                $data = UserController::get_all_users();
                echo json_encode($data);
            }
            break;
        case 'POST':
            $post_json = json_decode(file_get_contents("php://input"));
            if ($post_json === null) {
                array_push($error,["validate_json"=>"the json is not valid"]);
                die(json_encode($error));
            }
            if(count((array)$post_json) > 8){
                array_push($error,["validate_json"=>"You have more atributes allowed in the json"]);
                die(json_encode($error));
            }
            //extract((array)$post_json,EXTR_OVERWRITE);
            $data_required = ["name","lastname","email","birthday","role","sex"];
            foreach ($data_required as $data) {  
                if (!property_exists($post_json,$data)) {
                    array_push($error,["required_value"=>"the $data is necesary"]);
                    die(json_encode($error));
                }
            }

            if (!preg_match("/^[a-zA-ZáéíóúÁÉÍÓÚñÑüÜ\s]{2,255}$/",$post_json->name)) {
                array_push($error,["invalid_value"=>"the name doesn't match. It just can accept letters, and it can't be bigger than 255 caraters."]);
                die(json_encode($error));
            }

            if (!preg_match("/^[a-zA-ZáéíóúÁÉÍÓÚñÑüÜ\s]{2,255}$/",$post_json->lastname)) {
                array_push($error,["invalid_value"=>"the lastname doesn't match. It just can accept letters, and it can't be bigger than 255 caraters."]);
                die(json_encode($error));
            }

            if (!filter_var($post_json->email,FILTER_VALIDATE_EMAIL)) {
                array_push($error,["invalid_value"=>"the email doesn't match."]);
                die(json_encode($error));
            }
            $birthday = explode("-",$post_json->birthday);
            if (count($birthday) < 3 || count($birthday)) {
                if (!checkdate($birthday[1],$birthday[2],$birthday[0])) {
                    array_push($error,["invalid_value"=>"the birthday doesn't match. It has to be in the format AAAA-MM-DD"]);
                    die(json_encode($error));   
                }
            } 

            if ($post_json->role !== "student" && $post_json->role !== "teacher") {
                    array_push($error,["invalid_role"=>"the rol $post_json->role doesn't exist"]);
                    die(json_encode($error));
                }

           if ($post_json->sex !== "women" && $post_json->sex !== "man" && $post_json->sex !== "not selected") {
                array_push($error,["invalid_sex"=>"the sex category $post_json->sex doesn't exist"]);
                die(json_encode($error));
            }

            if (property_exists($post_json,"celphone") && !preg_match('/^[0-9]{10}$/',$post_json->celphone)) {
                    array_push($error,["invalid_value"=>"the celphone value needs to have at least 10 numbers"]);
                    die(json_encode($error));
            }
            //echo json_encode($post_json);
            //var_dump($post_json->name,$post_json->lastname,$post_json->email,$post_json->birthday,$post_json->role,$post_json->sex,$post_json->celphone);
            //$user = new UserController($post_json->name,$post_json->lastname,$post_json->email,$post_json->birthday,$post_json->role,$post_json->sex,$post_json->celphone); 
            $user = new UserController("Robert","Chiflido","a@mail.com","2002-01-01","student","man","2211219331");
            var_dump($user->insert_users());  
            break;
        case 'PUT':
            echo "Aqui en put";

            break;
        case 'DELETE':
            echo "Aqui en delete";
            break;
    }
?>
