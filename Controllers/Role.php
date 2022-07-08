<?php
    class Role extends Controllers{
        public function __construct(){
            session_start();
            if(empty($_SESSION['login'])){
                header("location: ".base_url()."/logout");
                die();
            }
            parent::__construct();
            getPermits(2);
        }
        public function role(){
            if($_SESSION['idUser'] == 1){
                $data['page_tag'] = "Role";
                $data['page_title'] = "Roles";
                $data['page_name'] = "role";
                $this->views->getView($this,"role",$data);
            }else{
                header("location: ".base_url()."/logout");
                die();
            }
        }
        public function setRole(){
            if($_SESSION['idUser'] == 1){
                if($_POST){
                    if(empty($_POST['txtName'])){
                        $arrResponse = array("status"=>false,"msg"=>"Data error");
                    }else{
    
                        $idRol = intval($_POST['idRol']);
                        $strName = ucwords(strClean($_POST['txtName']));
                        if($idRol == 0){
                            $option = 1;
                            $request = $this->model->insertRole($strName);
                        }else{
                            $option = 2;
                            $request = $this->model->updateRole($idRol,$strName);
                        }
                        if($request>0){
                            if($option==1){
                                $arrResponse = array("status"=>true,"msg"=>"Data saved");
                            }else{
                                $arrResponse = array("status"=>true,"msg"=>"Data updated");
                            }
                        }else if ($request=="exist"){
                            $arrResponse = array("status" =>false,"msg"=>"¡Warning! The role already exists, try another name."); 
                        }else{
                            $arrResponse = array("status" =>false,"msg"=>"Data error"); 
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
            if($_SESSION['idUser'] == 1){
                $html="";
                $request = $this->model->selectRoles();
                if(count($request)>0){
                    for ($i=0; $i < count($request); $i++) { 
                        $html.='
                            <tr class="item" data-name="'.$request[$i]['name'].'">
                                <td>'.$request[$i]['name'].'</td>
                                <td class="item-btn">
                                    <button class="btn btn-secondary" type="button" title="Permits" data-id="'.$request[$i]['idrole'].'" name="btnPermit"><i class="fas fa-key"></i></button>
                                    <button class="btn btn-success" type="button" title="Edit" data-id="'.$request[$i]['idrole'].'" name="btnEdit"><i class="fas fa-pencil-alt"></i></button>
                                    <button class="btn btn-danger" type="button" title="Delete" data-id="'.$request[$i]['idrole'].'" name="btnDelete"><i class="fas fa-trash-alt"></i></button> 
                                </td>
                            </tr>
                        ';
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
        public function getRole(){
            if($_SESSION['idUser'] == 1){
                if($_POST){
                    if(empty($_POST['idRol'])){
                        $arrResponse = array("status"=>false,"msg"=>"Data error");
                    }else{
                        $idRol = intval($_POST['idRol']);
                        $request = $this->model->selectRole($idRol);
                        if(!empty($request)){
                            $arrResponse = array("status"=>true,"data"=>$request);
                        }else{
                            $arrResponse = array("status"=>false,"msg"=>"Data error");
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
        public function delRole(){
            if($_SESSION['idUser'] == 1){
                if($_POST){
                    if(empty($_POST['idRol'])){
                        $arrResponse=array("status"=>false,"Data error");
                    }else{
                        $id = intval($_POST['idRol']);
                        $request = $this->model->deleteRole($id);
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
        public function getPermits(){
            if($_SESSION['idUser']==1){

                if($_POST['idRol']){
                    $id = intval($_POST['idRol']);
                    $arrModules = $this->model->selectModules();
                    $arrPermits = $this->model->selectPermits($id);
                    $arrResponse = array(
                        "module"=>$arrModules,
                        "permit"=>$arrPermits
                    );
                    echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
                }
            }else{
                header("location: ".base_url()."/logout");
                die(); 
            }
            die();
        }
        public function setPermits(){
            if($_SESSION['idUser'] == 1){
                if($_POST){
                    $arrPermits = json_decode($_POST['permits'],true);
                    $idRole = intval($_POST['idRol']);
                    $request="";
                    $request = $this->model->deletePermits($idRole);
                    for ($i=0; $i < count($arrPermits); $i++) { 
                        $idmodule = $arrPermits[$i][0];
                        $r = $arrPermits[$i][1];
                        $w = $arrPermits[$i][2];
                        $u = $arrPermits[$i][3];
                        $d = $arrPermits[$i][4];
                        $request = $this->model->insertPermits($idRole,$idmodule,$r,$w,$u,$d);
                    }
                    if($request>0){
                        $arrResponse = array("status"=>true,"msg"=>"Permits updated");
                    }else{
                        $arrResponse = array("status"=>false,"msg"=>"Could not update permissions, try again.");
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