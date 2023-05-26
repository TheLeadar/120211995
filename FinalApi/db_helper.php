<?php
class DbHelper{


    private $conn;
    private $tableName = "users";

    function createDbConnection(){
try{
    $this->conn = new mysqli("localhost","root","","usersdb");
}catch (Exception $error){
    echo $error->getMessage();

}
    }

    function insertNewUser($name,$colleag){

      try{
          $current_date = date('Y-m-d H:i:s');
          $file_link = $this->saveImage($image);
          $sql = "INSERT INTO $tableName (name,email)VALUES ('$name','$colleag')";
          $result =  $this->conn->query($sql);
          if($result==true){

              $this->createResponse(true,
                  $this->createUserResponse(
                    $this->conn->insert_id,
                      $name,
                  $colleag
                      )
                  );

              }else{
              $this->createResponse(false,"data has not been inserted");

          }

      }catch (Exception $error){
          $this->createResponse(false,$error->getMessage());
      }

    }



    function getAllUsers(){
     try{
         $sql = "select * from $tableName";
         $result = $this->conn->query($sql);

         $count =  $result->num_rows;
         if($count >0){
             $all_users_array = array();
             while ($row = $result->fetch_assoc()){
                 $id = $row["id"];
                 $name = $row["name"];
                 $collage = $row["colleage"];

                  $user_array = $this->createUserResponse($id,$name,$collage);

                 array_push($all_users_array,$user_array);
             }
             $this->createResponse(true,$count,$all_users_array);
         }
         else{
           throw  Exception("No Data Found");
         }
     }catch (Exception $exception){
         $this->createResponse(false,0,array("error"=>$exception->getMessage()));
     }


    }


    function getUserById($id){
        $sql = "select * from $tableName where id = $id";
        $result = $this->conn->query($sql);
        try{
            if($result->num_rows ==0){
                throw new Exception("there are no users with the passed id");
            }
            else{
                $row =   $result->fetch_assoc();
                $id = $row["id"];
                $name = $row["name"];
                $collage = $row["colleage"];
              
             
                $user_array = $this->createUserResponse($id,$name,$collage);
                $this->createResponse(true,1,$user_array);

            }
        }
        catch (Exception $exception){
            http_response_code(400);
            $this->createResponse(false,0,array("error"=>$exception->getMessage()));
        }

    }



    function deleteuser($id){

try{
    $sql = "delete from $tableName where id = $id";

    $result = $this->conn->query($sql);

    if( mysqli_affected_rows($this->conn)>0){
        $this->createResponse(true,1,array("data"=>"user has been deleted"));  
    }else{
        throw new Exception("There are no users with the passed id");
    }
}
catch (Exception $exception){
    $this->createResponse(false,0,array("error"=>$exception->getMessage()));
}
    }



    function updateUser($id,$name,$colleage){
try{


    $query = "UPDATE $tableName SET name='$name', college='$collage' WHERE id='$id'";
 
    $this->conn->query($query);
 
    
    if (mysqli_affected_rows($connection) > 0) {
    
        $this->createResponse(true,1,array("data"=>"user has been updated successfully!"));  
    } else {
         
        $this->createResponse(true,1,array("data"=>"Failed to update data"));  
    }


}
catch (Exception $exception){
    $this->createResponse(false,0,array("error"=>$exception->getMessage()));
}
    }

 

function createResponse($isSuccess,$count,$data){
        echo json_encode(array(
            "success"=>$isSuccess,
            "count"=>$count,
            "data"=>$data
        ));
}
function createUserResponse($name,$colleag,$id){
        return array(
            "id"=>$id,
            "name"=>$name,
            "email"=>$colleag
        );
}
}
?>