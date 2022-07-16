<?php
    require_once("Libraries/Core/Mysql.php");
    trait ReviewTrait{
        private $con;
        
        public function getRate($id){
            $this->con = new Mysql();
            $sql = "SELECT 
            sum(case when rate = 5 then 1 else 0 end) AS five,
            sum(case when rate = 4 then 1 else 0 end) AS four, 
            sum(case when rate = 3 then 1 else 0 end) AS three, 
            sum(case when rate = 2 then 1 else 0 end) AS two, 
            sum(case when rate = 1 then 1 else 0 end) AS one
            FROM productrate WHERE productid=$id";
            $request = $this->con->select($sql);
            return $request;
        }
    }
    
?>