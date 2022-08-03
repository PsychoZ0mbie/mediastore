<?php
    class Store extends Controllers{
        public function __construct(){
            session_start();
            if(empty($_SESSION['login'])){
                header("location: ".base_url());
                die();
            }
            parent::__construct();
            getPermits(5);
        }

        /*************************Views*******************************/
        public function coupon(){
            if($_SESSION['permitsModule']['r']){
                $data['page_tag'] = "Coupons";
                $data['page_title'] = "Coupons";
                $data['page_name'] = "coupon";
                $this->views->getView($this,"coupon",$data);
            }else{
                header("location: ".base_url());
                die();
            }
        }
        public function mailbox(){
            if($_SESSION['permitsModule']['r']){
                $data['inbox'] = $this->getMails();
                $data['sent'] = $this->getSentMails();
                $data['page_tag'] = "Mailbox";
                $data['page_title'] = "Mailbox";
                $data['page_name'] = "mailbox";
                $this->views->getView($this,"mailbox",$data);
            }else{
                header("location: ".base_url());
                die();
            }
        }
        public function message($params){
            if($_SESSION['permitsModule']['r']){
                if(is_numeric($params)){
                    $id = intval($params);
                    $data['message'] = $this->model->selectMail($id);
                    $data['replies'] = $this->model->selectReplies($id);
                    $data['page_tag'] = "Message";
                    $data['page_title'] = "Message";
                    $data['page_name'] = "message";
                    $this->views->getView($this,"message",$data);
                }else{
                    header("location: ".base_url()."/store/mailbox");
                    die();
                }
            }else{
                header("location: ".base_url());
                die();
            }
        }
        public function sent($params){
            if($_SESSION['permitsModule']['r']){
                if(is_numeric($params)){
                    $id = intval($params);
                    $data['message'] = $this->model->selectSentMail($id);
                    $data['page_tag'] = "Sent message";
                    $data['page_title'] = "Sent message";
                    $data['page_name'] = "sent";
                    $this->views->getView($this,"sent",$data);
                }else{
                    header("location: ".base_url()."/store/mailbox");
                    die();
                }
            }else{
                header("location: ".base_url());
                die();
            }
        }
        /*************************Coupon methods*******************************/
        public function getCoupons(){
            if($_SESSION['permitsModule']['r']){
                $html="";
                $request = $this->model->selectCoupons();
                if(count($request)>0){
                    for ($i=0; $i < count($request); $i++) { 

                        $status="";
                        $btnEdit="";
                        $btnDelete="";
                        
                        if($_SESSION['permitsModule']['u']){
                            $btnEdit = '<button class="btn btn-success m-1" type="button" title="Edit" data-id="'.$request[$i]['id'].'" name="btnEdit"><i class="fas fa-pencil-alt"></i></button>';
                        }
                        if($_SESSION['permitsModule']['d']){
                            $btnDelete = '<button class="btn btn-danger m-1" type="button" title="Delete" data-id="'.$request[$i]['id'].'" name="btnDelete"><i class="fas fa-trash-alt"></i></button>';
                        }
                        if($request[$i]['status']==1){
                            $status='<span class="badge me-1 bg-success">Active</span>';
                        }else{
                            $status='<span class="badge me-1 bg-danger">Inactive</span>';
                        }
                        $html.='
                            <tr class="item" data-name="'.$request[$i]['code'].'">
                                <td><strong>Code: </strong>'.$request[$i]['code'].'</td>
                                <td><strong>Discount: </strong>'.$request[$i]['discount'].'%</td>
                                <td><strong>Status: </strong>'.$status.'</td>
                                <td><strong>Date created: </strong>'.$request[$i]['date'].'</td>
                                <td><strong>Date updated: </strong>'.$request[$i]['dateupdate'].'</td>
                                <td class="item-btn">'.$btnEdit.$btnDelete.'</td>
                            </tr>
                        ';
                    }
                    $arrResponse = array("status"=>true,"data"=>$html);
                }else{
                    $arrResponse = array("status"=>false,"msg"=>"No data");
                }
                echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
            }else{
                header("location: ".base_url());
                die();
            }
            
            die();
        }
        public function getCoupon(){
            if($_SESSION['permitsModule']['r']){

                if($_POST){
                    if(empty($_POST)){
                        $arrResponse = array("status"=>false,"msg"=>"Data error");
                    }else{
                        $idCoupon = intval($_POST['idCoupon']);
                        $request = $this->model->selectCoupon($idCoupon);
                        if(!empty($request)){
                            $arrResponse = array("status"=>true,"data"=>$request);
                        }else{
                            $arrResponse = array("status"=>false,"msg"=>"Error, try again."); 
                        }
                    }
                    echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
                }
            }else{
                header("location: ".base_url());
                die();
            }
            die();
        }
        public function setCoupon(){
            if($_SESSION['permitsModule']['r']){
                if($_POST){
                    if(empty($_POST['txtName']) || empty($_POST['statusList']) || empty($_POST['intDiscount'])){
                        $arrResponse = array("status" => false, "msg" => 'Data error');
                    }else{ 
                        $idCoupon = intval($_POST['idCoupon']);
                        $strCode = strtoupper(strClean($_POST['txtName']));
                        $intDiscount = intval(strClean($_POST['intDiscount']));
                        $intStatus = intval(strClean($_POST['statusList']));

                        if($idCoupon == 0){
                            if($_SESSION['permitsModule']['w']){
                                $option = 1;
                                $request= $this->model->insertCoupon($strCode,$intDiscount,$intStatus);
                            }
                        }else{
                            if($_SESSION['permitsModule']['u']){
                                $option = 2;
                                $request = $this->model->updateCoupon($idCoupon,$strCode,$intDiscount,$intStatus);
                            }
                        }
                        if($request > 0 ){
                            if($option == 1){
                                $arrResponse = array('status' => true, 'msg' => 'Data saved.');
                            }else{
                                $arrResponse = array('status' => true, 'msg' => 'Data updated.');
                            }
                        }else if($request == 'exist'){
                            $arrResponse = array('status' => false, 'msg' => '¡Warning! Coupon already exists, try another code.');		
                        }else{
                            $arrResponse = array("status" => false, "msg" => 'It is not possible to store the data.');
                        }
                    }
                    echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
                }
            }else{
                header("location: ".base_url());
                die();
            }
			die();
		}
        public function delCoupon(){
            if($_SESSION['permitsModule']['d']){

                if($_POST){
                    if(empty($_POST['idCoupon'])){
                        $arrResponse=array("status"=>false,"msg"=>"Data error");
                    }else{
                        $id = intval($_POST['idCoupon']);
                        $request = $this->model->deleteCoupon($id);
                        if($request=="ok"){
                            $arrResponse = array("status"=>true,"msg"=>"It has been delete");
                        }else{
                            $arrResponse = array("status"=>false,"msg"=>"It has not been possible to delete, try again.");
                        }
                        
                    }
                    echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
                }
            }else{
                header("location: ".base_url());
                die();
            }
            die();
        }
        /*************************Mailbox methods*******************************/
        public function getMails(){
            if($_SESSION['permitsModule']['r']){
                $html="";
                $total = 0;
                $request = $this->model->selectMails();
                if(count($request)>0){
                    for ($i=0; $i < count($request); $i++) { 
                        $status ="";
                        $url = base_url()."/store/message/".$request[$i]['id'];
                        if($request[$i]['status'] == 1){
                            $status="text-black-50";
                        }else{
                            $total++;
                        }
                        $html.='
                        <div class="mail-item '.$status.'">
                            <div class="row position-relative">
                                <div class="col-4">
                                    <p class="m-0 mail-info">'.$request[$i]['name'].'</p>
                                </div>
                                <div class="col-4">
                                    <p class="mail-info">'.$request[$i]['subject'].'</p>
                                </div>
                                <div class="col-4">
                                    <p class="m-0">'.$request[$i]['date'].'</p>
                                </div>
                                <a href="'.$url.'" class="position-absolute w-100 h-100"></a>
                            </div>
                        </div>
                        ';
                    }
                    $arrResponse = array("status"=>true,"data"=>$html,"total"=>$total);
                }else{
                    $arrResponse = array("status"=>false,"msg"=>"No data");
                }
            }
            return $arrResponse;
        }
        public function setReply(){
            if($_POST){
                if(empty($_POST['txtMessage']) || empty($_POST['idMessage']) || empty($_POST['txtEmail']) || empty($_POST['txtName'])){
                    $arrResponse = array("status"=>false,"msg"=>"Data error");
                }else{
                    $strMessage = strClean($_POST['txtMessage']);
                    $idMessage = intval($_POST['idMessage']);
                    $strEmail = strClean(strtolower($_POST['txtEmail']));
                    $strName = strClean(ucwords($_POST['txtName']));
                    $request = $this->model->insertReply($strMessage,$idMessage);

                    if($request>0){
                        $dataEmail = array('email_remitente' => EMAIL_REMITENTE, 
                                                'email_usuario'=>$strEmail,
                                                'asunto' =>'Replying your message.',
                                                "message"=>$strMessage,
                                                'name'=>$strName);
                        sendEmail($dataEmail,'email_reply');
                        $arrResponse = array("status"=>true,"msg"=>"Replied"); 
                    }else{
                        $arrResponse = array("status"=>false,"msg"=>"An error has ocurred, try again.");
                    }
                }
                echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
            }
            die();
        }
        public function sendEmail(){
            if($_POST){
                if(empty($_POST['txtMessage']) ||  empty($_POST['txtEmail'])){
                    $arrResponse = array("status"=>false,"msg"=>"Data error");
                }else{
                    $strMessage = strClean($_POST['txtMessage']);
                    $strEmail = strClean(strtolower($_POST['txtEmail']));
                    $strEmailCC = strClean(strtolower($_POST['txtEmailCC']));
                    $strSubject = $_POST['txtSubject'] !="" ? strClean(($_POST['txtSubject'])) : "You have sent an email.";
                    $request = $this->model->insertMessage($strSubject,$strEmail,$strMessage);
                    if($request>0){
                        $dataEmail = array('email_remitente' => EMAIL_REMITENTE, 
                                                'email_copia'=>$strEmailCC,
                                                'email_usuario'=>$strEmail,
                                                'asunto' =>$strSubject,
                                                "message"=>$strMessage);
                        sendEmail($dataEmail,'email_sent');
                        $arrResponse = array("status"=>true,"msg"=>"Message has been sent."); 
                    }else{
                        $arrResponse = array("status"=>false,"msg"=>"An error has ocurred, try again.");
                    }
                }
                echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
            }   
            die();
        }
        public function getSentMails(){
            if($_SESSION['permitsModule']['r']){
                $html="";
                $request = $this->model->selectSentMails();
                if(count($request)>0){
                    for ($i=0; $i < count($request); $i++) { 
                        $status ="";
                        $total = 0;
                        $email = explode("@",$request[$i]['email']);
                        $url = base_url()."/store/sent/".$request[$i]['id'];
                        $html.='
                        <div class="mail-item text-black-50">
                            <div class="row position-relative">
                                <div class="col-4">
                                    <p class="m-0 mail-info">'.$email[0].'</p>
                                </div>
                                <div class="col-4">
                                    <p class="mail-info">'.$request[$i]['subject'].'</p>
                                </div>
                                <div class="col-4">
                                    <p class="m-0">'.$request[$i]['date'].'</p>
                                </div>
                                <a href="'.$url.'" class="position-absolute w-100 h-100"></a>
                            </div>
                        </div>
                        ';
                    }
                    $arrResponse = array("status"=>true,"data"=>$html,"total"=>$total);
                }else{
                    $arrResponse = array("status"=>false,"msg"=>"No data");
                }
            }
            return $arrResponse;
        }
    }
?>