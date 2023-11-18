<?php
header("Access-Control-Allow-Origin:*");
header("Access-Control-Allow-Headers:*");
//MySQL database Connection
$con=mysqli_connect('localhost','root','','db_sample');
//Received JSON into $json variable
$json = file_get_contents('php://input');
// $json = $_POST;
// var_dump($json);
//Decoding the received JSON and store into $obj variable.
$obj = json_decode($json,true);
// $obj = $_POST;

if(isset($obj["username"]) && isset($obj["password"])){
    $uname = mysqli_real_escape_string($con, $obj['username']);
    $pwd = mysqli_real_escape_string($con, $obj['password']);
    //Declare array variable
    $result=[];
    //Select Query
    $sql="SELECT * FROM users WHERE username='{$uname}' and
    password='{$pwd}'";

    $res=$con->query($sql);
    if($res->num_rows > 0){
        $row=$res->fetch_assoc();
        $result['loginStatus']=true;
        $result['message']="Login Successfully";
        $result["userInfo"]=$row;
    }else{
        $result['loginStatus']=false;
        $result['message']="Invalid Login Details";
    }

// Converting the array into JSON format.
$json_data=json_encode($result);
// Echo the $json.
echo $json_data;
}else{
    echo json_encode(['message' => "No Method!"]);
}
?>  