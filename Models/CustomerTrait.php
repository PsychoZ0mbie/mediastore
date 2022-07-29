<?php
    require_once("Libraries/Core/Mysql.php");
    trait CustomerTrait{
        private $con;
        private $strName;
        private $strPicture;
        private $strPassword;
        private $intRoleId;
        private $intIdUser;
        private $strIdTransaction;
        private $strCoupon;
        private $intIdOrder;
        private $strFirstName;
        private $strLastName;
        private $strEmail;
        private $strPhone;
        private $strCountry;
        private $strState;
        private $strCity;
        private $strAddress;
        private $strPostalCode;

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
                    $sql = "INSERT INTO usedcoupon(couponid,personid,code,status) VALUE(?,?,?,?)";
                    $arrData = array($idCoupon,$this->intIdUser,$this->strCoupon,1);
                    $request= $this->con->insert($sql,$arrData);
                    $return = $data;
                }else{
                    $return="exists";
                }
            }
            return $return;
        }
        public function checkCoupon($idUser){
            $this->con = new Mysql();
            $this->intIdUser = $idUser;
            $sql = "SELECT * FROM usedcoupon WHERE personid = $this->intIdUser AND status = 1";
            $request = $this->con->select($sql);
            $data=array();
            if(!empty($request)){
                $id = $request['couponid'];
                $code = $request['code'];
                $sql = "SELECT * FROM coupon WHERE code = '$code' AND status = 1";
                $request = $this->con->select($sql);
                if(!empty($request)){
                    $data['id'] = $id;
                    $data['code'] = $code;
                    $data['discount']=$request['discount'];
                }
            }
            return $data;
        }
        public function updateCoupon($idUser,$code){
            $this->con = new Mysql();
            $this->intIdUser = $idUser;
            $sql = "UPDATE usedcoupon SET status=? WHERE personid = $this->intIdUser AND code = '$code'";
            $arrData = array(2);
            $request = $this->con->update($sql,$arrData);
            return;
        }
        /*public function insertDetailTemp(array $arrOrder){
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
        }*/
        public function insertOrder($idUser,$idTransaction,$dataPaypal,$firstname,$lastname,$email,$phone,$country,$state,$city,$address,
        $postalCode,$note,$total,$idCoupon,$status){

            $this->con = new Mysql();
            $this->strIdTransaction = $idTransaction;
            $this->intIdUser = $idUser;
            $this->strFirstName = $firstname;
            $this->strLastName = $lastname;
            $this->strEmail = $email;
            $this->strPhone = $phone;
            $this->strCountry = $country;
            $this->strState = $state;
            $this->strCity = $city;
            $this->strPostalCode = $postalCode;
            $this->strAddress=$address;

            $sql ="INSERT INTO orderdata(personid,idtransaction,paypaldata,firstname,lastname,email,phone,address,country,state,city,postalcode,note,amount,couponid,status) VALUE(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
            $arrData = array(
                $this->intIdUser, 
                $this->strIdTransaction,
                $dataPaypal,
                $this->strFirstName,
                $this->strLastName,
                $this->strEmail,
                $this->strPhone,
                $this->strAddress,
                $this->strCountry,
                $this->strState,
                $this->strCity,
                $this->strPostalCode,
                $note,
                $total,
                $idCoupon,
                $status);
            $request = $this->con->insert($sql,$arrData);
            return $request;
        }
        public function insertOrderDetail(array $arrOrder){
            $this->con = new Mysql();
            $this->intIdUser = $arrOrder['iduser'];
            $this->intIdOrder = $arrOrder['idorder'];
            $products = $arrOrder['products'];

            foreach ($products as $pro) {
                $price=0;
                if($pro['discount']>0){
                    $price = $pro['price']-($pro['price']*($pro['discount']*0.01));
                }else{
                    $price = $pro['price'];
                }
                $query = "INSERT INTO orderdetail(orderid,personid,productid,name,quantity,price)
                        VALUE(?,?,?,?,?,?)";
                $arrData=array($this->intIdOrder,
                                $this->intIdUser,
                                openssl_decrypt($pro['idproduct'],METHOD,KEY),
                                $pro['name'],
                                $pro['qty'],
                                $price);
                $request = $this->con->insert($query,$arrData);
            }
            return $request;
        }
        public function getOrder($idOrder){
            $this->con = new Mysql();
            $this->intIdOrder =$idOrder;
            $sql = "SELECT idorder,
                    idtransaction,
                    firstname,
                    lastname,
                    email,
                    phone,
                    address,
                    country,
                    state,
                    city,
                    postalcode,
                    note,
                    amount,
                    DATE_FORMAT(date, '%d/%m/%Y') as date,
                    status
                    FROM orderdata WHERE idorder = $this->intIdOrder";
            $order = $this->con->select($sql);
            if(!empty($order)){
                $sql = "SELECT * FROM orderdetail WHERE orderid = $this->intIdOrder";
                $detail = $this->con->select_all($sql);
                $arrData = array("order"=>$order,"detail"=>$detail);
            }   
            return $arrData;
        }
        
    }
    
?>