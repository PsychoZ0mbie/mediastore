<?php
    
    require_once("Models/BlogTrait.php");
    require_once("Models/LoginModel.php");
    class Blog extends Controllers{
        use BlogTrait;
        private $login;
        public function __construct(){
            session_start();
            parent::__construct();
            $this->login = new LoginModel();
        }

        /******************************Views************************************/
        public function blog(){
            $data['page_tag'] = NOMBRE_EMPRESA;
            $data['page_title'] = "Blog | ".NOMBRE_EMPRESA;
            $data['page_name'] = "blog";
            $data['recPosts'] = $this->getRecentPostsT(9);
            $data['posts'] = $this->getArticlesT();
            $data['categories'] = $this->getCategoriesT();
            $this->views->getView($this,"blog",$data);
        }
        public function category($params){
            $arrParams = explode(",",$params);
            $category="";
            $subcategory="";

            if(count($arrParams)>1){
                $category = strClean($arrParams[0]);
                $subcategory = strClean($arrParams[1]);
            }else{
                $category = strClean($arrParams[0]);
            }
            
            $data['page_tag'] = NOMBRE_EMPRESA;
            $data['page_title'] = "Blog | ".NOMBRE_EMPRESA;
            $data['page_name'] = "category";
            $data['categories'] = $this->getCategoriesT();
            $data['routec'] = $category;
            $data['routes'] = $subcategory;
            $data['total'] = $this->getTotalArticlesT($category,$subcategory);
            $data['posts'] = $this->getArticlesCategoryT($category,$subcategory,1);
            $data['recPosts'] = $this->getRecentPostsT(9);
            $data['categories'] = $this->getCategoriesT();
            $this->views->getView($this,"category",$data);
        }
        public function article($params){
            $params = strClean($params);
            $data['page_tag'] = NOMBRE_EMPRESA;
            $data['page_name'] = "article";
            $data['article'] = $this->getArticlePageT($params);
            $data['relPosts'] = $this->getRelatedPostsT(3,$data['article']['categoryid']);
            $data['recPosts'] = $this->getRecentPostsT(9);
            $data['categories'] = $this->getCategoriesT();
            //$data['articles'] = $this->getProductsRandT(4);
            $data['page_title'] =$data['article']['name']." | ".NOMBRE_EMPRESA;
            $this->views->getView($this,"article",$data); 
        }
    }
?>