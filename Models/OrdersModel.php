<?php 
    class OrdersModel extends Mysql{
        private $intIdOrder;
        private $intIdUser;
        private $intIdTransaction;
        public function __construct(){
            parent::__construct();
        }
        /*************************Category methods*******************************/

        public function selectOrders(){
            $sql = "SELECT * ,DATE_FORMAT(date, '%d/%m/%Y') as date FROM orderdata ORDER BY idorder DESC";       
            $request = $this->select_all($sql);
            return $request;
        }
        public function selectOrder($id,$idPerson){
            $this->intIdOrder = $id;
            $this->intIdUser = $idPerson;
            $option="";
            if($idPerson !=""){
                $option =" AND personid = $this->intIdUser";
            }
            $sql = "SELECT * ,DATE_FORMAT(date, '%d/%m/%Y') as date FROM orderdata WHERE idorder = $this->intIdOrder $option";
            $request = $this->select($sql);
            return $request;
        }
        public function selectOrderDetail($id){
            $this->intIdOrder = $id;
            $sql = "SELECT * FROM orderdetail WHERE orderid = $this->intIdOrder";
            $request = $this->select_all($sql);
            return $request;
        }
        public function selectCoupon($id){
            $sql = "SELECT * FROM coupon WHERE id = $id";
            $request = $this->select($sql);
            return $request;
        }
        public function selectTransaction(string $intIdTransaction,$idPerson){
            $objTransaction = array();
            $this->intIdUser = $idPerson;
            $this->intIdTransaction = $intIdTransaction;

            $option="";
            if($idPerson !=""){
                $option =" AND personid = $this->intIdUser";
            }

            $sql = "SELECT * FROM orderdata WHERE idtransaction = '$this->intIdTransaction' $option";
            $request = $this->select($sql);
            if(!empty($request)){
                $objData = json_decode($request['paypaldata']);
                //dep($objData);exit;
                //$urlTransaction ="https://api.sandbox.paypal.com/v2/payments/captures/".$this->intIdTransaction;
                $urlOrder =$objData->links[0]->href;
                $objTransaction = curlConnectionGet($urlOrder,"application/json",getTokenPaypal());
                //dep($objTransaction);exit;
            }
            return $objTransaction;
        }
        public function insertRefund($idTransaction,$strDescription){
            $response = false;
            $this->intIdTransaction = $idTransaction;
            //href: "https://api.sandbox.paypal.com/v2/payments/captures/9PA67488FV4531342/refund"
            $sql = "SELECT idorder,paypaldata FROM orderdata WHERE idtransaction = '$this->intIdTransaction'";
            $request = $this->select($sql);
            if(!empty($request)){
                //$objData = $request['paypaldata'];
                $urlRefund = "https://api.sandbox.paypal.com/v2/payments/captures/".$this->intIdTransaction."/refund";
                $objData = curlConnectionPost($urlRefund,"application/json",getTokenPaypal());
                if(isset($objData->status) && $objData->status =="COMPLETED"){
                    $idorder = $request['idorder'];
                    $idTransaction = $objData->id;
                    $dataRefund = json_encode($objData);
                    $status = $objData->status;
                    $sqlRefund = "INSERT INTO refund(orderid,idtransaction,datarefund,description,status) VALUES(?,?,?,?,?)";
                    $arrData = array(
                        $idorder,
                        $idTransaction,
                        $dataRefund,
                        $strDescription,
                        $status
                    );
                    $requestRefund = $this->insert($sqlRefund,$arrData);
                    if($requestRefund >0){
                        $sql = "UPDATE orderdata SET status=? WHERE idorder = $idorder";
                        $arrData = array("REFUNDED");
                        $request = $this->update($sql,$arrData);
                        $response = true;
                    }
                }
            }
            return $response;

        }
        /*public function selectCategory($id){
            $this->intIdCategory = $id;
            $sql = "SELECT * FROM category WHERE idcategory = $this->intIdCategory";
            $request = $this->select($sql);
            return $request;
        }*/
    }
?>