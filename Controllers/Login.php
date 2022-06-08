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
						$idperson = $arrData['idperson'];
						$name = $arrData['firstname'].' '.$arrData['lastname'];

						$url_recovery = base_url().'/login/confirmUser/'.$strEmail.'/'.$token;
						$requestUpdate = $this->model->setTokenUser($idperson,$token);

						$dataUsuario = array('nombreUsuario'=> $name, 'email_remitente' => EMAIL_REMITENTE, 'email_usuario'=>$strEmail, 'asunto' =>'Recuperar cuenta','url_recovery' => $url_recovery);


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
				
				$arrResponse = $this->model->getUser($strEmail,$strToken);

				if(empty($arrResponse)){
					header('Location: '.base_url());
				}else{
					
					$data['page_tag'] = "Recovery";
					$data['page_title'] = "Recovery";
					$data['email'] = $strEmail;
					$data['token'] = $strToken;
					$data['page_name'] = "recovery";
					$data['idperson'] = $arrResponse['idperson'];
					$this->views->getView($this,"recovery",$data);
				}
			}
			die();
		}
		public function setPassword(){
			if(empty($_POST['idUser']) || empty($_POST['txtEmail']) || empty($_POST['txtPassword']) || empty($_POST['txtToken']) || empty($_POST['txtPasswordConfirm'])){
				$arrResponse = array('status' => false,'msg' => 'Error de datos');
			}else{
				$idUser = intval($_POST['idUser']);
				$strPassword = strClean($_POST['txtPassword']);
				$strEmail = strClean($_POST['txtEmail']);
				$strToken = strClean($_POST['txtToken']);
				$strPasswordConfirm = strClean($_POST['txtPasswordConfirm']);
				$password = $strPassword;
				if($strPassword != $strPasswordConfirm){
					$arrResponse = array('status' => false,'msg'=>'Las contraseñas no coinciden');
				}else{
					$arrResponseUser = $this->model->getUser($strEmail, $strToken);
					if(empty($arrResponseUser)){
						$arrResponse = array('status' => false,'msg'=>'Error de datos.');
					}else{
						$strPassword = hash("SHA256",$strPassword);
						$requestPass = $this->model->insertPassword($idUser, $strPassword);

						if($requestPass){
                            $data['asunto']="Contraseña actualizada";
                            $data['email_usuario'] = $strEmail;
                            $data['email_remitente'] = EMAIL_REMITENTE;
                            $data['password'] = $password;
                            sendEmail($data,"email_actualizada");
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