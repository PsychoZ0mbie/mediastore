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
                $data['page_title'] = "Usuarios";
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
                        $btnView = '<button class="btn btn-info m-1" type="button" title="Ver" data-id="'.$request[$i]['idperson'].'" name="btnView"><i class="fas fa-eye"></i></button>';
                        
                        if($_SESSION['permitsModule']['u'] && $request[$i]['roleid'] != 1 || $_SESSION['idUser'] == 1){
                            $btnEdit = '<button class="btn btn-success m-1" type="button" title="Editar" data-id="'.$request[$i]['idperson'].'" name="btnEdit"><i class="fas fa-pencil-alt"></i></button>';
                        }
                        if($_SESSION['permitsModule']['d'] && $request[$i]['roleid'] != 1 || $_SESSION['idUser'] == 1){
                            $btnDelete = '<button class="btn btn-danger m-1" type="button" title="Eliminar" data-id="'.$request[$i]['idperson'].'" name="btnDelete"><i class="fas fa-trash-alt"></i></button>';
                        }
                        if($request[$i]['idperson'] != 1){
                            $html.='
                                <tr class="item" data-name="'.$request[$i]['firstname'].'" data-lastname="'.$request[$i]['lastname'].'" data-email="'.$request[$i]['email'].'">
                                    <td>
                                        <img src="'.$request[$i]['image'].'">
                                    </td>
                                    <td><strong>Nombre: </strong>'.$request[$i]['firstname'].'</td>
                                    <td><strong>Apellido: </strong>'.$request[$i]['lastname'].'</td>
                                    <td><strong>Correo: </strong>'.$request[$i]['email'].'</td>
                                    <td><strong>Teléfono: </strong>'.$request[$i]['phone'].'</td>
                                    <td><strong>Fecha de registro: </strong>'.$request[$i]['date'].'</td>
                                    <td><strong>Rol: </strong>'.$request[$i]['role'].'</td>
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
                        $arrResponse = array("status"=>false,"msg"=>"Error de datos");
                    }else{
                        $idUser = intval($_POST['idUser']);
                        $request = $this->model->selectUser($idUser);
                        if(!empty($request)){
                            $request['image'] = media()."/images/uploads/".$request['image'];
                            $arrResponse = array("status"=>true,"data"=>$request);
                        }else{
                            $arrResponse = array("status"=>false,"msg"=>"Ha ocurrido un error, inténtelo de nuevo."); 
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
                    if(empty($_POST['txtFirstName']) || empty($_POST['txtLastName']) || empty($_POST['txtPhone']) || empty($_POST['typeList']) 
                    || empty($_POST['txtEmail'])){
                        $arrResponse = array("status" => false, "msg" => 'Datos incorrectos.');
                    }else{ 
                        $idUser = intval($_POST['idUser']);
                        $strName = ucwords(strClean($_POST['txtFirstName']));
                        $strLastName = ucwords(strClean($_POST['txtLastName']));
                        $intPhone = intval(strClean($_POST['txtPhone']));
                        $strEmail = strtolower(strClean($_POST['txtEmail']));
                        $strPassword = strClean($_POST['txtPassword']);
                        $intRolId = intval(strClean($_POST['typeList']));
                        $password =$strPassword;
                        $request_user = "";
                        $photo = "";
                        $photoProfile="";
    
                        if($strPassword !=""){
                            $strPassword =  hash("SHA256",$strPassword);
                        }else{
                            $password =bin2hex(random_bytes(4));
                            $strPassword =  hash("SHA256",$password);
                        }
                        
                        if($idUser == 0){
                            if($_SESSION['permitsModule']['w']){

                                $option = 1;
                                if($_FILES['txtImg']['name'] == ""){
                                    $photoProfile = "user.jpg";
                                }else{
                                    $photo = $_FILES['txtImg'];
                                    $photoProfile = 'profile_'.bin2hex(random_bytes(6)).'.png';
                                }
                                $request_user = $this->model->insertUser(
                                    $strName, 
                                    $strLastName,
                                    $photoProfile, 
                                    $intPhone, 
                                    $strEmail,
                                    $strPassword, 
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
                                    $strPassword =  hash("SHA256",$_POST['txtPassword']);
                                }
                                
                                $request_user = $this->model->updateUser(
                                    $idUser, 
                                    $strName, 
                                    $strLastName,
                                    $photoProfile, 
                                    $intPhone, 
                                    $strEmail,
                                    $strPassword, 
                                    $intRolId
                                );
                            }
                        }
    
                        if($request_user > 0 ){
                            if($photo!=""){
                                uploadImage($photo,$photoProfile);
                            }
                            $data['nombreUsuario'] = $strName." ".$strLastName;
                            $data['asunto']="Acceso a cuenta de usuario";
                            $data['email_usuario'] = $strEmail;
                            $data['email_remitente'] = EMAIL_REMITENTE;
                            $data['password'] = $password;
                            sendEmail($data,"email_bienvenida");
                            if($option == 1){
                                
                                $arrResponse = array('status' => true, 'msg' => 'Datos guardados. Se ha enviado un correo al usuario con las credenciales.');
                            }else{
                                $arrResponse = array('status' => true, 'msg' => 'Datos Actualizados correctamente.');
                            }
                        }else if($request_user == 'exist'){
                            $arrResponse = array('status' => false, 'msg' => '¡Atención! el email ó el teléfono ya está registrado, ingrese otro.');		
                        }else{
                            $arrResponse = array("status" => false, "msg" => 'No es posible almacenar los datos.');
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
                        $arrResponse=array("status"=>false,"Error de datos");
                    }else{
                        $id = intval($_POST['idUser']);
                        $request = $this->model->deleteUser($id);
                        if($request=="ok"){
                            $arrResponse = array("status"=>true,"msg"=>"Se ha eliminado");
                        }else{
                            $arrResponse = array("status"=>false,"msg"=>"No se ha podido eliminar, inténtelo de nuevo.");
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