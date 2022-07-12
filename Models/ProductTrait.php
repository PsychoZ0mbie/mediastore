<?php
    require_once("Libraries/Core/Mysql.php");
    trait ProductTrait{
        private $con;
        private $intIdProduct;
        public function getProductsSlider($cant){
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
                s.idsubcategory,
                s.categoryid,
                s.name as subcategory
            FROM product p
            INNER JOIN category c, subcategory s
            WHERE c.idcategory = p.categoryid AND c.idcategory = s.categoryid AND p.subcategoryid = s.idsubcategory AND p.discount != 0 AND p.status =1
            ORDER BY p.idproduct DESC LIMIT $cant
            ";
            $request = $this->con->select_all($sql);
            if(count($request)> 0){
                for ($i=0; $i < count($request); $i++) { 
                    $request[$i]['priceDiscount'] =  formatNum($request[$i]['price']-($request[$i]['price']*($request[$i]['discount']/100)));
                    $request[$i]['price'] = formatNum($request[$i]['price']);
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
        public function getProductsT($cant){
            if($cant !=""){
                $cant = " LIMIT $cant";
            }
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
            WHERE c.idcategory = p.categoryid AND c.idcategory = s.categoryid AND p.subcategoryid = s.idsubcategory
            ORDER BY p.idproduct DESC $cant
            ";
            $request = $this->con->select_all($sql);
            if(count($request)> 0){
                for ($i=0; $i < count($request); $i++) { 

                    $request[$i]['priceDiscount'] =  formatNum($request[$i]['price']-($request[$i]['price']*($request[$i]['discount']*0.01)));
                    $request[$i]['price'] = formatNum($request[$i]['price']);
                    $request[$i]['favorite'] = 0;

                    $idProduct = $request[$i]['idproduct'];

                    if(isset($_SESSION['login'])){
                        $idUser = $_SESSION['idUser'];
                        $sqlFavorite = "SELECT * FROM wishlist WHERE productid = $idProduct AND personid = $idUser";
                        $requestFavorite = $this->con->select($sqlFavorite);
                        if(!empty($requestFavorite)){
                            $request[$i]['favorite'] = $requestFavorite['status'];
                        }
                    }
                    $sqlRate = "SELECT id,productid,personid,AVG(rate) as rate FROM productrate WHERE productid = $idProduct";
                    $sqlImg = "SELECT * FROM productimage WHERE productid = $idProduct";
                    $requestImg =  $this->con->select_all($sqlImg);
                    $requestRate =  $this->con->select_all($sqlRate);
                    $request[$i]['rate'] = $requestRate;

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
        public function getPopularProductsT($cant){
            if($cant !=""){
                $cant = " LIMIT $cant";
            }
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
                s.name as subcategory,
                r.productid,
                AVG(r.rate) as rate
            FROM product p
            INNER JOIN category c, subcategory s, productrate r
            WHERE c.idcategory = p.categoryid AND c.idcategory = s.categoryid AND p.subcategoryid = s.idsubcategory AND r.productid=p.idproduct AND rate>= 4
            ORDER BY p.idproduct DESC $cant
            ";
            $request = $this->con->select_all($sql);
            if(count($request)> 0){
                for ($i=0; $i < count($request); $i++) { 

                    $request[$i]['priceDiscount'] =  formatNum($request[$i]['price']-($request[$i]['price']*($request[$i]['discount']*0.01)));
                    $request[$i]['price'] = formatNum($request[$i]['price']);
                    $request[$i]['favorite'] = 0;

                    $idProduct = $request[$i]['idproduct'];

                    if(isset($_SESSION['login'])){
                        $idUser = $_SESSION['idUser'];
                        $sqlFavorite = "SELECT * FROM wishlist WHERE productid = $idProduct AND personid = $idUser";
                        $requestFavorite = $this->con->select($sqlFavorite);
                        if(!empty($requestFavorite)){
                            $request[$i]['favorite'] = $requestFavorite['status'];
                        }
                    }
                    $sqlRate = "SELECT id,productid,personid,AVG(rate) as rate FROM productrate WHERE productid = $idProduct";
                    $sqlImg = "SELECT * FROM productimage WHERE productid = $idProduct";
                    $requestImg =  $this->con->select_all($sqlImg);
                    $requestRate =  $this->con->select_all($sqlRate);
                    $request[$i]['rate'] = $requestRate;

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
        public function getProductT($idProduct){
            $this->con=new Mysql();
            $this->intIdProduct = $idProduct;
            $sql = "SELECT 
                p.idproduct,
                p.categoryid,
                p.subcategoryid,
                p.reference,
                p.name,
                p.shortdescription,
                p.description,
                p.price,
                p.discount,
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
            WHERE c.idcategory = p.categoryid AND c.idcategory = s.categoryid AND p.subcategoryid = s.idsubcategory 
            AND p.idproduct = $this->intIdProduct";

            $request = $this->con->select($sql);
            $request['favorite'] = 0;

            if(isset($_SESSION['login'])){
                $idUser = $_SESSION['idUser'];
                $sqlFavorite = "SELECT * FROM wishlist WHERE productid = $this->intIdProduct AND personid = $idUser";
                $requestFavorite = $this->con->select($sqlFavorite);
                if(!empty($requestFavorite)){
                    $request['favorite'] = $requestFavorite['status'];
                }
            }

            $sqlImg = "SELECT * FROM productimage WHERE productid = $this->intIdProduct";
            $requestImg = $this->con->select_all($sqlImg);

            if(count($requestImg)){
                for ($i=0; $i < count($requestImg); $i++) { 
                    $request['image'][$i] = array("url"=>media()."/images/uploads/".$requestImg[$i]['name'],"name"=>$requestImg[$i]['name']);
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
    }
    
?>