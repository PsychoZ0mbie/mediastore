<?php
    
    require_once("Models/ProductTrait.php");
    //require_once("Models/CategoryTrait.php");
    class Wishlist extends Controllers{
        use ProductTrait;
        public function __construct(){
            session_start();
            if(empty($_SESSION['login'])){
                header("location: ".base_url());
                die();
            }
            parent::__construct();
        }

        public function wishlist(){
            $data['page_tag'] = NOMBRE_EMPRESA;
            $data['page_title'] = "My wishlist | ".NOMBRE_EMPRESA;;
            $data['page_name'] = "wishlist";
            $data['products'] = $this->getProductsFavorites($_SESSION['idUser']);
            $this->views->getView($this,"wishlist",$data);
        }
    }
?>