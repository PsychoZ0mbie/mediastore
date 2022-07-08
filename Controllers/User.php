<?php
    class User extends Controllers{

        public function __construct(){
            session_start();
            if(empty($_SESSION['login'])){
                header("location: ".base_url()."/logout");
                die();
            }
            parent::__construct();
            getPermits(2);
        }
        public function user(){
            if($_SESSION['permitsModule']['r']){
                $data['page_tag'] = "User";
                $data['page_title'] = "Users";
                $data['page_name'] = "user";
                $this->views->getView($this,"user",$data);
            }else{
                header("location: ".base_url()."/logout");
                die();
            }
        }
        public function getUsers(){
            if($_SESSION['permitsModule']['r']){
                $html="";
                $request = $this->model->selectUsers();
                if(count($request)>0){
                    for ($i=0; $i < count($request); $i++) { 

                        $btnEdit="";
                        $btnDelete="";
                        $btnView = '<button class="btn btn-info m-1" type="button" title="Watch" data-id="'.$request[$i]['idperson'].'" name="btnView"><i class="fas fa-eye"></i></button>';
                        
                        if($_SESSION['permitsModule']['u'] && $request[$i]['roleid'] != 1 || $_SESSION['idUser'] == 1){
                            $btnEdit = '<button class="btn btn-success m-1" type="button" title="Edit" data-id="'.$request[$i]['idperson'].'" name="btnEdit"><i class="fas fa-pencil-alt"></i></button>';
                        }
                        if($_SESSION['permitsModule']['d'] && $request[$i]['roleid'] != 1 || $_SESSION['idUser'] == 1){
                            $btnDelete = '<button class="btn btn-danger m-1" type="button" title="Delete" data-id="'.$request[$i]['idperson'].'" name="btnDelete"><i class="fas fa-trash-alt"></i></button>';
                        }
                        if($request[$i]['status']==1){
                            $status='<span class="badge me-1 bg-success">Active</span>';
                        }else{
                            $status='<span class="badge me-1 bg-danger">Inactive</span>';
                        }
                        if($request[$i]['idperson'] != 1){
                            $html.='
                                <tr class="item" data-name="'.$request[$i]['firstname'].'" data-lastname="'.$request[$i]['lastname'].'" data-email="'.$request[$i]['email'].'">
                                    <td>
                                        <img src="'.$request[$i]['image'].'">
                                    </td>
                                    <td><strong>First name: </strong>'.$request[$i]['firstname'].'</td>
                                    <td><strong>Last name: </strong>'.$request[$i]['lastname'].'</td>
                                    <td><strong>Email: </strong>'.$request[$i]['email'].'</td>
                                    <td><strong>Phone: </strong>'.$request[$i]['phone'].'</td>
                                    <td><strong>Date: </strong>'.$request[$i]['date'].'</td>
                                    <td><strong>Role: </strong>'.$request[$i]['role'].'</td>
                                    <td><strong>Status: </strong>'.$status.'</td>
                                    <td class="item-btn">'.$btnView.$btnEdit.$btnDelete.'</td>
                                </tr>
                            ';
                        }
                    }
                    $arrResponse = array("status"=>true,"data"=>$html);
                }else{
                    $arrResponse = array("status"=>false,"msg"=>"No hay datos");
                }
                echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
            }else{
                header("location: ".base_url()."/logout");
                die();
            }
            
            die();
        }
        public function getUser(){
            if($_SESSION['permitsModule']['r']){

                if($_POST){
                    if(empty($_POST)){
                        $arrResponse = array("status"=>false,"msg"=>"Data error");
                    }else{
                        $idUser = intval($_POST['idUser']);
                        $request = $this->model->selectUser($idUser);
                        if(!empty($request)){
                            $request['image'] = media()."/images/uploads/".$request['image'];
                            $arrResponse = array("status"=>true,"data"=>$request);
                        }else{
                            $arrResponse = array("status"=>false,"msg"=>"Error, try again."); 
                        }
                    }
                    echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
                }
            }else{
                header("location: ".base_url()."/logout");
                die();
            }
            die();
        }
        public function setUser(){
            if($_SESSION['permitsModule']['r']){
                if($_POST){
                    if(empty($_POST['txtFirstName']) || empty($_POST['txtLastName']) || empty($_POST['txtPhone']) || empty($_POST['typeList'] ) || empty($_POST['statusList'] )
                    || empty($_POST['txtEmail'])){
                        $arrResponse = array("status" => false, "msg" => 'Data error');
                    }else{ 
                        $idUser = intval($_POST['idUser']);
                        $strName = ucwords(strClean($_POST['txtFirstName']));
                        $strLastName = ucwords(strClean($_POST['txtLastName']));
                        $intPhone = intval(strClean($_POST['txtPhone']));
                        $strEmail = strtolower(strClean($_POST['txtEmail']));
                        $strPassword = strClean($_POST['txtPassword']);
                        $intRolId = intval(strClean($_POST['typeList']));
                        $intStatus = intval($_POST['statusList']);
                        $password =$strPassword;
                        $request_user = "";
                        $photo = "";
                        $photoProfile="";
    
                        
                        
                        if($idUser == 0){
                            if($_SESSION['permitsModule']['w']){

                                $option = 1;

                                if($_FILES['txtImg']['name'] == ""){
                                    $photoProfile = "user.jpg";
                                }else{
                                    $photo = $_FILES['txtImg'];
                                    $photoProfile = 'profile_'.bin2hex(random_bytes(6)).'.png';
                                }

                                if($strPassword !=""){
                                    $strPassword =  hash("SHA256",$strPassword);
                                }else{
                                    $password =bin2hex(random_bytes(4));
                                    $strPassword =  hash("SHA256",$password);
                                }

                                $request_user = $this->model->insertUser(
                                    $strName, 
                                    $strLastName,
                                    $photoProfile, 
                                    $intPhone, 
                                    $strEmail,
                                    $strPassword,
                                    $intStatus,
                                    $intRolId
                                );
                            }
                        }else{
                            if($_SESSION['permitsModule']['u']){

                                $option = 2;
                                $request = $this->model->selectUser($idUser);

                                if($_FILES['txtImg']['name'] == ""){
                                    $photoProfile = $request['image'];
                                }else{
                                    if($request['image'] != "user.jpg"){
                                        deleteFile($request['image']);
                                    }
                                    $photo = $_FILES['txtImg'];
                                    $photoProfile = 'profile_'.bin2hex(random_bytes(6)).'.png';
                                }

                                if($strPassword!=""){
                                    $strPassword =  hash("SHA256",$strPassword);
                                }
                                
                                $request_user = $this->model->updateUser(
                                    $idUser, 
                                    $strName, 
                                    $strLastName,
                                    $photoProfile, 
                                    $intPhone, 
                                    $strEmail,
                                    $strPassword, 
                                    $intStatus,
                                    $intRolId
                                );
                            }
                        }
    
                        if($request_user > 0 ){
                            if($photo!=""){
                                uploadImage($photo,$photoProfile);
                            }
                            
                            if($option == 1){
                                $data['nombreUsuario'] = $strName." ".$strLastName;
                                $data['asunto']="Credentials";
                                $data['email_usuario'] = $strEmail;
                                $data['email_remitente'] = EMAIL_REMITENTE;
                                $data['password'] = $password;
                                sendEmail($data,"email_credentials");
                                $arrResponse = array('status' => true, 'msg' => 'Data saved. An e-mail has been sent to the user with the credentials.');
                            }else{
                                if($strPassword!=""){
                                    $data['nombreUsuario'] = $strName." ".$strLastName;
                                    $data['asunto']="Credentials";
                                    $data['email_usuario'] = $strEmail;
                                    $data['email_remitente'] = EMAIL_REMITENTE;
                                    $data['password'] = $password;
                                    sendEmail($data,"email_passwordUpdated");
                                    $arrResponse = array('status' => true, 'msg' => 'Password has been updated, an email with the new password has been sent.');
                                }else{
                                    $arrResponse = array('status' => true, 'msg' => 'Data saved.');
                                }
                                
                            }
                        }else if($request_user == 'exist'){
                            $arrResponse = array('status' => false, 'msg' => '¡Warning! the email or phone number is already registered, try another one.');		
                        }else{
                            $arrResponse = array("status" => false, "msg" => 'It is not possible to store the data.');
                        }
                    }
                    echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
                }
            }else{
                header("location: ".base_url()."/logout");
                die();
            }
			die();
		}
        public function getRoles(){
            $html="";
            $request = $this->model->selectRoles();
            if(count($request)>0){
                for ($i=0; $i < count($request); $i++) { 
                    if($_SESSION['idUser'] == 1){
                        $html.='<option value="'.$request[$i]['idrole'].'">'.$request[$i]['name'].'</option>';
                    }else if($request[$i]['idrole'] != 1){
                        $html.='<option value="'.$request[$i]['idrole'].'">'.$request[$i]['name'].'</option>';
                    }
                }
                $arrResponse = array("data"=>$html);
            }else{
                $arrResponse = array("data"=>"");
            }
            echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
            die();
        }
        public function delUser(){
            if($_SESSION['permitsModule']['d']){

                if($_POST){
                    if(empty($_POST['idUser'])){
                        $arrResponse=array("status"=>false,"Data error");
                    }else{
                        $id = intval($_POST['idUser']);
                        
                        $request = $this->model->selectUser($id);
                        if($request['image'] !="user.jpg"){
                            deleteFile($request['image']);
                        }

                        $request = $this->model->deleteUser($id);
                        if($request=="ok"){
                            $arrResponse = array("status"=>true,"msg"=>"It has been deleted");
                        }else{
                            $arrResponse = array("status"=>false,"msg"=>"It has not been possible to delete, try again.");
                        }
                    }
                    echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
                }
            }else{
                header("location: ".base_url()."/logout");
                die();
            }
            die();
        }
    }
?>