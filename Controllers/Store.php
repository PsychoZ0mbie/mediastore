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
    }
?>