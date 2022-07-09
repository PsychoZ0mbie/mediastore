<?php
    
    require_once("Models/ProductTrait.php");
    require_once("Models/CategoryTrait.php");
    class Home extends Controllers{
        use ProductTrait, CategoryTrait;
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
        public function getCategories1(){
            $request = $this->getCategories1T("4,5,6");
            $arrResponse = array("data"=>$request);
            echo json_encode($request,JSON_UNESCAPED_UNICODE);
            die();
        }
        public function getCategories2(){
            $request = $this->getCategories2T("7,8,9");
            $arrResponse = array("data"=>$request);
            echo json_encode($request,JSON_UNESCAPED_UNICODE);
            die();
        }
    }
?>