<?php
    
    require_once("Models/ProductTrait.php");
    require_once("Models/CategoryTrait.php");
    require_once("Models/CustomerTrait.php");
    class Home extends Controllers{
        use ProductTrait, CategoryTrait, CustomerTrait;
        public function __construct(){
            session_start();
            parent::__construct();
        }

        public function home(){
            $data['page_tag'] = NOMBRE_EMPRESA;
            $data['page_title'] = NOMBRE_EMPRESA;
            $data['slider'] = $this->getProductsSlider(4);
            $data['category1'] = $this->getCategories1T("4,5,6");
            $data['category2'] = $this->getCategories2T("7,8,9");
            $data['products'] = $this->getProductsT(8);
            $data['popProducts'] = $this->getPopularProductsT(8);
            $data['couponSubscriber'] = $this->statusCouponSuscriberT();
            $data['page_name'] = "home";
            $this->views->getView($this,"home",$data);
        }

        /*public function getCategories1(){
            $request = $this->getCategories1T("4,5,6");
            $arrResponse = array("data"=>$request);
            echo json_encode($request,JSON_UNESCAPED_UNICODE);
            die();
        }
        public function getCategories2(){
            $request = 
            $arrResponse = array("data"=>$request);
            echo json_encode($request,JSON_UNESCAPED_UNICODE);
            die();
        }
        public function getProducts(){
            $request = $this->getProductsT(4);
            for ($i=0; $i < count($request); $i++) { 
                $request[$i]['idproduct'] = openssl_encrypt($request[$i]['idproduct'],METHOD,KEY);
            }
            $arrResponse = array("data"=>$request);
            echo json_encode($request,JSON_UNESCAPED_UNICODE);
            die();
        }*/
    }
?>