<?php
    class User extends Controllers{

        public function __construct(){
            parent::__construct();
        }
        public function user(){
            $data['page_tag'] = "User";
            $data['page_title'] = "User";
            $data['page_name'] = "user";
            $this->views->getView($this,"user",$data);
        }
        public function getUsers(){
            $html="";
            $request = $this->model->selectUsers();
            if(count($request)>0){
                for ($i=0; $i < count($request); $i++) { 
                    $html.='
                        <tr class="item" data-name="'.$request[$i]['firstname'].'" data-lastname="'.$request[$i]['lastname'].'" data-email="'.$request[$i]['email'].'">
                            <td>
                                <img src="'.$request[$i]['image'].'">
                            </td>
                            <td>'.$request[$i]['firstname'].'</td>
                            <td>'.$request[$i]['lastname'].'</td>
                            <td>'.$request[$i]['email'].'</td>
                            <td>'.$request[$i]['phone'].'</td>
                            <td>'.$request[$i]['date'].'</td>
                            <td>'.$request[$i]['role'].'</td>
                            <td class="item-btn">
                                <button class="btn btn-info" type="button" title="Ver" data-id="'.$request[$i]['idperson'].'" name="btnView"><i class="fas fa-eye"></i></button>
                                <button class="btn btn-success" type="button" title="Editar" data-id="'.$request[$i]['idperson'].'" name="btnEdit"><i class="fas fa-pencil-alt"></i></button>
                                <button class="btn btn-danger" type="button" title="Eliminar" data-id="'.$request[$i]['idperson'].'" name="btnDelete"><i class="fas fa-trash-alt"></i></button> 
                            </td>
                        </tr>
                    ';
                }
                $arrResponse = array("status"=>true,"data"=>$html);
            }else{
                $arrResponse = array("status"=>false,"msg"=>"No hay datos");
            }
            echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
            die();
        }
        public function setUser(){
            //dep($_POST);exit;
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
                    
                    
                    if($idUser == 0){
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
                        
                        $request_user = $this->model->insertUser($strName, 
                                                                    $strLastName,
                                                                    $photoProfile, 
                                                                    $intPhone, 
                                                                    $strEmail,
                                                                    $strPassword, 
                                                                    $intRolId);
                    }else{
                        $option = 2;
                        $request = $this->model->selectUsuario($idUsuario);
                        if($_FILES['txtImg']['name'] == ""){
                            $foto_perfil = $request['picture'];
                        }else{
                            if($request['picture'] != "avatar.png"){
                                deleteFile($request['picture']);
                            }
                            $foto = $_FILES['txtImg'];
                            $foto_perfil = 'perfil_'.bin2hex(random_bytes(6)).'.gif';
                        }
                        $strPassword =  hash("SHA256",$_POST['txtPassword']);
                        $request_user = $this->model->updateUsuario($idUsuario, 
                                                                    $strNombre,
                                                                    $strApellido,
                                                                    $foto_perfil, 
                                                                    $intTelefono, 
                                                                    $strEmail,
                                                                    $strPassword, 
                                                                    $intTipoId);

                    }

                    if($request_user > 0 ){
                        if($photo!=""){
                            uploadImage($photo,$photoProfile);
                        }
                        if($option == 1){
                            $data['nombreUsuario'] = $strName." ".$strLastName;
                            $data['asunto']="Acceso a cuenta de usuario";
                            $data['email_usuario'] = $strEmail;
                            $data['email_remitente'] = EMAIL_REMITENTE;
                            $data['password'] = $password;
                            sendEmail($data,"email_bienvenida");
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
			die();
		}
        public function getRoles(){
            $html="";
            $request = $this->model->selectRoles();
            if(count($request)>0){
                for ($i=0; $i < count($request); $i++) { 
                    $html.='<option value="'.$request[$i]['idrole'].'">'.$request[$i]['name'].'</option>';
                }
                $arrResponse = array("data"=>$html);
            }else{
                $arrResponse = array("data"=>"");
            }
            echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
            die();
        }
    }
?>