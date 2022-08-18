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
                $data['app'] = "orders.js";
                $this->views->getView($this,"orders",$data);
            }else{
                header("location: ".base_url());
                die();
            }
        }
        public function order($idOrder){
            if($_SESSION['permitsModule']['r']){
                if(is_numeric($idOrder)){
                    $idPerson ="";
                    if($_SESSION['userData']['roleid'] == 2 ){
                        $idPerson= $_SESSION['idUser'];
                    }
                    $data['orderdata'] = $this->model->selectOrder($idOrder,$idPerson);
                    $data['orderdetail'] = $this->model->selectOrderDetail($idOrder);
                    $data['page_tag'] = "Order";
                    $data['page_title'] = "Order";
                    $data['page_name'] = "order";
                    $this->views->getView($this,"order",$data);
                }else{
                    header("location: ".base_url()."/Orders");
                }
                
            }else{
                header("location: ".base_url());
                die();
            }
        }
        public function transaction($idTransaction){
            if($_SESSION['permitsModule']['r']){
                $idPerson ="";
                if($_SESSION['userData']['roleid'] == 2 ){
                    $idPerson= $_SESSION['idUser'];
                }
                $data['transaction'] = $this->model->selectTransaction($idTransaction,$idPerson);
                $data['page_tag'] = "Transaction";
                $data['page_title'] = "Transaction";
                $data['page_name'] = "transaction";
                $data['app'] = "orders.js";
                $this->views->getView($this,"transaction",$data);
                
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

                        $btnView='<a href="'.base_url().'/orders/order/'.$request[$i]['idorder'].'" class="btn btn-info text-white m-1" type="button" title="View order" name="btnView"><i class="fas fa-eye"></i></a>';
                        $btnPaypal='<a href="'.base_url().'/orders/transaction/'.$request[$i]['idtransaction'].'" class="btn btn-info m-1 text-white " type="button" title="View Transaction" name="btnPaypal"><i class="fab fa-paypal"></i></a>';
                        $btnDelete ="";

                        if($_SESSION['permitsModule']['d'] && $_SESSION['userData']['roleid'] == 1){
                            $btnDelete = '<button class="btn btn-danger text-white m-1" type="button" title="Delete" data-id="'.$request[$i]['idorder'].'" name="btnDelete"><i class="fas fa-trash-alt"></i></button>';
                        }
                        if($_SESSION['userData']['roleid'] == 1){

                            $html.='
                                <tr class="item">
                                    <td>'.$request[$i]['idorder'].'</td>
                                    <td>'.$request[$i]['idtransaction'].'</td>
                                    <td>'.$request[$i]['date'].'</td>
                                    <td>'.formatNum($request[$i]['amount']).'</td>
                                    <td>'.$request[$i]['status'].'</td>
                                    <td class="item-btn">'.$btnView.$btnPaypal.$btnDelete.'</td>
                                </tr>
                            ';
                        }elseif($_SESSION['idUser'] == $request[$i]['personid']){
                            $html.='
                            <tr class="item">
                                <td>'.$request[$i]['idorder'].'</td>
                                <td>'.$request[$i]['idtransaction'].'</td>
                                <td>'.$request[$i]['date'].'</td>
                                <td>'.formatNum($request[$i]['amount']).'</td>
                                <td>'.$request[$i]['status'].'</td>
                                <td class="item-btn">'.$btnView.$btnPaypal.$btnDelete.'</td>
                            </tr>
                        ';
                        }
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
        public function getTransaction(string $idTransaction){
            if($_SESSION['permitsModule']['r'] && $_SESSION['userData']['roleid'] !=2){
                $idTransaction = strClean($idTransaction);
                $request = $this->model->selectTransaction($idTransaction,"");
                if(!empty($request)){
                    $arrResponse = array("status"=>true,"data"=>$request);
                }else{
                    $arrResponse = array("status"=>false,"msg"=>"Data no found.");
                }
                echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
            }
            die();
        }
        public function setRefund(){
            if($_POST){
                if(empty($_POST['idTransaction']) || empty($_POST['txtDescription'])){
                    $arrResponse = array("status"=>false,"msg"=>"Data error.");
                }else{
                    if($_SESSION['permitsModule']['u'] && $_SESSION['userData']['roleid'] !=2){
                        $idTransaction = strClean($_POST['idTransaction']);
                        $strDescription = strClean($_POST['txtDescription']);
                        $request = $this->model->insertRefund($idTransaction,$strDescription);
                        if($request){
                            $arrResponse = array("status"=>true,"msg"=>"Order has been refunded.");
                        }else{
                            $arrResponse = array("status"=>false,"msg"=>"Order can't be refunded.");
                        }
                    }else{
                        $arrResponse = array("status"=>false,"msg"=>"You can't refund it, please contact with your admin.");
                    }
                }
                echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
            }
            die();
        }
        public function delOrder(){
            if($_SESSION['permitsModule']['d']){

                if($_POST){
                    if(empty($_POST['idOrder'])){
                        $arrResponse=array("status"=>false,"msg"=>"Data error");
                    }else{
                        $id = intval($_POST['idOrder']);
                        $request = $this->model->deleteOrder($id);

                        if($request=="ok"){
                            $arrResponse = array("status"=>true,"msg"=>"It has been deleted");
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
        public function search($params){
            $search = strClean($params);
            $request = $this->model->search($params);
            if(count($request)>0){
                $html="";
                for ($i=0; $i < count($request); $i++) { 

                    $btnView='<a href="'.base_url().'/orders/order/'.$request[$i]['idorder'].'" class="btn btn-info text-white m-1" type="button" title="View order" name="btnView"><i class="fas fa-eye"></i></a>';
                    $btnPaypal='<a href="'.base_url().'/orders/transaction/'.$request[$i]['idtransaction'].'" class="btn btn-info m-1 text-white " type="button" title="View Transaction" name="btnPaypal"><i class="fab fa-paypal"></i></a>';
                    $btnDelete ="";

                    if($_SESSION['permitsModule']['d'] && $_SESSION['userData']['roleid'] == 1){
                        $btnDelete = '<button class="btn btn-danger text-white m-1" type="button" title="Delete" data-id="'.$request[$i]['idorder'].'" name="btnDelete"><i class="fas fa-trash-alt"></i></button>';
                    }
                    if($_SESSION['userData']['roleid'] == 1){

                        $html.='
                            <tr class="item">
                                <td>'.$request[$i]['idorder'].'</td>
                                <td>'.$request[$i]['idtransaction'].'</td>
                                <td>'.$request[$i]['date'].'</td>
                                <td>'.formatNum($request[$i]['amount']).'</td>
                                <td>'.$request[$i]['status'].'</td>
                                <td class="item-btn">'.$btnView.$btnPaypal.$btnDelete.'</td>
                            </tr>
                        ';
                    }elseif($_SESSION['idUser'] == $request[$i]['personid']){
                        $html.='
                        <tr class="item">
                            <td>'.$request[$i]['idorder'].'</td>
                            <td>'.$request[$i]['idtransaction'].'</td>
                            <td>'.$request[$i]['date'].'</td>
                            <td>'.formatNum($request[$i]['amount']).'</td>
                            <td>'.$request[$i]['status'].'</td>
                            <td class="item-btn">'.$btnView.$btnPaypal.$btnDelete.'</td>
                        </tr>
                    ';
                    }
                }
                $arrResponse = array("status"=>true,"data"=>$html);
            }else{
                $arrResponse = array("status"=>false,"msg"=>"No data");
            }
            echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
            die();
        }
        public function sort($params){
            $sort = intval($params);
            $request = $this->model->sort($sort);
            if(count($request)>0){
                $html="";
                for ($i=0; $i < count($request); $i++) { 

                    $btnView='<a href="'.base_url().'/orders/order/'.$request[$i]['idorder'].'" class="btn btn-info text-white m-1" type="button" title="View order" name="btnView"><i class="fas fa-eye"></i></a>';
                    $btnPaypal='<a href="'.base_url().'/orders/transaction/'.$request[$i]['idtransaction'].'" class="btn btn-info m-1 text-white " type="button" title="View Transaction" name="btnPaypal"><i class="fab fa-paypal"></i></a>';
                    $btnDelete ="";

                    if($_SESSION['permitsModule']['d'] && $_SESSION['userData']['roleid'] == 1){
                        $btnDelete = '<button class="btn btn-danger text-white m-1" type="button" title="Delete" data-id="'.$request[$i]['idorder'].'" name="btnDelete"><i class="fas fa-trash-alt"></i></button>';
                    }
                    if($_SESSION['userData']['roleid'] == 1){

                        $html.='
                            <tr class="item">
                                <td>'.$request[$i]['idorder'].'</td>
                                <td>'.$request[$i]['idtransaction'].'</td>
                                <td>'.$request[$i]['date'].'</td>
                                <td>'.formatNum($request[$i]['amount']).'</td>
                                <td>'.$request[$i]['status'].'</td>
                                <td class="item-btn">'.$btnView.$btnPaypal.$btnDelete.'</td>
                            </tr>
                        ';
                    }elseif($_SESSION['idUser'] == $request[$i]['personid']){
                        $html.='
                        <tr class="item">
                            <td>'.$request[$i]['idorder'].'</td>
                            <td>'.$request[$i]['idtransaction'].'</td>
                            <td>'.$request[$i]['date'].'</td>
                            <td>'.formatNum($request[$i]['amount']).'</td>
                            <td>'.$request[$i]['status'].'</td>
                            <td class="item-btn">'.$btnView.$btnPaypal.$btnDelete.'</td>
                        </tr>
                    ';
                    }
                }
                $arrResponse = array("status"=>true,"data"=>$html);
            }else{
                $arrResponse = array("status"=>false,"msg"=>"No data");
            }
            echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
            die();
        }
    }
?>