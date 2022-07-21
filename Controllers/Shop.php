<?php
    
    require_once("Models/ProductTrait.php");
    require_once("Models/CategoryTrait.php");
    require_once("Models/CustomerTrait.php");
    require_once("Models/LoginModel.php");
    require_once("Models/ReviewTrait.php");
    class Shop extends Controllers{
        use ProductTrait, CategoryTrait, CustomerTrait, ReviewTrait;
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
            $data['page_name'] = "category";
            $data['categories'] = $this->getCategoriesT();
            $data['routec'] = $category;
            $data['routes'] = $subcategory;
            $data['total'] = $this->getTotalProductsT($category,$subcategory);
            $data['products'] = $this->getProductsCategoryT($category,$subcategory,1);
            $data['popProducts'] = $this->getPopularProductsT(9);
            $this->views->getView($this,"category",$data);
        }
        public function product($params){
            
            $params = strClean($params);
            $data['page_tag'] = NOMBRE_EMPRESA;
            $data['page_title'] = NOMBRE_EMPRESA." | Shop";
            $data['page_name'] = "product";
            $data['product'] = $this->getProductPageT($params);
            $data['review'] = $this->getRate($data['product']['idproduct']);
            $data['reviews'] = $this->getReviewsT($data['product']['idproduct'],"");
            $data['products'] = $this->getProductsRandT(4);
            $this->views->getView($this,"product",$data); 
        }
        /*public function getProductSort($params){
            $arrParams = explode(",",$params);
            $category="";
            $subcategory="";
            $option =0;
            $html="";
            //dep($arrParams);exit;
            if(is_numeric($arrParams[0])==1){  
                $option = $arrParams[0];
                $request = $this->getProductSortT($category,$subcategory,$option,$arrParams[1]);
            }else{
                if(count($arrParams)==3){
                    $category = strClean($arrParams[0]);
                    $subcategory = strClean($arrParams[1]);
                    $option = $arrParams[2];
                    $request = $this->getProductSortT($category,$subcategory,$option,1);
                }else{
                    $category = strClean($arrParams[0]);
                    $option = $arrParams[1];
                    $request = $this->getProductSortT($category,$subcategory,$option,1);
                }
            }
            //dep($request['data']);exit;
            for ($i=0; $i < count($request['data']) ; $i++) { 
                $idProduct = openssl_encrypt($request['data'][$i]['idproduct'],METHOD,KEY);
                $favorite = '';
                $routeP = base_url()."/shop/product/".$request['data'][$i]['route'];
                $routeC = base_url()."/shop/category/".$request['data'][$i]['routec'];
                $price ='<p class="m-0 fs-5 product-price"><strong>'.formatNum($request['data'][$i]['price']).'</strong></p>';
                $btnAdd ='<button type="button" class="btn btn-primary product-card-add">Add to cart</a>';
                $discount="";
                $rate="";
                if($request['data'][$i]['favorite']== 0){
                    $favorite = '<button type="button" class="btn addWishList pe-2 ps-2 "><i class="far fa-heart " data-bs-toggle="tooltip" data-bs-placement="top" title="Add to wishlist"></i></button>';
                }else{
                    $favorite = '<button type="button" class="btn addWishList pe-2 ps-2 active"><i class="fas fa-heart text-danger " data-bs-toggle="tooltip" data-bs-placement="top" title="Add to wishlist"></i></button>';
                }
                if($request['data'][$i]['status'] == 1 && $request['data'][$i]['stock']>0){
                    if($request['data'][$i]['discount']>0){
                        $price = '<p class="m-0 fs-5 product-price"><strong>'.formatNum($request['data'][$i]['priceDiscount']).'</strong><span>'.formatNum($request['data'][$i]['price']).'</span></p>';
                        $discount ='<p class="product-discount">-'.$request['data'][$i]['discount'].'%</p>';
                    }
                }else if($request['data'][$i]['status'] == 1 && $request['data'][$i]['stock']==0){
                    $btnAdd="";
                    $price='<p class="m-0 fs-5 product-price text-danger">Sold out</p>';
                }else{
                    $btnAdd ="";
                    $price="";
                }
                for ($j=0; $j < 5; $j++) { 
                    if($request['data'][$i]['rate']!=null && $j >= intval($request['data'][$i]['rate'])){
                        $rate.='<i class="far me-1 fa-star"></i>';
                    }else if($request['data'][$i]['rate']==null){
                        $rate.='<i class="far me-1 fa-star"></i>';
                    }else{
                        $rate.='<i class="fas me-1 fa-star"></i>';
                    }
                }
                $html .='
                <div class="col-lg-4 col-md-6 product-item" data-id="'.$idProduct.'" data-price="'.$request['data'][$i]['price'].'" data-rate="'.$request['data'][$i]['rate'].'">
                    <div class="product-card">
                        '.$discount.'
                        <div class="product-img">
                            <img src="'.$request['data'][$i]['url'].'" alt="'.$request['data'][$i]['name'].'">
                            '.$btnAdd.'
                        </div>
                        <div class="product-info">
                            <a class="m-0 product-category fw-bold" href="'.$routeC.'">'.$request['data'][$i]['category'].'</a>
                            <a href="'.$routeP.'">
                                <h3 class="product-title fw-bold">'.$request['data'][$i]['name'].'</h3>
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
            
            $arrResponse = array("html"=>$html,"total"=>$request['total']);
            echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
            die();
        }*/
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
                    $data = array("name"=>$request['name'],"image"=>$request['image'][0],"route"=>base_url()."/shop/product/".$request['route']);

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
                                        $arrResponse = array("status"=>false,"msg"=>"Not enough units","data"=>$data);
                                        $flag = false;
                                        break;
                                    }else{
                                        $_SESSION['arrCart'] = $arrCart;
                                        foreach ($_SESSION['arrCart'] as $quantity) {
                                            $qtyCart += $quantity['qty'];
                                        }
                                        $arrResponse = array("status"=>true,"msg"=>"It has been added to your cart.","qty"=>$qtyCart,"data"=>$data);
                                    }
                                    $flag =false;
                                    break;
                                }
                            }
                            if($flag){
                                if($qty > $request['stock']){
                                    $arrResponse = array("status"=>false,"msg"=>"Not enough units","data"=>$data);
                                    $_SESSION['arrCart'] = $arrCart;
                                }else{
                                    array_push($arrCart,$arrProduct);
                                    $_SESSION['arrCart'] = $arrCart;
                                    foreach ($_SESSION['arrCart'] as $quantity) {
                                        $qtyCart += $quantity['qty'];
                                    }
                                    $arrResponse = array("status"=>true,"msg"=>"It has been added to your cart.","qty"=>$qtyCart,"data"=>$data);
                                }
                            }
                        }else{
                            if($qty > $request['stock']){
                                $arrResponse = array("status"=>false,"msg"=>"Not enough units","data"=>$data);
                            }else{
                                array_push($arrCart,$arrProduct);
                                $_SESSION['arrCart'] = $arrCart;
                                foreach ($_SESSION['arrCart'] as $quantity) {
                                    $qtyCart += $quantity['qty'];
                                }
                                $arrResponse = array("status"=>true,"msg"=>"It has been added to your cart.","qty"=>$qtyCart,"data"=>$request);
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
        public function setReview(){
            if($_POST){
                $idReview = intval($_POST['idReview']);
                if($idReview>0){
                    if(empty($_POST['intRate']) || empty($_POST['txtReview']) || empty($_POST['idProduct'])){
                        $arrResponse = array("status"=>false,"msg"=>"Please rate it and write your review.");
                        echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
                    }else{
                        $this->updateReview(); 
                    }
                    
                }else{
                    if(!isset($_SESSION['login'])){
                        $arrResponse = array("login"=>false,"msg"=>"Please login to share you review.");
                    }else{
                        $idUser = $_SESSION['idUser'];
                        $idProduct = intval(openssl_decrypt($_POST['idProduct'],METHOD,KEY));
                        $intRate = intval($_POST['intRate']);
                        $strReview = strClean($_POST['txtReview']);
                        $request = $this->setReviewT($idProduct,$idUser,$strReview,$intRate);
                        //dep($request);exit;
                        if($request>1){
                            $reviews = $this->getReviewsT($idProduct,"");
                            $rate = $this->getRate($idProduct);
                            $html="";
                            for ($i=0; $i < count($reviews); $i++) { 
    
                                $image = media()."/images/uploads/".$reviews[$i]['image'];
                                $name = $reviews[$i]['firstname']." ".$reviews[$i]['lastname'];
                                $rateComment ="";
                                $options="";
                                if($_SESSION['idUser'] == $reviews[$i]['personid']){
                                    $options='<a href="#formReview" data-id="'.$reviews[$i]['id'].'" onclick="editReview('.$reviews[$i]['id'].')" title="edit" class="btn text-dark editComment"><i class="fas fa-pen"></i></a>
                                    <button type="button" class="btn text-dark" onclick="deleteReview('.$reviews[$i]['id'].')" title="delete"><i class="fas fa-trash"></i></button>';
                                }
                                for ($j = 0; $j < 5; $j++) {
                                    if($j >= intval($reviews[$i]['rate'])){
                                        $rateComment.='<i class="far fa-star"></i>';
                                    }else{
                                        $rateComment.='<i class="fas fa-star"></i>';
                                    }
                                }
    
                                $html.='
                                <li class="comment-block" data-name="'.$name.'">
                                    <div class="comment-img">
                                        <img src="'.$image.'?>" alt="'.$name.'">
                                        <div class="product-rate text-center mt-2 mb-2">'.$rateComment.'</div>
                                        <p class="text-center fw-bold">'.$reviews[$i]['date'].'</p>
                                    </div>
                                    <div class="comment-feedb">
                                        <p>'.$reviews[$i]['description'].'</p>
                                        <div class="d-flex justify-content-between flex-wrap">
                                            <h3>'.$name.'</h3>
                                            <div class="d-flex justify-content-between align-items-center">
                                                '.$options.'
                                            </div>
                                        </div>
                                    </div>
                                </li>
                                ';
                            }
                            $arrResponse = array("status"=>true,"msg"=>"Your review has been shared.","html"=>$html,"rate"=>$rate);
                        }else if(is_array($request)){
                            $arrResponse = array("status"=>false,"msg"=>"You have already shared your review before. Edit it if you want.","id"=>$request['id']);
                        }else{
                            $arrResponse = array("status"=>false,"msg"=>"Error, try again.");
                        }
                    }
                    echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
                }
            }
            die();
        }
        public function updateReview(){
            if($_POST){
                if(empty($_POST['intRate']) || empty($_POST['txtReview']) || empty($_POST['idProduct']) || empty($_POST['idReview'])){
                    $arrResponse = array("status"=>false,"msg"=>"Please rate it and write your review.");
                }else if(!isset($_SESSION['login'])){
                    $arrResponse = array("login"=>false,"msg"=>"Please login to share you review.");
                }else{
                    $idUser = $_SESSION['idUser'];
                    $idReview = intval($_POST['idReview']);
                    $idProduct = intval(openssl_decrypt($_POST['idProduct'],METHOD,KEY));
                    $intRate = intval($_POST['intRate']);
                    $strReview = strClean($_POST['txtReview']);

                    $request = $this->updateReviewT($idReview,$idProduct,$idUser,$strReview,$intRate);
                    if($request>0){
                        $reviews = $this->getReviewsT($idProduct,"");
                        $rate = $this->getRate($idProduct);
                        $html="";
                        for ($i=0; $i < count($reviews); $i++) { 

                            $image = media()."/images/uploads/".$reviews[$i]['image'];
                            $name = $reviews[$i]['firstname']." ".$reviews[$i]['lastname'];
                            $rateComment ="";
                            $options="";
                            if($_SESSION['idUser'] == $reviews[$i]['personid']){
                                $options='<a href="#formReview" data-id="'.$reviews[$i]['id'].'" onclick="editReview('.$reviews[$i]['id'].')" title="edit" class="btn text-dark editComment"><i class="fas fa-pen"></i></a>
                                <button type="button" class="btn text-dark" onclick="deleteReview('.$reviews[$i]['id'].')" title="delete"><i class="fas fa-trash"></i></button>';
                            }
                            for ($j = 0; $j < 5; $j++) {
                                if($j >= intval($reviews[$i]['rate'])){
                                    $rateComment.='<i class="far fa-star"></i>';
                                }else{
                                    $rateComment.='<i class="fas fa-star"></i>';
                                }
                            }

                            $html.='
                            <li class="comment-block" data-name="'.$name.'">
                                <div class="comment-img">
                                    <img src="'.$image.'?>" alt="'.$name.'">
                                    <div class="product-rate text-center mt-2 mb-2">'.$rateComment.'</div>
                                    <p class="text-center fw-bold">'.$reviews[$i]['date'].'</p>
                                </div>
                                <div class="comment-feedb">
                                    <p>'.$reviews[$i]['description'].'</p>
                                    <div class="d-flex justify-content-between flex-wrap">
                                        <h3>'.$name.'</h3>
                                        <div class="d-flex justify-content-between align-items-center">
                                            '.$options.'
                                        </div>
                                    </div>
                                </div>
                            </li>
                            ';
                        }
                        $arrResponse = array("status"=>true,"msg"=>"Your review has been updated.","html"=>$html,"rate"=>$rate);
                    }else{
                        $arrResponse = array("status"=>false,"msg"=>"Error, try again.");
                    }
                }
                echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
            }
            die();
        }
        public function delReview(){
            if($_POST){
                $id = intval($_POST['idReview']);
                $idProduct = intval(openssl_decrypt($_POST['idProduct'],METHOD,KEY));
                $request = $this->deleteReviewT($id); 
                $reviews = $this->getReviewsT($idProduct,"");
                $rate = $this->getRate($idProduct);
                $html="";
                for ($i=0; $i < count($reviews); $i++) { 

                    $image = media()."/images/uploads/".$reviews[$i]['image'];
                    $name = $reviews[$i]['firstname']." ".$reviews[$i]['lastname'];
                    $rateComment ="";
                    $options="";
                    if($_SESSION['idUser'] == $reviews[$i]['personid']){
                        $options='<a href="#formReview" data-id="'.$reviews[$i]['id'].'" onclick="editReview('.$reviews[$i]['id'].')" title="edit" class="btn text-dark editComment"><i class="fas fa-pen"></i></a>
                        <button type="button" class="btn text-dark" onclick="deleteReview('.$reviews[$i]['id'].')" title="delete"><i class="fas fa-trash"></i></button>';
                    }
                    for ($j = 0; $j < 5; $j++) {
                        if($j >= intval($reviews[$i]['rate'])){
                            $rateComment.='<i class="far fa-star"></i>';
                        }else{
                            $rateComment.='<i class="fas fa-star"></i>';
                        }
                    }

                    $html.='
                    <li class="comment-block" data-name="'.$name.'">
                        <div class="comment-img">
                            <img src="'.$image.'?>" alt="'.$name.'">
                            <div class="product-rate text-center mt-2 mb-2">'.$rateComment.'</div>
                            <p class="text-center fw-bold">'.$reviews[$i]['date'].'</p>
                        </div>
                        <div class="comment-feedb">
                            <p>'.$reviews[$i]['description'].'</p>
                            <div class="d-flex justify-content-between flex-wrap">
                                <h3>'.$name.'</h3>
                                <div class="d-flex justify-content-between align-items-center">
                                    '.$options.'
                                </div>
                            </div>
                        </div>
                    </li>
                    ';
                }
                $arrResponse = array("status"=>true,"msg"=>"Review has been deleted.","html"=>$html,"rate"=>$rate);
            }
            echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
            die();
        }
        public function getReview(){
            if($_POST){
                $idReview = intval($_POST['idReview']);
                $request = $this->getReviewT($idReview);
                echo json_encode($request,JSON_UNESCAPED_UNICODE);
            }
            die();
        }
        public function sortReviews(){
            if($_POST){

                $idProduct = intval(openssl_decrypt($_POST['idProduct'],METHOD,KEY));
                $option = intval($_POST['intSort']);
                $reviews = $this->getReviewsT($idProduct,$option);
                $rate = $this->getRate($idProduct);
                $html="";

                for ($i=0; $i < count($reviews); $i++) { 

                    $image = media()."/images/uploads/".$reviews[$i]['image'];
                    $name = $reviews[$i]['firstname']." ".$reviews[$i]['lastname'];
                    $rateComment ="";
                    $options="";
                    if($_SESSION['idUser'] == $reviews[$i]['personid']){
                        $options='<a href="#formReview" data-id="'.$reviews[$i]['id'].'" onclick="editReview('.$reviews[$i]['id'].')" title="edit" class="btn text-dark editComment"><i class="fas fa-pen"></i></a>
                        <button type="button" class="btn text-dark" onclick="deleteReview('.$reviews[$i]['id'].')" title="delete"><i class="fas fa-trash"></i></button>';
                    }
                    for ($j = 0; $j < 5; $j++) {
                        if($j >= intval($reviews[$i]['rate'])){
                            $rateComment.='<i class="far fa-star"></i>';
                        }else{
                            $rateComment.='<i class="fas fa-star"></i>';
                        }
                    }

                    $html.='
                    <li class="comment-block" data-name="'.$name.'">
                        <div class="comment-img">
                            <img src="'.$image.'?>" alt="'.$name.'">
                            <div class="product-rate text-center mt-2 mb-2">'.$rateComment.'</div>
                            <p class="text-center fw-bold">'.$reviews[$i]['date'].'</p>
                        </div>
                        <div class="comment-feedb">
                            <p>'.$reviews[$i]['description'].'</p>
                            <div class="d-flex justify-content-between flex-wrap">
                                <h3>'.$name.'</h3>
                                <div class="d-flex justify-content-between align-items-center">
                                    '.$options.'
                                </div>
                            </div>
                        </div>
                    </li>
                    ';
                }
                $arrResponse = array("status"=>true,"msg"=>"Review has been deleted.","html"=>$html,"rate"=>$rate);
            }
            echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
            die();  
        }
        public function getProductsPage($page){
            $page = intval($page);
            $request = $this->getProductsPageT($page);
            $request = $request['data'];
            $html="";
            for ($i=0; $i < count($request) ; $i++) { 
                $idProduct = openssl_encrypt($request[$i]['idproduct'],METHOD,KEY);
                $favorite = '';
                $routeP = base_url()."/shop/product/".$request[$i]['route'];
                $routeC = base_url()."/shop/category/".$request[$i]['routec'];
                $price ='<p class="m-0 fs-5 product-price"><strong>'.formatNum($request[$i]['price']).'</strong></p>';
                $btnAdd ='<button type="button" class="btn btn-primary product-card-add" data-id="'.$idProduct.'">Add to cart</a>';
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
                    if($request[$i]['rate']!=null && $j >= intval($request[$i]['rate'])){
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
    }
?>