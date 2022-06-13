<?php 
    class ProductModel extends Mysql{
        private $intIdCategory;
        private $intIdSubCategory;
        private $intIdProduct;
        private $strReference;
		private $strName;
        private $strDescription;
        private $intPrice;
        private $intDiscount;
        private $intStock;
		private $intStatus;
        private $strRoute;
        private $arrPhotos;

        public function __construct(){
            parent::__construct();
        }
        /*************************Category methods*******************************/
        public function insertProduct(int $idCategory, int $idSubcategory,string $strReference, string $strName, string $strDescription, int $intPrice, int $intDiscount, int $intStock, int $intStatus, string $route, array $photos){
            
            $this->intIdCategory = $idCategory;
            $this->intIdSubCategory = $idSubcategory;
            $this->strReference = $strReference;
			$this->strName = $strName;
            $this->strDescription = $strDescription;
            $this->intPrice = $intPrice;
            $this->intDiscount = $intDiscount;
            $this->intStock = $intStock;
			$this->intStatus = $intStatus;
			$this->strRoute = $route;
            $this->arrPhotos = $photos;

			$return = 0;
			$sql = "SELECT * FROM product WHERE name = '$this->strName'";
			$request = $this->select_all($sql);

			if(empty($request))
			{ 
				$query_insert  = "INSERT INTO product(categoryid,subcategoryid,reference,name,description,price,discount,stock,status,route) VALUES(?,?,?,?,?,?,?,?,?,?)";
	        	$arrData = array(
                    $this->intIdCategory,
                    $this->intIdSubCategory,
                    $this->strReference,
                    $this->strName,
                    $this->strDescription,
                    $this->intPrice,
                    $this->intDiscount,
                    $this->intStock,
                    $this->intStatus,
                    $this->strRoute
        		);
	        	$request_insert = $this->insert($query_insert,$arrData);
                for ($i=0; $i < count($this->arrPhotos) ; $i++) { 
                    $sqlImg = "INSERT INTO productimage(productid,name) VALUES(?,?)";
                    $arrImg = array($request_insert,$this->arrPhotos[$i]['rename']);
                    $requestImg = $this->insert($sqlImg,$arrImg);
                }
	        	$return = $request_insert;
			}else{
				$return = "exist";
			}
	        return $return;
		}
        public function updateProduct(int $intIdCategory, string $strName,int $intStatus,string $strRoute){
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
        public function deleteProduct($id){
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
        public function selectSubCategories($id){
            $this->intIdCategory = $id;
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
                    WHERE s.categoryid = $this->intIdCategory
                    ORDER BY idsubcategory ASC";       
            $request = $this->select_all($sql);
            return $request;
        }
        public function selectProduct($id){
            $this->intIdCategory = $id;
            $sql = "SELECT * FROM category WHERE idcategory = $this->intIdCategory";
            $request = $this->select($sql);
            return $request;
        }
    }
?>