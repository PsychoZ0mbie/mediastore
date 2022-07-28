<?php
    class Orders extends Controllers{
        public function __construct(){
            session_start();
            if(empty($_SESSION['login'])){
                header("location: ".base_url());
                die();
            }
            parent::__construct();
            getPermits(6);
        }

        public function orders(){
            if($_SESSION['permitsModule']['r']){
                $data['page_tag'] = "Orders";
                $data['page_title'] = "Orders";
                $data['page_name'] = "orders";
                $this->views->getView($this,"orders",$data);
            }else{
                header("location: ".base_url());
                die();
            }
        }
        public function order($params){
            if($_SESSION['permitsModule']['r']){
                if(is_numeric($params)){
                    $id = intval($params);
                    $data['orderdata'] = $this->model->selectOrder($id);
                    $data['orderdetail'] = $this->model->selectOrderDetail($id);
                    $data['coupon'] = $this->model->selectCoupon($data['orderdata']['couponid']);
                    $data['page_tag'] = "Order";
                    $data['page_title'] = "Order";
                    $data['page_name'] = "order";
                    $this->views->getView($this,"order",$data);
                }else{
                    header("location: ".base_url());
                    die();
                }
                
            }else{
                header("location: ".base_url());
                die();
            }
        }
        public function getOrders(){
            if($_SESSION['permitsModule']['r']){
                $html="";
                $request = $this->model->selectOrders();
                if(count($request)>0){
                    for ($i=0; $i < count($request); $i++) { 

                        $btnView='<button class="btn btn-info m-1" type="button" title="View" data-id="'.$request[$i]['idorder'].'" name="btnView"><i class="fas fa-eye"></i></button>';
                        $btnPrint='<button class="btn btn-danger m-1" type="button" title="Print" data-id="'.$request[$i]['idorder'].'" name="btnPrint"><i class="fas fa-file-pdf"></i></button>';
                        $btnPaypal='<button class="btn btn-info m-1" type="button" title="Paypal" data-id="'.$request[$i]['idorder'].'" name="btnPaypal"><i class="fab fa-paypal"></i></button>';;
                        $btnDelete ="";
                        if($_SESSION['permitsModule']['d']){
                            $btnDelete = '<button class="btn btn-danger m-1" type="button" title="Delete" data-id="'.$request[$i]['idorder'].'" name="btnDelete"><i class="fas fa-trash-alt"></i></button>';
                        }
                        $html.='
                            <tr class="item">
                                <td><strong>Id: </strong>'.$request[$i]['idorder'].'</td>
                                <td><strong>Transaction: </strong>'.$request[$i]['idtransaction'].'</td>
                                <td><strong>Date: </strong>'.$request[$i]['date'].'</td>
                                <td><strong>Amount: </strong>'.formatNum($request[$i]['amount']).'</td>
                                <td><strong>Status: </strong>'.$request[$i]['status'].'</td>
                                <td class="item-btn">'.$btnView.$btnPrint.$btnPaypal.$btnDelete.'</td>
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
    }
?>