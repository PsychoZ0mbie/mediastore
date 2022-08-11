<?php
    require_once("Models/PageTrait.php");
    class About extends Controllers{
        use PageTrait;
        public function __construct(){
            session_start();
            parent::__construct();
        }

        public function about(){
            $data['page_tag'] = "About us | ".NOMBRE_EMPRESA;
			$data['page_title'] = "About us | ".NOMBRE_EMPRESA;
			$data['page_name'] = "about";
            $data['page'] = $this->getPage(1);
            $this->views->getView($this,"about",$data);
        }
    }
?>