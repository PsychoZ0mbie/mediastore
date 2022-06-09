<?php 
    class CategoryModel extends Mysql{
        private $intIdCategory;
        private $intIdSubCategory;
		private $strName;
		private $intStatus;
        private $strRoute;

        public function __construct(){
            parent::__construct();
        }
        /*************************Category methods*******************************/
        public function insertCategory(string $strName, int $intStatus,string $strRoute){

			$this->strName = $strName;
			$this->intStatus = $intStatus;
			$this->strRoute = $strRoute;

			$return = 0;

			$sql = "SELECT * FROM category WHERE 
					name = '{$this->strName}'";
			$request = $this->select_all($sql);

			if(empty($request))
			{ 
				$query_insert  = "INSERT INTO category(name,status,route) 
								  VALUES(?,?,?)";
	        	$arrData = array(
                    $this->strName,
                    $this->intStatus,
                    $this->strRoute
        		);
	        	$request_insert = $this->insert($query_insert,$arrData);
	        	$return = $request_insert;
			}else{
				$return = "exist";
			}
	        return $return;
		}
        public function updateCategory(int $intIdCategory, string $strName,int $intStatus,string $strRoute){
            $this->intIdCategory = $intIdCategory;
            $this->strName = $strName;
			$this->intStatus = $intStatus;
			$this->strRoute = $strRoute;

			$sql = "SELECT * FROM category WHERE name = '{$this->strName}' AND idcategory != $this->intIdCategory";
			$request = $this->select_all($sql);

			if(empty($request)){

                $sql = "UPDATE category SET name=?, status=?, route=? WHERE idcategory = $this->intIdCategory";
                $arrData = array(
                    $this->strName,
                    $this->intStatus,
                    $this->strRoute
                );
				$request = $this->update($sql,$arrData);
			}else{
				$request = "exist";
			}
			return $request;
		
		}
        public function deleteCategory($id){
            $this->intIdCategory = $id;
            $sql = "SELECT * FROM subcategory WHERE categoryid = $this->intIdCategory";
            $request = $this->select_all($sql);
            $return = "";
            if(empty($request)){

                $sql = "DELETE FROM category WHERE idcategory = $this->intIdCategory;SET @autoid :=0; 
                UPDATE category SET idcategory = @autoid := (@autoid+1);
                ALTER TABLE category Auto_Increment = 1";
                $return = $request = $this->delete($sql);
            }else{
                $return="exist";
            }
            return $return;
        }
        public function selectCategories(){
            $sql = "SELECT * FROM category ORDER BY idcategory ASC";       
            $request = $this->select_all($sql);
            return $request;
        }
        public function selectCategory($id){
            $this->intIdCategory = $id;
            $sql = "SELECT * FROM category WHERE idcategory = $this->intIdCategory";
            $request = $this->select($sql);
            return $request;
        }
        /*************************SubCategory methods*******************************/
        public function insertSubCategory(int $intIdCategory ,string $strName, int $intStatus,string $strRoute){
            $this->intIdCategory = $intIdCategory;
			$this->strName = $strName;
			$this->intStatus = $intStatus;
			$this->strRoute = $strRoute;

			$return = 0;
			$sql = "SELECT * FROM subcategory WHERE name = '{$this->strName}' AND categoryid = $this->intIdCategory";
			$request = $this->select_all($sql);
			if(empty($request)){
				$query_insert  = "INSERT INTO subcategory(categoryid,name,status,route) VALUES(?,?,?,?)";  
	        	$arrData = array(
                    $this->intIdCategory,
                    $this->strName,
                    $this->intStatus,
                    $this->strRoute
        		);
	        	$request_insert = $this->insert($query_insert,$arrData);
	        	$return = $request_insert;
			}else{
				$return = "exist";
			}
	        return $return;
		}
        public function updateSubCategory(int $intIdSubCategory,int $intIdCategory, string $strName,int $intStatus,string $strRoute){
            $this->intIdSubCategory = $intIdSubCategory;
            $this->intIdCategory = $intIdCategory;
            $this->strName = $strName;
			$this->intStatus = $intStatus;
			$this->strRoute = $strRoute;

			$sql = "SELECT * FROM subcategory WHERE name = '{$this->strName}' AND idsubcategory != $this->intIdSubCategory AND categoryid = $this->intIdCategory";
			$request = $this->select_all($sql);

			if(empty($request)){

                $sql = "UPDATE subcategory SET categoryid=?,name=?, status=?, route=? WHERE idsubcategory = $this->intIdSubCategory";
                $arrData = array(
                    $this->intIdCategory,
                    $this->strName,
                    $this->intStatus,
                    $this->strRoute
                );
				$request = $this->update($sql,$arrData);
			}else{
				$request = "exist";
			}
			return $request;
		
		}
        public function deleteSubCategory($id){
            $this->intIdSubCategory = $id;
            $sql = "DELETE FROM subcategory WHERE idsubcategory = $this->intIdSubCategory;SET @autoid :=0; 
			UPDATE subcategory SET idsubcategory = @autoid := (@autoid+1);
			ALTER TABLE subcategory Auto_Increment = 1";
            $request = $this->delete($sql);
            return $request;
        }
        public function selectSubCategories(){
            $sql = "SELECT  
                    s.idsubcategory,
                    s.name,
                    s.categoryid,
                    s.status,
                    c.idcategory,
                    c.name as category,
                    c.status
                    FROM subcategory s
                    INNER JOIN category c
                    ON c.idcategory = s.categoryid
                    ORDER BY idsubcategory ASC";       
            $request = $this->select_all($sql);
            return $request;
        }
        public function selectSubCategory($id){
            $this->intIdSubCategory = $id;
            $sql = "SELECT * FROM subcategory WHERE idsubcategory = $this->intIdSubCategory";
            $request = $this->select($sql);
            return $request;
        }
    }
?>