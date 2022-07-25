<?php
    require_once("Libraries/Core/Mysql.php");
    trait CustomerTrait{
        private $con;
        private $strName;
        private $strPicture;
        private $strPassword;
        private $intRoleId;
        private $intIdUser;
        private $intIdTransaction;
        private $strCoupon;

        public function setCustomerT($strName,$strPicture,$strEmail,$strPassword,$rolid){
            $this->con = new Mysql();
            $this->strNombre = $strName;
            $this->strPicture = $strPicture; 
            $this->strEmail =  $strEmail;
            $this->strPassword = $strPassword;
            $this->intRolId = $rolid;
            $return="";
            
            $sql = "SELECT * FROM person WHERE email = '$this->strEmail'";
            $request = $this->con->select_all($sql);
            if(empty($request)){
                $query = "INSERT INTO person(firstname,image,email,countryid,stateid,cityid,password,roleid) VALUE(?,?,?,?,?,?,?,?)";
                $arrData = array($this->strNombre,
                                $this->strPicture,
                                $this->strEmail,
                                99999,
                                99999,
                                99999,
                                $this->strPassword,
                                $this->intRolId
                                );
                $request_insert = $this->con->insert($query,$arrData);
                $return = $request_insert;
            }else{
                $return ="exist";
            }
            return $return;
        }
        public function selectCountries(){
            $this->con = new Mysql();
            $sql = "SELECT * FROM countries";
            $request = $this->con->select_all($sql);
            return $request;
        }
        public function selectStates($country){
            $this->con = new Mysql();
            $sql = "SELECT * FROM states WHERE country_id = $country";
            $request = $this->con->select_all($sql);
            return $request;
        }
        public function selectCities($state){
            $this->con = new Mysql();
            $sql = "SELECT * FROM cities WHERE state_id = $state";
            $request = $this->con->select_all($sql);
            return $request;
        }
        public function setCouponCodeT($idUser,$strCoupon){
            $this->con = new Mysql();
            $this->intIdUser = $idUser;
            $this->strCoupon = $strCoupon;
            $return="";
            $sql = "SELECT * FROM coupon WHERE code = '$this->strCoupon' AND status = 1";
            $request = $this->con->select_all($sql);
            if(!empty($request)){
                $idCoupon = $request[0]['id'];
                $data = array("code"=>$request[0]['code'],"discount"=>$request[0]['discount']);
                $sql = "SELECT * FROM usedcoupon WHERE code = '$this->strCoupon' AND personid= $this->intIdUser";
                $request = $this->con->select_all($sql);
                if(empty($request)){
                    $sql = "INSERT INTO usedcoupon(couponid,personid,code) VALUE(?,?,?)";
                    $arrData = array($idCoupon,$this->intIdUser,$this->strCoupon);
                    $request= $this->con->insert($sql,$arrData);
                    $return = $data;
                }else{
                    $return="exists";
                }
            }
            return $return;
        }
        public function insertDetailTemp(array $arrOrder){
            $this->con = new Mysql();
            $this->intIdUser = $arrOrder['idcustomer'];
            $this->intIdTransaction = $arrOrder['idtransaction'];
            $products = $arrOrder['products'];
            $sql = "SELECT * FROM tempdetail
                    WHERE personid=$this->intIdUser 
                    AND transactionid = '$this->intIdTransaction'";
            $request = $this->con->select_all($sql);
            if(empty($request)){
                foreach ($products as $pro) {
                    $query = "INSERT INTO tempdetail(personid,productid,transactionid,quantity,price)
                            VALUE(?,?,?,?,?)";
                    $arrData=array($this->intIdUser,
                                    openssl_decrypt($pro['idproduct'],METHOD,KEY),
                                    $this->intIdTransaction,
                                    $pro['qty'],
                                    $pro['price']);
                    $requestPro = $this->con->insert($query,$arrData);
                }
            }else{
                $sqlDel = "DELETE FROM tempdetail
                    WHERE personid = $this->intIdUser 
                    AND transactionid = '$this->intIdTransaction'";
                $requestDel = $this->con->delete($sqlDel);
                foreach ($products as $pro) {
                    $query = "INSERT INTO tempdetail(personid,productid,transactionid,quantity,price)
                            VALUE(?,?,?,?,?)";
                    $arrData=array($this->intIdUser,
                                    openssl_decrypt($pro['idproduct'],METHOD,KEY),
                                    $this->intIdTransaction,
                                    $pro['qty'],
                                    $pro['price']);
                    $requestPro = $this->con->insert($query,$arrData);
                }
            }
        }
        
    }
    
?>