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
                $idUser = $_SESSION['userData']['roleid'] != 1 ? $_SESSION['idUser'] : "";

                $data['totalUsers'] = $this->model->getTotalUsers();
                $data['totalCustomers'] = $this->model->getTotalCustomers();
                $data['totalOrders'] = $this->model->getTotalOrders($idUser);
                $data['totalSales'] = $this->model->getTotalSales();
                $data['orders'] = $this->model->getLastOrders($idUser);
                $data['products'] = $this->model->getLastProducts();
                $data['page_tag'] = "Dashboard";
                $data['page_title'] = "Dashboard";
                $data['page_name'] = "dashboard";

                $year = date('Y');
                $month = date('m');
                $data['salesMonth'] = $this->model->getSalesMonth($year,$month);
                $data['salesYear'] = $this->model->getSalesYear($year);
                //dep($data['salesMonth']);
                $this->views->getView($this,"dashboard",$data);
            }else{
                header("location: ".base_url());
                die();
            }
        }
    }
?>