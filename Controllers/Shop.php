<?php
    
    require_once("Models/ProductTrait.php");
    require_once("Models/CategoryTrait.php");
    require_once("Models/LoginModel.php");
    class Shop extends Controllers{
        use ProductTrait, CategoryTrait;
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
        public function loginUser(){
            if($_POST){
				if(empty($_POST['txtEmail']) || empty($_POST['txtPassword'])){
					$arrResponse = array('status' => false, 'msg' => 'Data error' );
				}else{
					$strUser  =  strtolower(strClean($_POST['txtEmail']));
					$strPassword = hash("SHA256",$_POST['txtPassword']);
					$requestUser = $this->login->loginUser($strUser, $strPassword);
					if(empty($requestUser)){
						$arrResponse = array('status'=>false, 'msg'=> 'User or password is incorrect.');
					}else{
						$arrData =$requestUser;
						if($arrData['status']==1){
							$_SESSION['idUser'] = $arrData['idperson'];
							$_SESSION['login'] = true;
	
							$arrData = $this->login->sessionLogin($_SESSION['idUser']);
							sessionUser($_SESSION['idUser']);
							$arrResponse = array('status'=>true);
						}else{
							$arrResponse = array('status'=>false, 'msg'=> "User isn't active.");
						}
					}
				}
				echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
			}
			die();
        }
    }
?>