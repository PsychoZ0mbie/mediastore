<?php
    require_once("Models/PageTrait.php");
    class Policies extends Controllers{
        use PageTrait;
        public function __construct(){
            session_start();
            parent::__construct();
        }

        public function policies(){
            $company=getCompanyInfo();
            $data['page_tag'] = "Policies | ".$company['name'];
			$data['page_title'] = "Policies | ".$company['name'];
			$data['page_name'] = "policies";
            $data['page'] = $this->getPage(2);
            $this->views->getView($this,"policies",$data);
        }
    }
?>