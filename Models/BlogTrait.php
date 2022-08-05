<?php
    require_once("Libraries/Core/Mysql.php");
    trait BlogTrait{
        private $con;
        private $intIdProduct;

        public function getCategoriesT(){
            $this->con=new Mysql();
            $sql = "SELECT * FROM blogcategory WHERE status = 1 ORDER BY name ";       
            $request = $this->con->select_all($sql);
            if(count($request)>0){
                for ($i=0; $i < count($request) ; $i++) { 
                    $idCategory = $request[$i]['idcategory'];
                    $sqlSub = "SELECT * FROM blogsubcategory WHERE status = 1 AND categoryid = $idCategory";
                    $requestSub = $this->con->select_all($sqlSub);
                    for ($j=0; $j < count($requestSub) ; $j++) { 
                        $idSubcategory = $requestSub[$j]['idsubcategory'];
                        $sqlQty = "SELECT COUNT(idarticle) as total FROM article WHERE subcategoryid = $idSubcategory";
                        $requestQty = $this->con->select($sqlQty);
                        $requestSub[$j]['total'] = $requestQty['total'];
                    }
                    $request[$i]['subcategories'] = $requestSub;
                }
            }
            return $request;
        }
        public function getArticlesT($cant = null){
            if($cant !=null){
                $cant = " LIMIT $cant";
            }
            $this->con=new Mysql();
            $sql = "SELECT 
                    a.idarticle,
                    a.categoryid,
                    a.subcategoryid,
                    a.name,
                    a.picture,
                    a.description,
                    a.status,
                    a.route,
                    c.idcategory,
                    c.name as category,
                    s.idsubcategory,
                    s.categoryid,
                    s.name as subcategory,
                    DATE_FORMAT(a.date_created, '%d/%m/%Y') as date,
                    DATE_FORMAT(a.date_updated, '%d/%m/%Y') as dateupdated
                    FROM article a
                    INNER JOIN blogcategory c, blogsubcategory s
                    WHERE c.idcategory = a.categoryid AND c.idcategory = s.categoryid AND a.subcategoryid = s.idsubcategory AND a.status =1
                    ORDER BY a.idarticle DESC $cant
            ";
            $request = $this->con->select_all($sql);
            return $request;
        }
        public function getTotalArticlesT(string $category,string $subcategory){
            $option="";
            $this->con=new Mysql();
            if($subcategory!=""){
                $option=" AND c.route = '$category' AND s.route = '$subcategory'";
            }else{
                $option=" AND c.route = '$category'";
            }
            $sql = "SELECT COUNT(a.idarticle) as total 
                    FROM article a
                    INNER JOIN category c, subcategory s
                    WHERE c.idcategory = a.categoryid AND c.idcategory = s.categoryid AND a.subcategoryid = s.idsubcategory $option";
            $request = $this->con->select($sql);
            return $request;
        }
        public function getArticlesCategoryT(string $category,string $subcategory){
            $option="";
            if($subcategory!=""){
                $option=" AND c.route = '$category' AND s.route = '$subcategory'";
            }else{
                $option=" AND c.route = '$category'";
            }

            $this->con=new Mysql();
            $sql = "SELECT 
                    a.idarticle,
                    a.categoryid,
                    a.subcategoryid,
                    a.name,
                    a.picture,
                    a.description,
                    a.status,
                    a.route,
                    c.idcategory,
                    c.name as category,
                    s.idsubcategory,
                    s.categoryid,
                    s.name as subcategory,
                    DATE_FORMAT(a.date_created, '%d/%m/%Y') as date,
                    DATE_FORMAT(a.date_updated, '%d/%m/%Y') as dateupdated
                    FROM article a
                    INNER JOIN blogcategory c, blogsubcategory s
                    WHERE c.idcategory = a.categoryid AND c.idcategory = s.categoryid AND a.subcategoryid = s.idsubcategory $option
                    ORDER BY a.idarticle DESC
            ";
            $request = $this->con->select_all($sql);
            return $request;
        }
        public function getRecentPostsT($cant){
            if($cant !=""){
                $cant = " LIMIT $cant";
            }
            $this->con=new Mysql();
            $sql = "SELECT 
            a.idarticle,
            a.categoryid,
            a.subcategoryid,
            a.name,
            a.picture,
            a.description,
            a.status,
            a.route,
            c.idcategory,
            c.name as category,
            s.idsubcategory,
            s.categoryid,
            s.name as subcategory,
            DATE_FORMAT(a.date_created, '%d/%m/%Y') as date,
            DATE_FORMAT(a.date_updated, '%d/%m/%Y') as dateupdated
            FROM article a
            INNER JOIN blogcategory c, blogsubcategory s
            WHERE c.idcategory = a.categoryid AND c.idcategory = s.categoryid AND a.subcategoryid = s.idsubcategory AND a.status =1
            ORDER BY a.idarticle DESC $cant
            ";
            //dep($sql);exit;
            $request = $this->con->select_all($sql);
            return $request;
        }
        public function getRelatedPostsT($cant,$idCategory){
            if($cant !=""){
                $cant = " LIMIT $cant";
            }
            $this->con=new Mysql();
            $sql = "SELECT 
            a.idarticle,
            a.categoryid,
            a.subcategoryid,
            a.name,
            a.picture,
            a.description,
            a.status,
            a.route,
            c.idcategory,
            c.name as category,
            s.idsubcategory,
            s.categoryid,
            s.name as subcategory,
            DATE_FORMAT(a.date_created, '%d/%m/%Y') as date,
            DATE_FORMAT(a.date_updated, '%d/%m/%Y') as dateupdated
            FROM article a
            INNER JOIN blogcategory c, blogsubcategory s
            WHERE c.idcategory = a.categoryid AND c.idcategory = s.categoryid AND a.subcategoryid = s.idsubcategory AND a.status =1 AND a.categoryid =$idCategory
            ORDER BY a.idarticle DESC $cant
            ";
            //dep($sql);exit;
            $request = $this->con->select_all($sql);
            return $request;
        }
        public function getArticlePageT(string $route){
            $this->con=new Mysql();
            $sql = "SELECT 
            a.idarticle,
            a.categoryid,
            a.subcategoryid,
            a.name,
            a.picture,
            a.description,
            a.status,
            a.route,
            c.idcategory,
            c.name as category,
            s.idsubcategory,
            s.categoryid,
            s.name as subcategory,
            DATE_FORMAT(a.date_created, '%d/%m/%Y') as date,
            DATE_FORMAT(a.date_updated, '%d/%m/%Y') as dateupdated
            FROM article a
            INNER JOIN blogcategory c, blogsubcategory s
            WHERE c.idcategory = a.categoryid AND c.idcategory = s.categoryid AND a.subcategoryid = s.idsubcategory 
            AND a.route = '$route'";
            $request = $this->con->select($sql);
            return $request;
        }
        public function getProductsFavorites($id){
            $this->con=new Mysql();
            $sql = "SELECT 
                p.idproduct,
                p.categoryid,
                p.subcategoryid,
                p.reference,
                p.name,
                p.description,
                p.price,
                p.discount,
                p.description,
                p.stock,
                p.status,
                p.route,
                c.idcategory,
                c.name as category,
                c.route as routec,
                s.idsubcategory,
                s.categoryid,
                s.name as subcategory
            FROM product p
            INNER JOIN category c, subcategory s, wishlist w
            WHERE c.idcategory = p.categoryid AND c.idcategory = s.categoryid AND p.subcategoryid = s.idsubcategory 
            AND p.idproduct = w.productid AND w.personid = $id AND w.status = 1";
            $request = $this->con->select_all($sql);
            if(count($request)> 0){
                for ($i=0; $i < count($request); $i++) { 

                    $request[$i]['priceDiscount'] =  $request[$i]['price']-($request[$i]['price']*($request[$i]['discount']*0.01));
                    $request[$i]['price'] = $request[$i]['price'];
                    $request[$i]['favorite'] = 0;

                    $idProduct = $request[$i]['idproduct'];

                    $sqlImg = "SELECT * FROM productimage WHERE productid = $idProduct";
                    $requestImg =  $this->con->select_all($sqlImg);

                    if(count($requestImg)>0){
                        $request[$i]['url'] = media()."/images/uploads/".$requestImg[0]['name'];
                        $request[$i]['image'] = $requestImg[0]['name'];
                    }else{
                        $request[$i]['image'] = media()."/images/uploads/image.png";
                    }
                }
            }
            return $request;
        }
        public function addWishListT($idProduct,$idUser){
            $this->con = new Mysql();
            $sql = "SELECT * FROM wishlist WHERE productid = $idProduct AND personid = $idUser";
            $request = $this->con->select_all($sql);
            $return ="";
            if(empty($request)){
                $sql = "INSERT INTO wishlist (productid,personid,status) VALUE(?,?,?)";
                $array = array($idProduct,$idUser,1);
                $request = $this->con->insert($sql,$array);
                $return =$request;
            }else{
                $return ="exists";
            }
            return $return;
        }
        public function delWishListT($idProduct,$idUser){
            $this->con = new Mysql();
            $sql = "DELETE FROM wishlist WHERE productid=$idProduct AND personid = $idUser";
            $request = $this->con->delete($sql);
            return $request;
        }
        public function getProductsSearchT($search){
            $this->con=new Mysql();
            $sql = "SELECT 
                p.idproduct,
                p.categoryid,
                p.subcategoryid,
                p.reference,
                p.name,
                p.description,
                p.price,
                p.discount,
                p.description,
                p.stock,
                p.status,
                p.route,
                c.idcategory,
                c.name as category,
                c.route as routec,
                s.idsubcategory,
                s.categoryid,
                s.name as subcategory
            FROM product p
            INNER JOIN category c, subcategory s
            WHERE c.idcategory = p.categoryid AND c.idcategory = s.categoryid AND p.subcategoryid = s.idsubcategory AND
            p.name LIKE  '%$search%' || c.idcategory = p.categoryid AND c.idcategory = s.categoryid AND p.subcategoryid = s.idsubcategory AND
            c.name LIKE  '%$search%' || c.idcategory = p.categoryid AND c.idcategory = s.categoryid AND p.subcategoryid = s.idsubcategory AND
            s.name LIKE '%$search%'
            ";
            $request = $this->con->select_all($sql);
            if(count($request)> 0){
                for ($i=0; $i < count($request); $i++) { 

                    $request[$i]['priceDiscount'] =  $request[$i]['price']-($request[$i]['price']*($request[$i]['discount']*0.01));
                    $request[$i]['price'] = $request[$i]['price'];

                    $idProduct = $request[$i]['idproduct'];

                    $sqlRate = "SELECT AVG(rate) as rate FROM productrate WHERE productid = $idProduct";
                    $sqlImg = "SELECT * FROM productimage WHERE productid = $idProduct";
                    $requestImg =  $this->con->select_all($sqlImg);
                    $requestRate =  $this->con->select($sqlRate);
                    $request[$i]['rate'] = $requestRate['rate'];

                    if(count($requestImg)>0){
                        $request[$i]['url'] = media()."/images/uploads/".$requestImg[0]['name'];
                        $request[$i]['image'] = $requestImg[0]['name'];
                    }else{
                        $request[$i]['image'] = media()."/images/uploads/image.png";
                    }
                }
            }
            //dep($request);exit;
            return $request;
        }
    }
    
?>