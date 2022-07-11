<?php
    
    require_once("Models/ProductTrait.php");
    require_once("Models/CategoryTrait.php");
    require_once("Models/CustomerTrait.php");
    require_once("Models/LoginModel.php");
    class Shop extends Controllers{
        use ProductTrait, CategoryTrait, CustomerTrait;
        private $login;
        public function __construct(){
            session_start();
            parent::__construct();
            $this->login = new LoginModel();
        }

        public function shop(){
            $data['page_tag'] = NOMBRE_EMPRESA;
            $data['page_title'] = NOMBRE_EMPRESA;
            $data['page_name'] = "home";
            $this->views->getView($this,"home",$data);
        }

        public function addWishList(){
            if($_POST){
                if(isset($_SESSION['login'])){
                    $idProduct = openssl_decrypt($_POST['idProduct'],METHOD,KEY);
                    if(is_numeric($idProduct)){
                        $request = $this->addWishListT($idProduct,$_SESSION['idUser']);
                        if($request>0){
                            $arrResponse = array("status"=>true);
                        }else if("exists"){
                            $arrResponse = array("status"=>false);
                        }else{
                            $arrResponse = array("status"=>false);
                        }
                    }
                }else{
                    $arrResponse = array("status"=>false);
                }
                echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
            }
            die();
        }
        public function delWishList(){
            if($_POST){
                if(isset($_SESSION['login'])){
                    $idProduct = openssl_decrypt($_POST['idProduct'],METHOD,KEY);
                    if(is_numeric($idProduct)){
                        $request = $this->delWishListT($idProduct,$_SESSION['idUser']);
                        if($request>0){
                            $arrResponse = array("status"=>true);
                        }else{
                            $arrResponse = array("status"=>false);
                        }
                    }
                }else{
                    $arrResponse = array("status"=>false);
                }
                echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
            }
            die();
        }
        public function validCustomer(){
            if($_POST){
				if(empty($_POST['txtSignName']) || empty($_POST['txtSignEmail']) || empty($_POST['txtSignPassword'])){
                    $arrResponse=array("status" => false, "msg" => "Data error");
                }else{
                    $strName = ucwords(strClean($_POST['txtSignName']));
                    $strEmail = strtolower(strClean($_POST['txtSignEmail']));
                    $code = code(); 
                    $dataUsuario = array('nombreUsuario'=> $strName, 
                                        'email_remitente' => EMAIL_REMITENTE, 
                                        'email_usuario'=>$strEmail, 
                                        'asunto' =>'Verification code - '.NOMBRE_REMITENTE,
                                        'codigo' => $code);
                    $_SESSION['code'] = $code;
                    $sendEmail = sendEmail($dataUsuario,'email_validData');
                    if($sendEmail){
                        $arrResponse = array("status"=>true,"msg"=>" code has been sent to your email to validate your data.");
                        
                    }else{
                        $arrResponse = array("status"=>false,"msg"=>"Error, try again.");
                    }
                }
                echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);

			}
			die();
        }
		public function setCustomer(){
			if($_POST){
				if(empty($_POST['txtSignName']) || empty($_POST['txtSignEmail']) || empty($_POST['txtSignPassword']) || empty($_POST['txtCode'])){
                    $arrResponse=array("status" => false, "msg" => "Data error");
                }else{
                    if($_POST['txtCode'] == $_SESSION['code']){
                        unset($_SESSION['code']);
                        $strName = ucwords(strClean($_POST['txtSignName']));
                        $strEmail = strtolower(strClean($_POST['txtSignEmail']));
                        $strPassword = hash("SHA256",$_POST['txtSignPassword']);
                        $strPicture = "user.jpg";
                        $rolid = 2;

                        $request = $this->setCustomerT($strName,$strPicture,$strEmail,$strPassword,$rolid);
                        
                        if($request > 0){
                            $_SESSION['idUser'] = $request;
                            $_SESSION['login'] = true;
                            
                            $arrData = $this->login->sessionLogin($_SESSION['idUser']);
                            sessionUser($_SESSION['idUser']);
    
                            $arrResponse = array("status" => true,"msg"=>"You have successfully registered.");
                        }else if($request =="exist"){
                            $arrResponse = array("status" => false,"msg"=>"The user already exists, please log in.");
                        }else{
                            $arrResponse = array("status" => false,"msg"=>"Unable to store data, try later.");
    
                        }
                    }else{
                        $arrResponse = array("status" => false,"msg"=>"Incorrect code, try again.");
                    }

                }
                echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);

			}
			die();
		}
    }
?>