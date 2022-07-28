<?php 
    class OrdersModel extends Mysql{
        private $intIdOrder;
        public function __construct(){
            parent::__construct();
        }
        /*************************Category methods*******************************/

        public function selectOrders(){
            $sql = "SELECT * ,DATE_FORMAT(date, '%d/%m/%Y') as date FROM orderdata ORDER BY idorder DESC";       
            $request = $this->select_all($sql);
            return $request;
        }
        public function selectOrder($id){
            $this->intIdOrder = $id;
            $sql = "SELECT * ,DATE_FORMAT(date, '%d/%m/%Y') as date FROM orderdata WHERE idorder = $this->intIdOrder";
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
        /*public function selectCategory($id){
            $this->intIdCategory = $id;
            $sql = "SELECT * FROM category WHERE idcategory = $this->intIdCategory";
            $request = $this->select($sql);
            return $request;
        }*/
    }
?>