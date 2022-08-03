<?php 
    class StoreModel extends Mysql{
        private $intIdCoupon;
		private $strCode;
        private $intDiscount;
		private $intStatus;
        private $strMessage;
        private $intIdMessage;
        private $strEmail;
        private $strSubject;

        public function __construct(){
            parent::__construct();
        }
        /*************************Coupon methods*******************************/
        public function insertCoupon(string $strName, int $discount, int $intStatus){

			$this->strCode = $strName;
			$this->intDiscount = $discount;
			$this->intStatus = $intStatus;

			$return = 0;
			$sql = "SELECT * FROM coupon WHERE 
					code = '{$this->strCode}'";
			$request = $this->select_all($sql);

			if(empty($request))
			{ 
				$query_insert  = "INSERT INTO coupon(code,discount,status) 
								  VALUES(?,?,?)";
	        	$arrData = array(
                    $this->strCode,
                    $this->intDiscount,
                    $this->intStatus
        		);
	        	$request_insert = $this->insert($query_insert,$arrData);
	        	$return = $request_insert;
			}else{
				$return = "exist";
			}
	        return $return;
		}
        public function updateCoupon(int $intIdCoupon,string $strName, int $discount, int $intStatus){
            $this->intIdCoupon = $intIdCoupon;
            $this->strCode = $strName;
			$this->intDiscount = $discount;
			$this->intStatus = $intStatus;

			$sql = "SELECT * FROM coupon WHERE code = '{$this->strCode}' AND id != $this->intIdCoupon";
			$request = $this->select_all($sql);

			if(empty($request)){

                $sql = "UPDATE coupon SET code=?, discount=?, status=?, updatedate=NOW() WHERE id = $this->intIdCoupon";
                $arrData = array(
                    $this->strCode,
                    $this->intDiscount,
                    $this->intStatus
                );
				$request = $this->update($sql,$arrData);
			}else{
				$request = "exist";
			}
			return $request;
		
		}
        public function deleteCoupon($id){
            $this->intIdCoupon = $id;
                $sql = "DELETE FROM coupon WHERE id = $this->intIdCoupon";
                $request = $this->delete($sql);
            return $request;
        }
        public function selectCoupons(){
            $sql = "SELECT 
            id,
            code,
            discount,
            status,
            DATE_FORMAT(date, '%d/%m/%Y') as date,
            DATE_FORMAT(updatedate, '%d/%m/%Y') as dateupdate
            FROM coupon 
            ORDER BY id ASC";       
            $request = $this->select_all($sql);
            return $request;
        }
        public function selectCoupon($id){
            $this->intIdCoupon = $id;
            $sql = "SELECT * FROM coupon WHERE id = $this->intIdCoupon";
            $request = $this->select($sql);
            return $request;
        }
        /*************************Mailbox methods*******************************/
        public function selectMails(){
            $sql = "SELECT * ,DATE_FORMAT(date, '%d/%m/%Y') as date FROM contact ORDER BY id DESC";       
            $request = $this->select_all($sql);
            return $request;
        }
        public function selectMail(int $id){
            $sql = "UPDATE contact SET status=? WHERE id = $id";
            $arrData = array(1);
            $request = $this->update($sql,$arrData);
            $sql = "SELECT *, DATE_FORMAT(date, '%d/%m/%Y') as date FROM contact WHERE id=$id";
            $request = $this->select($sql);
            return $request;
        }
        public function selectReplies(int $id){
            $sql = "SELECT *,DATE_FORMAT(date, '%d/%m/%Y') as date FROM contactreply WHERE contactid=$id";
            $request = $this->select_all($sql);
            return $request;
        }
        public function insertReply($strMessage,$idMessage){
            $this->strMessage = $strMessage;
            $this->intIdMessage = $idMessage;

            $sql = "INSERT INTO contactreply(contactid,reply) VALUES(?,?)";
            $arrData = array($this->intIdMessage,$this->strMessage);
            $request = $this->insert($sql,$arrData);
            return $request;
        }
        public function insertMessage($strSubject,$strEmail,$strMessage){
            $this->strMessage = $strMessage;
            $this->strEmail = $strEmail;
            $this->strSubject = $strSubject;

            $sql = "INSERT INTO sendmessage(email,subject,message) VALUES(?,?,?)";
            $arrData = array($this->strEmail,$this->strSubject,$this->strMessage);
            $request = $this->insert($sql,$arrData);
            return $request;
        }
    }
?>