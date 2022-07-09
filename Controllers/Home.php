<?php
    require_once("Libraries/Core/Mysql.php");
    require_once("Models/ProductTrait.php");
    class Home extends Controllers{
        use ProductTrait;
        private $con;
        public function __construct(){
            session_start();
            parent::__construct();
        }

        public function home(){
            $data['page_tag'] = NOMBRE_EMPRESA;
            $data['page_title'] = NOMBRE_EMPRESA;
            $data['page_name'] = "home";
            $this->views->getView($this,"home",$data);
        }

        public function getProductSlider(){
            $request = $this->getProductsSlider(4);
            $arrResponse = array("data"=>$request);
            echo json_encode($request,JSON_UNESCAPED_UNICODE);
            die();
        }
    }
?>