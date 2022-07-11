<?php
    class Dashboard extends Controllers{
        public function __construct(){
            session_start();
            if(empty($_SESSION['login'])){
                header("location: ".base_url());
                die();
            }
            parent::__construct();
            getPermits(1);
        }

        public function dashboard(){
            if($_SESSION['permitsModule']['r']){
                $data['page_tag'] = "Dashboard";
                $data['page_title'] = "Dashboard";
                $data['page_name'] = "dashboard";
                $this->views->getView($this,"dashboard",$data);
            }else{
                header("location: ".base_url());
                die();
            }
        }
    }
?>