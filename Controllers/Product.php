<?php
    class Product extends Controllers{

        public function __construct(){
            session_start();
            if(empty($_SESSION['login'])){
                header("location: ".base_url()."/logout");
                die();
            }
            parent::__construct();
            getPermits(4);
        }
        
        public function product(){
            if($_SESSION['permitsModule']['r']){
                $data['page_tag'] = "Product";
                $data['page_title'] = "Productos";
                $data['page_name'] = "product";
                $this->views->getView($this,"product",$data);
            }else{
                header("location: ".base_url()."/logout");
                die();
            }
        }
        /*************************Product methods*******************************/
        public function getProducts(){
            if($_SESSION['permitsModule']['r']){
                $html="";
                $request = $this->model->selectProducts();
                if(count($request)>0){
                    for ($i=0; $i < count($request); $i++) { 

                        $status="";
                        $btnView = '<button class="btn btn-info m-1" type="button" title="Ver" data-id="'.$request[$i]['idproduct'].'" name="btnView"><i class="fas fa-eye"></i></button>';
                        $btnEdit="";
                        $btnDelete="";
                        $price = formatNum($request[$i]['price']);
                        if($request[$i]['discount']>0){
                            $discount = '<span class="text-success">'.$request[$i]['discount'].'% OFF</span>';
                        }else{
                            $discount = '<span class="text-danger">Sin descuento</span>';
                        }
                        if($_SESSION['permitsModule']['u']){
                            $btnEdit = '<button class="btn btn-success m-1" type="button" title="Editar" data-id="'.$request[$i]['idproduct'].'" name="btnEdit"><i class="fas fa-pencil-alt"></i></button>';
                        }
                        if($_SESSION['permitsModule']['d']){
                            $btnDelete = '<button class="btn btn-danger m-1" type="button" title="Eliminar" data-id="'.$request[$i]['idproduct'].'" name="btnDelete"><i class="fas fa-trash-alt"></i></button>';
                        }
                        if($request[$i]['status']==1){
                            $status='<span class="badge me-1 bg-success">Activo</span>';
                        }else{
                            $status='<span class="badge me-1 bg-danger">Inactivo</span>';
                        }
                        $html.='
                            <tr class="item" data-name="'.$request[$i]['name'].'">
                                <td>
                                    <img src="'.$request[$i]['image'].'">
                                </td>
                                <td><strong>Referencia: </strong>'.$request[$i]['reference'].'</td>
                                <td><strong>Nombre: </strong>'.$request[$i]['name'].'</td>
                                <td><strong>Categoría: </strong>'.$request[$i]['category'].'</td>
                                <td><strong>Subcategoría: </strong>'.$request[$i]['subcategory'].'</td>
                                <td><strong>Precio: </strong>'.$price.'</td>
                                <td><strong>Descuento: </strong>'.$discount.'</td>
                                <td><strong>Cantidad: </strong>'.$request[$i]['stock'].'</td>
                                <td><strong>Fecha de registro: </strong>'.$request[$i]['date'].'</td>
                                <td><strong>Estado: </strong>'.$status.'</td>
                                <td class="item-btn">'.$btnView.$btnEdit.$btnDelete.'</td>
                            </tr>
                        ';
                    }
                    $arrResponse = array("status"=>true,"data"=>$html);
                }else{
                    $arrResponse = array("status"=>false,"msg"=>"No hay datos");
                }
                echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
            }else{
                header("location: ".base_url()."/logout");
                die();
            }
            
            die();
        }
        public function getProduct(){
            if($_SESSION['permitsModule']['r']){
                if($_POST){
                    unset($_SESSION['filesInfo']);
                    if(empty($_POST)){
                        $arrResponse = array("status"=>false,"msg"=>"Error de datos");
                    }else{
                        $id = intval($_POST['idProduct']);
                        $request = $this->model->selectProduct($id);
                        //dep($request);exit;
                        if(!empty($request)){
                            $request['priceFormat'] = formatNum($request['price']);
                            $arrFiles = [];
                            for ($i=0; $i < count($request['image']) ; $i++) { 
                                $arr = array("name"=>$request['image'][$i]['name'],"rename"=>$request['image'][$i]['name']);
                                array_push($arrFiles,$arr);
                            }
                            $_SESSION['filesInfo'] = $arrFiles;
                            //dep($arrFiles);   
                            $arrResponse = array("status"=>true,"data"=>$request);
                        }else{
                            $arrResponse = array("status"=>false,"msg"=>"No hay datos"); 
                        }
                    }
                    echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
                }
            }else{
                header("location: ".base_url()."/logout");
                die();
            }
            die();
        }
        public function setProduct(){
            //dep($_POST);exit;
            if($_SESSION['permitsModule']['r']){
                if($_POST){
                    if(empty($_POST['txtName']) || empty($_POST['statusList']) || empty($_POST['categoryList'])
                    || empty($_POST['subcategoryList']) || empty($_POST['txtPrice']) || empty($_POST['txtStock'])){
                        $arrResponse = array("status" => false, "msg" => 'Datos incorrectos.');
                    }else{ 
                        $idProduct = intval($_POST['idProduct']);
                        $strReference = strtoupper(strClean($_POST['txtReference']));
                        $strName = ucwords(strClean($_POST['txtName']));
                        $idCategory = intval($_POST['categoryList']);
                        $idSubcategory = intval($_POST['subcategoryList']);
                        $intPrice = intval($_POST['txtPrice']);
                        $intDiscount = intval($_POST['txtDiscount']);
                        $intStock =  intval($_POST['txtStock']);
                        $intStatus = intval($_POST['statusList']);
                        $strDescription = strClean($_POST['txtDescription']);
                        $route = str_replace(" ","-",$strName);
                        $route = str_replace("?","",$route);
                        $route = strtolower(str_replace("¿","",$route));
                        $photos;
                        if(isset($_SESSION['files'])){
                            $photos = $_SESSION['files'];
                        }else if(isset($_SESSION['filesInfo'])){
                            $photos = $_SESSION['filesInfo'];
                        }
                        //dep($photos);
                        if($idProduct == 0){
                            if($_SESSION['permitsModule']['w']){
                                $option = 1;
                                $request= $this->model->insertProduct($idCategory,$idSubcategory,$strReference,$strName,$strDescription,$intPrice,$intDiscount,$intStock,$intStatus,$route,$photos);
                            }
                        }else{
                            if($_SESSION['permitsModule']['u']){
                                $option = 2;
                                $requestImg = $this->model->deleteImages($idProduct);
                                $request= $this->model->updateProduct($idProduct,$idCategory,$idSubcategory,$strReference,$strName,$strDescription,$intPrice,$intDiscount,$intStock,$intStatus,$route,$photos);
                            }
                        }
                        if($request > 0 ){
                            unset($_SESSION['files']);
                            unset($_SESSION['filesInfo']); 
                            if($option == 1){
                                $arrResponse = array('status' => true, 'msg' => 'Datos guardados.');
                            }else{
                                $arrResponse = array('status' => true, 'msg' => 'Datos Actualizados correctamente.');
                            }
                        }else if($request == 'exist'){
                            $arrResponse = array('status' => false, 'msg' => '¡Atención! el producto ya existe, ingrese otro.');		
                        }else{
                            $arrResponse = array("status" => false, "msg" => 'No es posible almacenar los datos.');
                        }
                    }
                    echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
                }
            }else{
                header("location: ".base_url()."/logout");
                die();
            }
			die();
		}
        public function delProduct(){
            if($_SESSION['permitsModule']['d']){
                if($_POST){
                    if(empty($_POST['idProduct'])){
                        $arrResponse=array("status"=>false,"msg"=>"Error de datos");
                    }else{
                        $id = intval($_POST['idProduct']);
                        $request = $this->model->selectImages($id);
                        for ($i=0; $i < count($request) ; $i++) { 
                            deleteFile($request[$i]['name']);
                        }
                        $request = $this->model->deleteProduct($id);
                        if($request=="ok"){
                            $arrResponse = array("status"=>true,"msg"=>"Se ha eliminado");
                        }else{
                            $arrResponse = array("status"=>false,"msg"=>"No se ha podido eliminar, inténtelo de nuevo.");
                        }
                    }
                    echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
                }
            }else{
                header("location: ".base_url()."/logout");
                die();
            }
            die();
        }
        public function getSelectCategories(){
            $html="";
            $request = $this->model->selectCategories();
            if(count($request)>0){
                for ($i=0; $i < count($request); $i++) { 
                    $html.='<option value="'.$request[$i]['idcategory'].'">'.$request[$i]['name'].'</option>';
                }
                $arrResponse = array("data"=>$html);
            }else{
                $arrResponse = array("data"=>"");
            }
            echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
            die();
        }
        public function getSelectSubcategories(){
            if($_POST){
                $idCategory = intval(strClean($_POST['idCategory']));
                $html="";
                $request = $this->model->selectSubcategories($idCategory);
                if(count($request)>0){
                    for ($i=0; $i < count($request); $i++) { 
                        $html.='<option value="'.$request[$i]['idsubcategory'].'">'.$request[$i]['name'].'</option>';
                    }
                    $arrResponse = array("data"=>$html);
                }else{
                    $arrResponse = array("data"=>"");
                }
                echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
            }
            die();
        }
        public function setImg(){
            $arrFiles;
            $id = intval($_POST['id']);
            if($id == 0){
                if(isset($_SESSION['files'])){
                    $arrFilesInfo = $_SESSION['files'];
                    $arrFiles = orderFiles($_FILES['txtImg']);
                    for ($i=0; $i < count($arrFilesInfo) ; $i++) { 
                        array_unshift($arrFiles,$arrFilesInfo[$i]);
                    }
                    $_SESSION['files'] = $arrFiles;
                }else{
                    $arrFiles = orderFiles($_FILES['txtImg']);
                    $_SESSION['files'] = $arrFiles;
                }
            }else{
                if(isset($_SESSION['filesInfo']) && count($_SESSION['filesInfo'])>0){
                    $arrFiles = $_SESSION['filesInfo'];
                    $arrNewFiles = orderFiles($_FILES['txtImg']);
                    for ($i=0; $i < count($arrNewFiles) ; $i++) { 
                        array_push($arrFiles,$arrNewFiles[$i]);
                    }
                    unset( $_SESSION['filesInfo']);
                    $_SESSION['files'] = $arrFiles;   
                }else if(isset($_SESSION['files']) ){
                    $arrFilesInfo = $_SESSION['files'];
                    $arrFiles = orderFiles($_FILES['txtImg']);
                    for ($i=0; $i < count($arrFilesInfo) ; $i++) { 
                        array_unshift($arrFiles,$arrFilesInfo[$i]);
                    }
                    $_SESSION['files'] = $arrFiles;
                }else{
                    $arrFiles = orderFiles($_FILES['txtImg']);
                    $_SESSION['files'] = $arrFiles;
                }
                
            }
            $arrResponse= array("msg"=>"Imágen cargada");
            echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
            die();
        }
        public function delImg(){
            $id = intval($_POST['id']);
            $arrImg = json_decode($_POST['files'],true);
            //dep($_POST);
            $arrFiles = [];
            if($id == 0){
                if(count($arrImg)>0){
                    $arrFiles = $_SESSION['files'];
                    $arrNewFiles =[];
                    $flag = false;
                    for ($i=0; $i < count($arrFiles); $i++) { 
                        for ($j=0; $j < count($arrImg) ; $j++) { 
                            if($arrImg[$j] == $arrFiles[$i]['name']){
                                array_push($arrNewFiles,$arrFiles[$i]); // push array into arrNewFils if is true
                                $flag = false;
                                break;
                            }else{
                                $flag = true;
                            }
                        }
                        if($flag){
                            deleteFile($arrFiles[$i]['rename']); // delete image if flag is true
                        }
                    }
                    $_SESSION['files'] = $arrNewFiles;
                }else{
                    $arrFiles = $_SESSION['files'];
                    deleteFile($arrFiles[0]['rename']); 
                    unset($_SESSION['files']); 
                }
            }else{
                if(count($arrImg)>0){
                    if(isset($_SESSION['filesInfo']) && count($_SESSION['filesInfo'])>0){
                        $arrFiles = $_SESSION['filesInfo'];
                        $arrNewFiles =[];
                        $flag = false;
                        for ($i=0; $i < count($arrFiles); $i++) { 
                            for ($j=0; $j < count($arrImg) ; $j++) { 
                                if($arrImg[$j] == $arrFiles[$i]['name']){
                                    array_push($arrNewFiles,$arrFiles[$i]); // push array into arrNewFils if is true
                                    $flag = false;
                                    break;
                                }else{
                                    $flag = true;
                                }
                            }
                            if($flag){
                                deleteFile($arrFiles[$i]['rename']); // delete image if flag is true
                            }
                        }
                        unset($_SESSION['filesInfo']);
                        $_SESSION['files'] = $arrNewFiles;

                    }else{
                        $arrFiles = $_SESSION['files'];
                        $arrNewFiles =[];
                        $flag = false;
                        for ($i=0; $i < count($arrFiles); $i++) { 
                            for ($j=0; $j < count($arrImg) ; $j++) { 
                                if($arrImg[$j] == $arrFiles[$i]['name']){
                                    array_push($arrNewFiles,$arrFiles[$i]); // push array into arrNewFils if is true
                                    $flag = false;
                                    break;
                                }else{
                                    $flag = true;
                                }
                            }
                            if($flag){
                                deleteFile($arrFiles[$i]['rename']); // delete image if flag is true
                            }
                        }
                    }
                    $_SESSION['files'] = $arrNewFiles;
                }else{
                    $arrFiles = [];
                    if(isset($_SESSION['files'])){
                        $arrFiles = $_SESSION['files'];
                        unset($_SESSION['files']); 
                    }else if(isset($_SESSION['filesInfo'])){
                        $arrFiles = $_SESSION['filesInfo'];
                        unset($_SESSION['filesInfo']); 
                    }
                    //dep($arrFiles);
                    //dep($arrFiles[0]['rename']);
                    $request = $this->model->selectImages($id);
                    deleteFile($arrFiles[0]['rename']);
                    if(count($request)>0){
                        $this->model->deleteImages($id);
                        /*for ($i=0; $i < count($request) ; $i++) { 
                            deleteFile($request[$i]['name']);
                        }*/
                    }
                    
                }
            }
            $arrResponse= array("msg"=>"Imágen eliminada");
            echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
            die();
        }
    }
?>