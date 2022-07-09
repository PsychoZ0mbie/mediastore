<?php
    require_once("Libraries/Core/Mysql.php");
    trait CategoryTrait{
        private $con;

        public function getCategoriesT(){
            $this->con=new Mysql();
            $sql = "SELECT * FROM category WHERE status = 1 ORDER BY name ";       
            $request = $this->con->select_all($sql);
            return $request;
        }
        public function getCategories1T(string $categories){
            $this->con=new Mysql();
            $sql = "SELECT idcategory,picture,name,status,route FROM category WHERE status = 1 AND idcategory IN ($categories)";       
            $request = $this->con->select_all($sql);
            return $request;
        }
        public function getCategories2T(string $categories){
            $this->con=new Mysql();
            $sql = "SELECT idcategory,picture,name,status,route FROM category WHERE status = 1 AND idcategory IN ($categories)";       
            $request = $this->con->select_all($sql);
            return $request;
        }
    }
    
?>