<?php 

	class Login extends Controllers{
		public function __construct()
		{
			session_start();
			session_regenerate_id(true);
			if(isset($_SESSION['login'])){
				header('Location: '.base_url()."/dashboard");
				die();
			}
			parent::__construct();
		}

		public function login(){
		
			$data['page_tag'] = "Login";
			$data['page_title'] = "Login";
            $data['page_name'] = "login";
			$this->views->getView($this,"login",$data);
		}

		public function loginUser(){
			if($_POST){
				if(empty($_POST['txtEmail']) || empty($_POST['txtPassword'])){
					$arrResponse = array('status' => false, 'msg' => 'Error de datos' );
				}else{
					$strUser  =  strtolower(strClean($_POST['txtEmail']));
					$strPassword = hash("SHA256",$_POST['txtPassword']);
					$requestUser = $this->model->loginUser($strUser, $strPassword);
					if(empty($requestUser)){
						$arrResponse = array('status'=>false, 'msg'=> 'El usuario o la contraseña es incorrecto.');
					}else{
						$arrData =$requestUser;
						$_SESSION['idUser'] = $arrData['idperson'];
						$_SESSION['login'] = true;

						$arrData = $this->model->sessionLogin($_SESSION['idUser']);
						sessionUser($_SESSION['idUser']);

						$arrResponse = array('status'=>true, 'msg'=> 'Sesión iniciada.');
					}
				}
				echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
			}
			
			die();
		}
		public function resetPass(){
			if($_POST){
				if(empty($_POST['txtEmailReset'])){
					$arrResponse = array('status' => false, 'msg' => 'Error de datos');
				}else{
					$token = token();
					$strEmail = strtolower(strClean($_POST['txtEmailReset']));
					$arrData = $this->model->getUserEmail($strEmail);

					if(empty($arrData)){
						$arrResponse = array('status' => false, 'msg' => 'El usuario no existe');
					}else{
						$idpersona = $arrData['id_person'];
						$nombreUsuario = $arrData['first_name'].' '.$arrData['last_name'];

						$url_recovery = base_url().'/login/confirmUser/'.$strEmail.'/'.$token;
						$requestUpdate = $this->model->setTokenUser($idpersona,$token);

						$dataUsuario = array('nombreUsuario'=> $nombreUsuario, 'email_remitente' => EMAIL_REMITENTE, 'email_usuario'=>$strEmail, 'asunto' =>'Recuperar cuenta - '.NOMBRE_REMITENTE,'url_recovery' => $url_recovery);


						if($requestUpdate){
							
							$sendEmail = sendEmail($dataUsuario, 'email_cambioPassword');

							if($sendEmail){
								$arrResponse = array('status' => true, 'msg' => 'Se ha enviado un correo para cambiar la contraseña');
								
							}else{
								$arrResponse = array('status' => false, 'msg' => 'No es posible realizar el proceso, intenta más tarde.');
							}
							
						}else{
							$arrResponse = array('status' => false, 'msg' => 'No es posible realizar el proceso, intenta más tarde.');
						}
					}
				}
				echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
			}
			die();
		}
		public function confirmUser(string $params){

			if(empty($params)){
				header('Location: '.base_url());
			}else{
				$arrParams = explode(',',$params);
				$strEmail = strClean($arrParams[0]);
				$strToken = strClean($arrParams[1]);
				
				$arrResponse = $this->model->getUsuario($strEmail,$strToken);

				if(empty($arrResponse)){
					header('Location: '.base_url());
				}else{
					
					$data['page_tag'] = "Cambiar contraseña | DigitalBlog";
					$data['page_title'] = "Cambiar contraseña | DigitalBlog";
					$data['email'] = $strEmail;
					$data['token'] = $strToken;
					$data['page_name'] = "cambiar_contraseña";
					$data['id_person'] = $arrResponse['id_person'];
					$data['page_functions'] = "functions_login.js";
					$this->views->getView($this,"cambiar_password",$data);
				}
			}
			die();
		}
		public function setPassword(){
			if(empty($_POST['idUsuario']) || empty($_POST['txtEmailRecuperar']) || empty($_POST['txtPasswordRecuperar']) || empty($_POST['txtToken']) || empty($_POST['txtPasswordConfirmRecuperar'])){
				$arrResponse = array('status' => false,'msg' => 'Error de datos');
			}else{
				$intIdpersona = intval($_POST['idUsuario']);
				$strPassword = $_POST['txtPasswordRecuperar'];
				$strEmail = strClean($_POST['txtEmailRecuperar']);
				$strToken = strClean($_POST['txtToken']);
				$strPasswordConfirm = $_POST['txtPasswordConfirmRecuperar'];

				if($strPassword != $strPasswordConfirm){
					$arrResponse = array('status' => false,'msg'=>'Las contraseñas no coinciden');
				}else{
					$arrResponseUser = $this->model->getUsuario($strEmail, $strToken);
					if(empty($arrResponseUser)){
						$arrResponse = array('status' => false,'msg'=>'Error de datos.');
					}else{
						$strPassword = hash("SHA256",$strPassword);
						$requestPass = $this->model->insertPassword($intIdpersona, $strPassword);

						if($requestPass){
							$arrResponse = array('status' => true, 'msg' => 'Contraseña actualizada');
						}else{
							$arrResponse = array('status' => false, 'msg' => 'No es posible realizar el proceso, intente más tarde.');
						}
					}
				}
			}
			echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
			die();
		}

	}
 ?>