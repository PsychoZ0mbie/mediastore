<?php
    require_once("Libraries/Core/Mysql.php");
    trait CustomerTrait{
        private $con;
        private $strName;
        private $strPicture;
        private $strPassword;
        private $intRoleId;

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
    }
    
?>