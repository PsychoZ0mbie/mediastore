<?php
    class Dashboard extends Controllers{
        public function __construct(){
            parent::__construct();
        }

        public function dashboard(){
            $data['page_tag'] = "Dashboard";
            $data['page_title'] = "Dashboard";
            $data['page_name'] = "dashboard";
            $this->views->getView($this,"dashboard",$data);
        }
    }
?>