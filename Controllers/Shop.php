<?php
    
    require_once("Models/ProductTrait.php");
    require_once("Models/CategoryTrait.php");
    require_once("Models/CustomerTrait.php");
    require_once("Models/LoginModel.php");
    class Shop extends Controllers{
        use ProductTrait, CategoryTrait, CustomerTrait;
        private $login;
        public function __construct(){
            session_start();
            parent::__construct();
            $this->login = new LoginModel();
        }

        public function shop(){
            $data['page_tag'] = NOMBRE_EMPRESA;
            $data['page_title'] = NOMBRE_EMPRESA." | Shop";
            $data['page_name'] = "shop";
            $data['categories'] = $this->getCategoriesT();
            $data['products'] = $this->getProductsT("");
            $data['popProducts'] = $this->getPopularProductsT(9);
            $this->views->getView($this,"shop",$data);
        }
        public function getProductSort($params){
            $arrParams = explode(",",$params);
            $category="";
            $subcategory="";
            $option =0;
            $html="";
            
            if(is_numeric($arrParams[0])){  
                $option = $arrParams[0];
                $request = $this->getProductSortT($category,$subcategory,$option);
            }else{
                if(count($arrParams)==3){
                    $category = strClean($arrParams[0]);
                    $subcategory = strClean($arrParams[1]);
                    $option = $arrParams[2];
                    //dep($arrParams);exit;
                    $request = $this->getProductSortT($category,$subcategory,$option);
                }else{
                    $category = strClean($arrParams[0]);
                    $option = $arrParams[1];
                    $request = $this->getProductSortT($category,$subcategory,$option);
                }
            }
            for ($i=0; $i < count($request) ; $i++) { 
                $idProduct = openssl_encrypt($request[$i]['idproduct'],METHOD,KEY);
                $favorite = '';
                $routeP = base_url()."/shop/product/".$request[$i]['route'];
                $routeC = base_url()."/shop/category/".$request[$i]['routec'];
                $price ='<p class="m-0 fs-5 product-price"><strong>'.formatNum($request[$i]['price']).'</strong></p>';
                $btnAdd ='<button type="button" class="btn btn-primary product-card-add">Add to cart</a>';
                $discount="";
                $rate="";
                if($request[$i]['favorite']== 0){
                    $favorite = '<button type="button" class="btn addWishList pe-2 ps-2 "><i class="far fa-heart " data-bs-toggle="tooltip" data-bs-placement="top" title="Add to wishlist"></i></button>';
                }else{
                    $favorite = '<button type="button" class="btn addWishList pe-2 ps-2 active"><i class="fas fa-heart text-danger " data-bs-toggle="tooltip" data-bs-placement="top" title="Add to wishlist"></i></button>';
                }
                if($request[$i]['status'] == 1 && $request[$i]['stock']>0){
                    if($request[$i]['discount']>0){
                        $price = '<p class="m-0 fs-5 product-price"><strong>'.formatNum($request[$i]['priceDiscount']).'</strong><span>'.formatNum($request[$i]['price']).'</span></p>';
                        $discount ='<p class="product-discount">-'.$request[$i]['discount'].'%</p>';
                    }
                }else if($request[$i]['status'] == 1 && $request[$i]['stock']==0){
                    $btnAdd="";
                    $price='<p class="m-0 fs-5 product-price text-danger">Sold out</p>';
                }else{
                    $btnAdd ="";
                    $price="";
                }
                for ($j=0; $j < 5; $j++) { 
                    if($request[$i]['rate']!=null && $j >= $request[$i]['rate']){
                        $rate.='<i class="far me-1 fa-star"></i>';
                    }else if($request[$i]['rate']==null){
                        $rate.='<i class="far me-1 fa-star"></i>';
                    }else{
                        $rate.='<i class="fas me-1 fa-star"></i>';
                    }
                }
                $html .='
                <div class="col-lg-4 col-md-6 product-item" data-id="'.$idProduct.'" data-price="'.$request[$i]['price'].'" data-rate="'.$request[$i]['rate'].'">
                    <div class="product-card">
                        '.$discount.'
                        <div class="product-img">
                            <img src="'.$request[$i]['url'].'" alt="'.$request[$i]['name'].'">
                            '.$btnAdd.'
                        </div>
                        <div class="product-info">
                            <a class="m-0 product-category fw-bold" href="'.$routeC.'">'.$request[$i]['category'].'</a>
                            <a href="'.$routeP.'">
                                <h3 class="product-title fw-bold">'.$request[$i]['name'].'</h3>
                                '.$price.'
                            </a>
                        </div>
                        <div class="product-rate">
                        '.$rate.'
                        </div>
                        <div class="product-btns">
                        '.$favorite.'
                            <button type="button" class="btn quickView pe-2 ps-2"><i class="fas fa-eye" data-bs-toggle="tooltip" data-bs-placement="top" title="Quick view"></i></button>
                        </div>
                    </div>
                </div>
                ';
            }
            echo json_encode($html,JSON_UNESCAPED_UNICODE);
            die();
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
            $data['page_title'] = NOMBRE_EMPRESA." | Shop";
            $data['page_name'] = "shop";
            $data['categories'] = $this->getCategoriesT();
            $data['routec'] = $category;
            $data['routes'] = $subcategory;
            $data['total'] = $this->getTotalProductsT($category,$subcategory);
            $data['products'] = $this->getProductsCategoryT($category,$subcategory);
            $data['popProducts'] = $this->getPopularProductsT(9);
            $this->views->getView($this,"category",$data);
        }
        public function addCart(){
            //dep($_POST);exit;
            //unset($_SESSION['arrCart']);exit;
            if($_POST){ 
                $id = intval(openssl_decrypt($_POST['idProduct'],METHOD,KEY));
                $qty = intval($_POST['txtQty']);
                $qtyCart = 0;
                $arrCart = array();
                $valiQty =true;
                if(is_numeric($id)){
                    $request = $this->getProductT($id);
                    if(!empty($request)){
                        $arrProduct = array(
                            "idproduct"=>$_POST['idProduct'],
                            "name" => $request['name'],
                            "qty"=>$qty,
                            "image"=>$request['image'][0]['url'],
                            "url"=>base_url()."/shop/product/".$request['route'],
                            "price" =>$request['price'],
                            "discount" => $request['discount']
                        );
                        if(isset($_SESSION['arrCart'])){
                            $arrCart = $_SESSION['arrCart'];
                            $currentQty = 0;
                            $flag = true;
                            for ($i=0; $i < count($arrCart) ; $i++) { 
                                if($arrCart[$i]['idproduct'] == $arrProduct['idproduct']){
                                    $currentQty = $arrCart[$i]['qty'];
                                    $arrCart[$i]['qty']+= $qty;
                                    if($arrCart[$i]['qty'] > $request['stock']){
                                        $arrCart[$i]['qty'] = $currentQty;
                                        $arrResponse = array("status"=>false,"msg"=>"Not enough units");
                                        $flag = false;
                                        break;
                                    }else{
                                        $_SESSION['arrCart'] = $arrCart;
                                        foreach ($_SESSION['arrCart'] as $quantity) {
                                            $qtyCart += $quantity['qty'];
                                        }
                                        $arrResponse = array("status"=>true,"msg"=>"It has been added to your cart.","qty"=>$qtyCart);
                                    }
                                    $flag =false;
                                    break;
                                }
                            }
                            if($flag){
                                if($qty > $request['stock']){
                                    $arrResponse = array("status"=>false,"msg"=>"Not enough units");
                                    $_SESSION['arrCart'] = $arrCart;
                                }else{
                                    array_push($arrCart,$arrProduct);
                                    $_SESSION['arrCart'] = $arrCart;
                                    foreach ($_SESSION['arrCart'] as $quantity) {
                                        $qtyCart += $quantity['qty'];
                                    }
                                    $arrResponse = array("status"=>true,"msg"=>"It has been added to your cart.","qty"=>$qtyCart);
                                }
                            }
                        }else{
                            if($qty > $request['stock']){
                                $arrResponse = array("status"=>false,"msg"=>"Not enough units");
                            }else{
                                array_push($arrCart,$arrProduct);
                                $_SESSION['arrCart'] = $arrCart;
                                foreach ($_SESSION['arrCart'] as $quantity) {
                                    $qtyCart += $quantity['qty'];
                                }
                                $arrResponse = array("status"=>true,"msg"=>"It has been added to your cart.","qty"=>$qtyCart);
                            } 
                        }
                    }else{
                        $arrResponse = array("status"=>false,"msg"=>"The product doesn't exists");
                    }
                    
                }else{
                    $arrResponse = array("status"=>false,"msg"=>"Data error");
                }
                echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
            }
            die();
        }
        public function delCart(){
            if($_POST){
                $id = $_POST['idProduct'];
                $total=0;
                $qtyCart=0;
                $arrCart = $_SESSION['arrCart'];
                for ($i=0; $i < count($arrCart) ; $i++) { 
                    if($arrCart[$i]['idproduct'] == $id){
                        unset($arrCart[$i]);
                        break;
                    } 
                }
                sort($arrCart);
                $_SESSION['arrCart'] = $arrCart;
                foreach ($_SESSION['arrCart'] as $product) {
                    $qtyCart += $product['qty'];
                    if($product['discount']>0){
                        $total += $product['qty']*($product['price']-($product['price']*($product['discount']*0.01)));
                    }else{
                        $total+=$product['qty']*$product['price'];
                    }
                }
                $arrResponse = array(
                    "status"=>true,
                    "msg"=>"It has been deleted.",
                    "total"=>formatNum($total),
                    "qty"=>$qtyCart
                );
                echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
            }
            die();
        }
        public function currentCart(){
            if(isset($_SESSION['arrCart']) && !empty($_SESSION['arrCart'])){
                $arrCart = $_SESSION['arrCart'];
                $html="";
                for ($i=0; $i < count($arrCart); $i++) { 
                    $price="";
                    if($arrCart[$i]['discount']>0){
                        $price = $arrCart[$i]['price']-($arrCart[$i]['price']*($arrCart[$i]['discount']*0.01));
                        $price = formatNum($price).' <span class="text-decoration-line-through t-p">'.formatNum($arrCart[$i]['price']).'</span>';
                    }else{
                        $price = formatNum($arrCart[$i]['price']);
                    }
                    $html.='
                    <div class="cart-panel-item" data-id="'.$arrCart[$i]['idproduct'].'">
                        <img src="'.$arrCart[$i]['image'].'" alt="'.$arrCart[$i]['name'].'">
                        <div class="btn-del">X</div>
                        <h3><a href="'.$arrCart[$i]['url'].'"><strong>'.$arrCart[$i]['name'].'</strong></a></h3>
                        <p>'.$arrCart[$i]['qty'].' x '.$price.' </p>
                    </div>
                    ';
                }
                $total =0;
                foreach ($arrCart as $product) {
                    if($product['discount']>0){
                        $total += $product['qty']*($product['price']-($product['price']*($product['discount']*0.01)));
                    }else{
                        $total+=$product['qty']*$product['price'];
                    }
                }
                $arrResponse = array("items"=>$html,"total"=>formatNum($total));
            }else{
                $arrResponse = array("items"=>"","total"=>formatNum(0));
            }
            echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
            die();
        }
        public function addWishList(){
            if($_POST){
                if(isset($_SESSION['login'])){
                    $idProduct = openssl_decrypt($_POST['idProduct'],METHOD,KEY);
                    if(is_numeric($idProduct)){
                        $request = $this->addWishListT($idProduct,$_SESSION['idUser']);
                        if($request>0){
                            $arrResponse = array("status"=>true);
                        }else if("exists"){
                            $arrResponse = array("status"=>true);
                        }else{
                            $arrResponse = array("status"=>false);
                        }
                    }
                }else{
                    $arrResponse = array("status"=>false);
                }
                echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
            }
            die();
        }
        public function delWishList(){
            if($_POST){
                if(isset($_SESSION['login'])){
                    $idProduct = openssl_decrypt($_POST['idProduct'],METHOD,KEY);
                    if(is_numeric($idProduct)){
                        $request = $this->delWishListT($idProduct,$_SESSION['idUser']);
                        if($request>0){
                            $arrResponse = array("status"=>true);
                        }else{
                            $arrResponse = array("status"=>false);
                        }
                    }
                }else{
                    $arrResponse = array("status"=>false);
                }
                echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
            }
            die();
        }
        public function getProduct(){
            if($_POST){
                $idProduct = openssl_decrypt($_POST['idProduct'],METHOD,KEY);
                if(is_numeric($idProduct)){
                    $request = $this->getProductT($idProduct);
                    $request['idproduct'] = $_POST['idProduct']; 
                    $request['priceDiscount']=formatNum($request['price']-($request['price']*($request['discount']*0.01)));
                    $request['price'] = formatNum($request['price']);
                    $arrResponse= array("status"=>true,"data"=>$request);
                }else{
                    $arrResponse= array("status"=>false);
                }
                echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
            }
            die();
            
        }
        public function validCustomer(){
            if($_POST){
				if(empty($_POST['txtSignName']) || empty($_POST['txtSignEmail']) || empty($_POST['txtSignPassword'])){
                    $arrResponse=array("status" => false, "msg" => "Data error");
                }else{
                    $strName = ucwords(strClean($_POST['txtSignName']));
                    $strEmail = strtolower(strClean($_POST['txtSignEmail']));
                    $code = code(); 
                    $dataUsuario = array('nombreUsuario'=> $strName, 
                                        'email_remitente' => EMAIL_REMITENTE, 
                                        'email_usuario'=>$strEmail, 
                                        'asunto' =>'Verification code - '.NOMBRE_REMITENTE,
                                        'codigo' => $code);
                    $_SESSION['code'] = $code;
                    $sendEmail = sendEmail($dataUsuario,'email_validData');
                    if($sendEmail){
                        $arrResponse = array("status"=>true,"msg"=>" code has been sent to your email to validate your data.");
                        
                    }else{
                        $arrResponse = array("status"=>false,"msg"=>"Error, try again.");
                    }
                }
                echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);

			}
			die();
        }
		public function setCustomer(){
			if($_POST){
				if(empty($_POST['txtSignName']) || empty($_POST['txtSignEmail']) || empty($_POST['txtSignPassword']) || empty($_POST['txtCode'])){
                    $arrResponse=array("status" => false, "msg" => "Data error");
                }else{
                    if($_POST['txtCode'] == $_SESSION['code']){
                        unset($_SESSION['code']);
                        $strName = ucwords(strClean($_POST['txtSignName']));
                        $strEmail = strtolower(strClean($_POST['txtSignEmail']));
                        $strPassword = hash("SHA256",$_POST['txtSignPassword']);
                        $strPicture = "user.jpg";
                        $rolid = 2;

                        $request = $this->setCustomerT($strName,$strPicture,$strEmail,$strPassword,$rolid);
                        
                        if($request > 0){
                            $_SESSION['idUser'] = $request;
                            $_SESSION['login'] = true;
                            
                            $arrData = $this->login->sessionLogin($_SESSION['idUser']);
                            sessionUser($_SESSION['idUser']);
    
                            $arrResponse = array("status" => true,"msg"=>"You have successfully registered.");
                        }else if($request =="exist"){
                            $arrResponse = array("status" => false,"msg"=>"The user already exists, please log in.");
                        }else{
                            $arrResponse = array("status" => false,"msg"=>"Unable to store data, try later.");
    
                        }
                    }else{
                        $arrResponse = array("status" => false,"msg"=>"Incorrect code, try again.");
                    }

                }
                echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);

			}
			die();
		}
    }
?>