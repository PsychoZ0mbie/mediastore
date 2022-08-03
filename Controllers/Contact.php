<?php
    require_once("Models/CustomerTrait.php");
    class Contact extends Controllers{
        use CustomerTrait;
        public function __construct(){
            parent::__construct();
            session_start();
        }

        public function contact(){
            $data['page_tag'] = "Contact | ".NOMBRE_EMPRESA;
			$data['page_title'] = "Contact | ".NOMBRE_EMPRESA;
			$data['page_name'] = "contact";
            $this->views->getView($this,"contact",$data);
        }
        public function setContact(){
            if($_POST){
                if(empty($_POST['txtContactName']) || empty($_POST['txtContactEmail']) || empty($_POST['txtContactMessage'])){
                    $arrResponse = array("status"=>true,"msg"=>"Data error");
                }else{

                    $strName = ucwords(strClean($_POST['txtContactName']));
                    $strEmail = strtolower(strClean($_POST['txtContactEmail']));
                    $strMessage = strClean($_POST['txtContactMessage']);
    
                    $request = $this->setMessage($strName,$strEmail,$strMessage);
                    if($request > 0){
                        $dataEmail = array('email_remitente' => EMAIL_REMITENTE, 
                                                'email_usuario'=>$strEmail, 
                                                'email_copia'=>EMAIL_REMITENTE,
                                                'asunto' =>'You have sent a new message.',
                                                "message"=>$strMessage,
                                                'name'=>$strName);
                        sendEmail($dataEmail,'email_contact');
                        $arrResponse = array("status"=>true,"msg"=>"We have received your message, we will contact you soon.");
                    }else{
                        $arrResponse = array("status"=>false,"msg"=>"Oops! an error has ocurred. Try again");
                    }
                }
                echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
            }
            die();
        }
    }
?>