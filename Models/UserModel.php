<?php 
    class UserModel extends Mysql{
        private $intIdUser;
		private $strName;
        private $strLastName;
		private $strPicture;
		private $intPhone;
		private $strAddress;
		private $strEmail;
        private $intCountryId;
		private $intDepartmentId;
		private $intCityId;
		private $intTypeId;
		private $strIdentification;
		private $strPassword;
		private $strToken;
		private $intRolId;
		private $intStatus;

        public function __construct(){
            parent::__construct();
        }
        public function insertUser(string $strName,string $strLastName, string $strPicture, string $intPhone, string $strEmail, string $strPassword,int $intRolId){

			$this->strName = $strName;
			$this->strLastName = $strLastName;
			$this->intPhone = $intPhone;
			$this->strEmail = $strEmail;
			$this->strPassword = $strPassword;
			$this->intRolId = $intRolId;
            $this->strPicture = $strPicture;
			//$this->intStatus = $status;
			$return = 0;

			$sql = "SELECT * FROM person WHERE 
					email = '{$this->strEmail}' OR phone = '{$this->intPhone}'";
			$request = $this->select_all($sql);

			if(empty($request))
			{ 
				$query_insert  = "INSERT INTO person(image,firstname,lastname,email,phone,password,roleid) 
								  VALUES(?,?,?,?,?,?,?)";
	        	$arrData = array(
                    $this->strPicture,
                    $this->strName,
                    $this->strLastName,
                    $this->strEmail,
                    $this->intPhone,
                    $this->strPassword,
                    $this->intRolId,
        		);
	        	$request_insert = $this->insert($query_insert,$arrData);
	        	$return = $request_insert;
			}else{
				$return = "exist";
			}
	        return $return;
		}
        public function selectUsers(){
            $sql = "SELECT 
                    p.idperson,
                    p.image,
                    p.firstname,
                    p.lastname,
                    p.email,
                    p.phone,
                    p.roleid,
                    DATE_FORMAT(p.date, '%d/%m/%Y') as date,
                    r.idrole,
                    r.name as role
                    FROM person p
                    INNER JOIN role r
                    ON r.idrole = p.roleid 
                    ORDER BY idperson DESC";
            $request = $this->select_all($sql);
            if(count($request)>0){
                for ($i=0; $i < count($request) ; $i++) { 
                    $request[$i]['image'] = media()."/images/uploads/".$request[$i]['image'];
                }
            }
            return $request;
        }
        public function selectRoles(){
            $sql = "SELECT * FROM role ORDER BY idrole ASC";
            $request = $this->select_all($sql);
            return $request;
        }
    }
?>