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

        /******************************Views************************************/
        public function shop(){
            $data['page_tag'] = NOMBRE_EMPRESA;
            $data['page_title'] = "Shop | ".NOMBRE_EMPRESA;
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
            $data['page_title'] = "Shop | ".NOMBRE_EMPRESA;
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
            $data['page_name'] = "product";
            $data['product'] = $this->getProductPageT($params);
            $data['review'] = $this->getRate($data['product']['idproduct']);
            $data['reviews'] = $this->getReviews($data['product']['idproduct']);
            $data['products'] = $this->getProductsRandT(4);
            $data['page_title'] =$data['product']['name']." | ".NOMBRE_EMPRESA;
            $this->views->getView($this,"product",$data); 
        }
        public function cart(){
            $data['page_tag'] = NOMBRE_EMPRESA;
            $data['page_title'] ="My cart | ".NOMBRE_EMPRESA;
            $data['page_name'] = "cart";
            $data['shipping'] = $this->selectShippingMode();
            $_SESSION['arrShipping'] = $data['shipping'];
            $this->views->getView($this,"cart",$data); 
        }
        public function checkout(){
            if(isset($_SESSION['login']) && isset($_SESSION['arrCart']) && !empty($_SESSION['arrCart'])){
                //$this->setDetailTemp();
                $data['page_tag'] = NOMBRE_EMPRESA;
                $data['page_title'] ="Checkout | ".NOMBRE_EMPRESA;
                $data['page_name'] = "checkout";
                $data['coupon'] = $this->checkCoupon($_SESSION['idUser']);
                $this->views->getView($this,"checkout",$data); 
            }else{
                header("location: ".base_url());
                die();
            }
        }
        public function confirm(){
            if(isset($_SESSION['orderData'])){
                $data['page_tag'] = NOMBRE_EMPRESA;
                $data['page_title'] ="Confirm order | ".NOMBRE_EMPRESA;
                $data['page_name'] = "confirm";
                $data['orderData'] = $_SESSION['orderData'];
                unset($_SESSION['orderData']);
                $this->views->getView($this,"confirm",$data); 
            }else{
                header("location: ".base_url());
                die();
            }
        }
        /******************************Cart methods************************************/
        public function addCart(){
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
                            "discount" => $request['discount'],
                            "stock"=>$request['stock']
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
                                $arrResponse = array("status"=>true,"msg"=>"It has been added to your cart.","qty"=>$qtyCart,"data"=>$data);
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
                foreach ($_SESSION['arrCart'] as $quantity) {
                    $qtyCart += $quantity['qty'];
                }
                if(!empty($_SESSION['arrShipping']['city'])){
                    $arrTotal = $this->calculateTotal($_SESSION['arrCart'],$_SESSION['arrShipping'],$_SESSION['arrShipping']['city']['id']);
                }else{
                    $arrTotal = $this->calculateTotal($_SESSION['arrCart'],$_SESSION['arrShipping']);
                }
                
                $subtotal = $arrTotal['subtotal'];
                $total = $arrTotal['total'];
                $arrResponse = array(
                    "status"=>true,
                    "msg"=>"It has been deleted.",
                    "subtotal"=>formatNum($subtotal),
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
                $status=false;
                if(isset($_SESSION['login']) && !empty($_SESSION['arrCart'])){
                    $status=true;
                }
                $arrResponse = array("status"=>$status,"items"=>$html,"total"=>formatNum($total));
            }else{
                $arrResponse = array("items"=>"","total"=>formatNum(0));
            }
            echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
            die();
        }
        public function updateCart(){
            if($_POST){
                $id = $_POST['idProduct'];
                $total =0;
                $totalPrice = 0;
                $subtotal = 0;
                $arrTotal = array();
                $qty = intval($_POST['qty']);
                
                if($qty > 0){
                    
                    $arrCart = $_SESSION['arrCart'];
                    for ($i=0; $i < count($arrCart) ; $i++) { 
                        if($arrCart[$i]['idproduct'] == $id){
                            $arrCart[$i]['qty'] = $qty;
                            if($arrCart[$i]['discount']>0){
                                $totalPrice = $arrCart[$i]['qty']*($arrCart[$i]['price']-($arrCart[$i]['price']*($arrCart[$i]['discount']*0.01)));
                            }else{
                                $totalPrice =$arrCart[$i]['qty']*$arrCart[$i]['price'];
                            }
                            break;
                        }
                    }
                    $_SESSION['arrCart'] = $arrCart;
                    if(!empty($_SESSION['arrShipping']['city'])){
                        $arrTotal = $this->calculateTotal($_SESSION['arrCart'],$_SESSION['arrShipping'],$_SESSION['arrShipping']['city']['id']);
                    }else{
                        $arrTotal = $this->calculateTotal($_SESSION['arrCart'],$_SESSION['arrShipping']);
                    }

                    $subtotal = $arrTotal['subtotal'];
                    $total = $arrTotal['total'];

                    $arrResponse = array("status"=>true,"total" =>formatNum($total),"subtotal"=>formatNum($subtotal),"totalPrice"=>formatNum($totalPrice));
                }else{
                    $arrResponse = array("status"=>false,"msg" =>"Data error.");
                }
                echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
            }
            die();
        }
        public function calculateShippingCity($id){
            $id = intval($id);
            $info = $this->calculateTotal($_SESSION['arrCart'],$_SESSION['arrShipping'],$id);
            $arrResponse = array("total"=>formatNum($info['total']));
            echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
            die();
        }

        /******************************wishlist methods************************************/
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
        
        /******************************Customer methods************************************/
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
        public function setSuscriber(){
            if($_POST){
                if(empty($_POST['txtEmailSuscribe'])){
                    $arrResponse = array("status"=>false,"msg"=>"Data error");
                }else{
                    $strEmail = strClean(strtolower($_POST['txtEmailSuscribe']));
                    $request = $this->setSuscriberT($strEmail);
                    if($request>0){
                        $request = $this->statusCouponSuscriberT();
                        $dataEmail = array('email_remitente' => EMAIL_REMITENTE, 
                                                'email_usuario'=>$strEmail,
                                                'asunto' =>'You have subscribed on '.NOMBRE_EMPRESA,
                                                "code"=>$request['code'],
                                                "discount"=>$request['discount']);
                        sendEmail($dataEmail,'email_suscriber');
                        $arrResponse = array("status"=>true,"msg"=>"Subscribed");
                    }else if($request=="exists"){
                        $arrResponse = array("status"=>false,"msg"=>"You have subscribed before.");
                    }else{
                        $arrResponse = array("status"=>false,"msg"=>"Error has ocurred, try again.");
                    }
                }
                echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
            }
            die();
        }
        public function statusCouponSuscriber(){
            $request = $this->statusCouponSuscriberT();
            if(!empty($request)){
                $arrResponse = array("status"=>true,"discount"=>$request['discount']);
            }else{
                $arrResponse = array("status"=>false,"msg"=>"Coupon doesn't exists or is inactive");
            }
            echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
            die();
        }
        /******************************Reviews methods************************************/
        public function getReviews($idProduct,$sort=null,$search=null){
            if(is_numeric($idProduct)){
                $idProduct = intval($idProduct);
            }else{
                $idProduct= intval(openssl_decrypt($idProduct,METHOD,KEY));
            }
            $reviews="";
            if($sort != null){
                $reviews = $this->getReviewsT($idProduct,$sort);
                //dep($reviews);exit;
            }else if($search!=null){
                $reviews = $this->getSearchReviewsT($idProduct,$search);
            }else{
                $reviews = $this->getReviewsT($idProduct);
            }
            
            $rate = $this->getRate($idProduct);
            $html="";
            for ($i=0; $i < count($reviews); $i++) { 
                $image = media()."/images/uploads/".$reviews[$i]['image'];
                $name = $reviews[$i]['firstname']." ".$reviews[$i]['lastname'];
                $rateComment ="";
                $options="";
                if(isset($_SESSION['login'])){
                    if($_SESSION['idUser'] == $reviews[$i]['personid']){
                        $options.='<a href="#formReview" class="p-0 me-2 t-p btn editComment" data-id="'.$reviews[$i]['id'].'" onclick="editReview('.$reviews[$i]['id'].')" title="edit" >Edit</a>';
                    }
                    if($_SESSION['idUser'] == $reviews[$i]['personid'] || $_SESSION['userData']['roleid']==1){
                        $options.='<button type="button" class="btn t-p p-0" onclick="deleteReview('.$reviews[$i]['id'].')" title="delete">Delete</button>';
                    }
                }
                for ($j = 0; $j < 5; $j++) {
                    if($j >= intval($reviews[$i]['rate'])){
                        $rateComment.='<i class="far fa-star"></i>';
                    }else{
                        $rateComment.='<i class="fas fa-star"></i>';
                    }
                }

                $html.='
                <li class="comment-block">
                    <div class="row mb-3">
                        <div class="col-12">
                            <div class="comment-info d-flex justify-content-between">
                                <div class="d-flex justify-content-start">
                                    <div class="comment-img me-1">
                                        <img src="'.$image.'" alt="'.$name.'">
                                    </div>
                                    <div>
                                        <p class="m-0">'.$name.'</p>
                                        <p class="m-0 text-secondary">'.$reviews[$i]['date'].'</p>
                                    </div>
                                </div>
                                <div class="product-rate text-end m-0">
                                    '.$rateComment.'
                                    <p class="m-0 text-secondary">'.$reviews[$i]['dateupdated'].'</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 mt-1">
                            <p class="m-0">'.$reviews[$i]['description'].'</p>
                            <div class="t-p text-end">'.$options.'</div>
                        </div>
                        
                    </div>
                </li>
                ';
            }
            $arrResponse = array("html"=>$html,"rate"=>$rate);
            return $arrResponse;
        }
        public function setReview(){
            //dep($_POST);exit;
            if($_POST){
                if(isset($_SESSION['login'])){
                    if(empty($_POST['intRate']) || empty($_POST['txtReview']) || empty($_POST['idProduct'])){
                        $arrResponse = array("status"=>false,"msg"=>"Please rate it and write your review.");
                        echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
                    }else{
                        $idUser = $_SESSION['idUser'];
                        $idReview = intval($_POST['idReview']);
                        $idProduct = intval(openssl_decrypt($_POST['idProduct'],METHOD,KEY));
                        $intRate = intval($_POST['intRate']);
                        $strReview = strClean($_POST['txtReview']);
                        $option=0;
                        $request="";
                        

                        if($idReview==0){
                            $option = 1;
                            $request = $this->setReviewT($idProduct,$idUser,$strReview,$intRate);
                            
                        }else{
                            $option = 2;
                            $request = $this->updateReviewT($idReview,$idProduct,$idUser,$strReview,$intRate);
                        }
                        $reviews = $this->getReviews($idProduct);
                        if($option ==1){
                            if(!is_array($request) && $request>0){
                                $arrResponse = array("status"=>true,"msg"=>"Your review has been shared.","html"=>$reviews['html'],"rate"=>$reviews['rate']);
                            }else if(is_array($request)){
                                $arrResponse = array("status"=>false,"msg"=>"You have already shared your review before. Edit it if you want.","id"=>$request['id']);
                            }else{
                                $arrResponse = array("status"=>false,"msg"=>"Error, try again.");
                            }
                        }else{
                            $arrResponse = array("status"=>true,"msg"=>"Your review has updated.","html"=>$reviews['html'],"rate"=>$reviews['rate']);
                        }
                    }
                }else{
                    $arrResponse = array("login"=>false,"msg"=>"Please login to share you review.");
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
                $reviews = $this->getReviews($idProduct);
                $arrResponse = array("status"=>true,"msg"=>"Review has been deleted.","html"=>$reviews['html'],"rate"=>$reviews['rate']);
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
                $reviews = $this->getReviews($idProduct,$option);
                $arrResponse = array("status"=>true,"html"=>$reviews['html'],"rate"=>$reviews['rate']);
            }
            echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
            die();  
        }
        public function searchReviews(){
            if($_POST){
                $idProduct = intval(openssl_decrypt($_POST['idProduct'],METHOD,KEY));
                $search = strClean($_POST['strSearch']);
                $reviews = $this->getReviews($idProduct,null,$search);
                $arrResponse = array("status"=>true,"html"=>$reviews['html'],"rate"=>$reviews['rate']);
            }
            echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
            die();  
        }
        /******************************Checkout methods************************************/
        public function checkData(){
            if($_POST){
                if(empty($_POST['txtNameOrder']) || empty($_POST['txtLastNameOrder']) || empty($_POST['txtEmailOrder']) || 
                empty($_POST['txtPhoneOrder']) || empty($_POST['txtAddressOrder']) || empty($_POST['country'])
                || empty($_POST['state']) || empty($_POST['city'])){
                    $arrResponse = array("status"=>false,"msg"=>"Data error");
                }else{
                    $arrData = array(
                        "firstname"=>strClean(ucwords($_POST['txtNameOrder'])),
                        "lastname"=>strClean(ucwords($_POST['txtLastNameOrder'])),
                        "email"=>strClean(strtolower($_POST['txtEmailOrder'])),
                        "phone"=>strClean($_POST['txtPhoneOrder']),
                        "address"=>strClean($_POST['txtAddressOrder']),
                        "country"=>strClean($_POST['country']),
                        "state"=>strClean($_POST['state']),
                        "city"=>strClean($_POST['city']),
                        "postalcode" =>strClean($_POST['txtPostCodeOrder']),
                        "note"=>strClean($_POST['txtNote'])
                    );
                    $_SESSION['checkData'] = $arrData;
                    $arrResponse = array("status"=>true,"msg"=>"Data correct");
                }
                echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
            }
            die();
        }
        public function setOrder(){
            if($_POST){
                if(empty($_POST['data']) || empty($_SESSION['checkData'])){
                    $arrResponse = array("status"=>false,"msg"=>"Data error");
                }else{
                    $arrCart = array();
                    $total = 0;
                    $idUser = $_SESSION['idUser'];
                    $objPaypal = json_decode($_POST['data']);
                    $arrInfo = $_SESSION['checkData'];
                    unset($_SESSION['checkData']);

                    if(!empty($_SESSION['arrCart'])){
                        $arrProducts = $_SESSION['arrCart'];
                        foreach ($arrProducts as $product) {
                            if($product['discount']>0){
                                $total += $product['qty']*($product['price']-($product['price']*($product['discount']*0.01)));
                            }else{
                                $total+=$product['qty']*$product['price'];
                            }
                        }
                        $dataCoupon = $this->checkCoupon($idUser);
                        $idCoupon = 0;
                        if(!empty($dataCoupon)){
                            $idCoupon = $dataCoupon['id'];
                            $total = $total-(($dataCoupon['discount']/100)*$total);
                            $this->updateCoupon($idUser,$dataCoupon['code']);
                        }
                        if(is_object($objPaypal)){

                            $dataPaypal = $_POST['data'];
                            $idTransaction = $objPaypal->purchase_units[0]->payments->captures[0]->id;
                            $status = $objPaypal->purchase_units[0]->payments->captures[0]->status;
                            $firstname = $arrInfo['firstname'];
                            $lastname = $arrInfo['lastname'];
                            $email = $arrInfo['email'];
                            $phone = $arrInfo['phone'];
                            $postalCode = $arrInfo['postalcode'];  
                            $country = $arrInfo['country'];
                            $state = $arrInfo['state'];
                            $city = $arrInfo['city'];
                            $address = $arrInfo['address'];
                            $note = $arrInfo['note'];

                            $requestOrder = $this->insertOrder($idUser,$idTransaction,$dataPaypal,$firstname,$lastname,$email,$phone,$country,$state,$city,$address,
                            $postalCode,$note,$total,$idCoupon,$status);

                            if($requestOrder>0){

                                $arrOrder = array("idorder"=>$requestOrder,"iduser"=>$_SESSION['idUser'],"products"=>$_SESSION['arrCart']);
                                $request = $this->insertOrderDetail($arrOrder);
                                $orderInfo = $this->getOrder($requestOrder);
                                $orderInfo['coupon'] = $dataCoupon;
                                $dataEmailOrden = array(
                                    'asunto' => "An order has been generated",
                                    'email_usuario' => $_SESSION['userData']['email'], 
                                    'email_remitente'=>EMAIL_REMITENTE,
                                    'email_copia' => EMAIL_REMITENTE,
                                    'order' => $orderInfo );

								sendEmail($dataEmailOrden,"email_order");
                                $idOrder = openssl_encrypt($requestOrder,METHOD,KEY);
                                $idTransaction = openssl_encrypt($orderInfo['order']['idtransaction'],METHOD,KEY);
                                $arrResponse = array("status"=>true,"order"=>$idOrder,"transaction"=>$idTransaction,"msg"=>"Order placed");
                                $_SESSION['orderData'] = $arrResponse;
                                unset($_SESSION['arrCart']);
                            }else{
                                $arrResponse = array("status"=>false,"msg"=>"The order could not be placed.");
                            }
                        }else{
                            $arrResponse = array("status"=>false,"msg"=>"An error has occurred in the transaction.");
                        }
                    }else{
                        $arrResponse = array("status"=>false,"msg"=>"An error has occurred in the transaction.");
                    }
                }
                echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
            }
            die();
        }
        public function setCouponCode(){
            if($_POST){
                if(empty($_POST['txtCoupon'])){
                    $arrResponse = array("status"=>false,"msg"=>"Data error"); 
                }else{
                    $idUser = $_SESSION['idUser'];
                    $strCoupon = strClean(strtoupper($_POST['txtCoupon']));
                    $request = $this->setCouponCodeT($idUser,$strCoupon);
                    if(is_array($request)){
                        $total=0;
                        $arrProducts = $_SESSION['arrCart'];
                        foreach ($arrProducts as $product) {
                            if($product['discount']>0){
                                $total += $product['qty']*($product['price']-($product['price']*($product['discount']*0.01)));
                            }else{
                                $total+=$product['qty']*$product['price'];
                            }
                        }
                        //$_SESSION['couponData']['data'] = $request;
                       // $_SESSION['couponData']['idUser'] = $_SESSION['idUser'];
                        $total = $total-(($request['discount']/100)*$total);
                        $request['total'] = formatNum($total);
                        $arrResponse=array("status"=>true,"data"=>$request);

                    }else if($request==""){
                        $arrResponse = array("status"=>false,"msg"=>"Coupon doesn't exists or it's inactive."); 
                    }else if($request =="exists"){
                        $arrResponse = array("status"=>false,"msg"=>"You have already used your coupon before."); 
                    }
                }
                echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
            }
            die();
        }
        public function getCountries(){
            $request = $this->selectCountries();
            $html="";
            for ($i=0; $i < count($request) ; $i++) { 
                $html.='<option value="'.$request[$i]['id'].'">'.$request[$i]['name'].'</option>';
            }

            echo json_encode($html,JSON_UNESCAPED_UNICODE);
            die();
        }
        public function getSelectCountry($id){
            $request = $this->selectStates($id);
            $html="";
            for ($i=0; $i < count($request) ; $i++) { 
                $html.='<option value="'.$request[$i]['id'].'">'.$request[$i]['name'].'</option>';
            }
            echo json_encode($html,JSON_UNESCAPED_UNICODE);
            die();
        }
        public function getSelectState($id){
            $request = $this->selectCities($id);
            $html="";
            for ($i=0; $i < count($request) ; $i++) { 
                $html.='<option value="'.$request[$i]['id'].'">'.$request[$i]['name'].'</option>';
            }
            echo json_encode($html,JSON_UNESCAPED_UNICODE);
            die();
        }
        /******************************General shop methods************************************/
        public function search(){
            if($_POST){
                $strSearch = strClean(strtolower($_POST['txtSearch']));
                $request = $this->getProductsSearchT($strSearch);
                if(!empty($request)){
                    $html="";
                    for ($i=0; $i < count($request) ; $i++) { 
                        $idProduct = openssl_encrypt($request[$i]['idproduct'],METHOD,KEY);
                        $price ='<p class="m-0 text-dark">'.formatNum($request[$i]['price']).'</p>';
                        $btnAdd ='<div class="border border-dark product-card-add c-p" data-id="'.$idProduct.'"><i class="fas fa-shopping-cart" aria-hidden="true"></i></div>';
                        $discount="";
                        $rate="";
                        $route = base_url()."/shop/product/".$request[$i]['route'];
                        if($request[$i]['status'] == 1 && $request[$i]['stock']>0){
                            if($request[$i]['discount']>0){
                                $price = '<p class="m-0 text-dark">'.formatNum($request[$i]['priceDiscount']).' <span class="text-decoration-line-through t-p">'.formatNum($request[$i]['price']).'</span></p>';
                                $discount ='<div>-'.$request[$i]['discount'].'%</div>';
                            }
                        }else if($request[$i]['status'] == 1 && $request[$i]['stock']==0){
                            $btnAdd="";
                            $price='<p class="m-0 text-danger">Sold out</p>';
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
                        <div class="search-item">
                            <div class="search-item-info">
                                <div class="search-item-img">
                                    <img src="'.$request[$i]['url'].'" alt="'.$request[$i]['name'].'">
                                    '.$discount.'
                                </div>
                                <div class="search-item-data">
                                    <h2><a href="'.$route.'" class="text-decoration-none text-dark">'.$request[$i]['name'].'</a></h2>
                                    <div class="product-rate">
                                        '.$rate.'
                                    </div>
                                    <div>'.$price.'</div>
                                </div>
                            </div>
                            <div class="search-item-actions">
                                <div class="border border-dark quickView c-p" data-id="'.$idProduct.'"><i class="fas fa-eye"></i></div>
                                '.$btnAdd.'
                            </div>
                        </div>
                        ';
                    }
                    $arrResponse = array("status"=>true,"data"=>$html);
                }else{
                    $arrResponse = array("status"=>false,"msg"=>"No results");
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
        public function calculateTotal($arrProducts,$arrShipping,$idCity =null){
            $subtotal = 0;
            $total=0;
            
            foreach ($arrProducts as $product) {
                if($product['discount']>0){
                    $subtotal += $product['qty']*($product['price']-($product['price']*($product['discount']*0.01)));
                }else{
                    $subtotal+=$product['qty']*$product['price'];
                }
            }
            if($idCity != null){
                for ($i=0; $i < count($arrShipping['cities']) ; $i++) { 
                    if($arrShipping['cities'][$i]['id'] == $idCity){
                        $total = $subtotal + $arrShipping['cities'][$i]['value'];
                        $arrShipping['city'] = $arrShipping['cities'][$i];
                        $_SESSION['arrShipping'] = $arrShipping;
                        break;
                    }
                }
            }else{
                $total = $subtotal+$arrShipping['value'];
            }
            
            $arrTotal = array("subtotal"=>$subtotal,"total"=>$total);
            return $arrTotal;
        }
    }
?>