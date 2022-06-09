<?php
    class Category extends Controllers{

        public function __construct(){
            session_start();
            if(empty($_SESSION['login'])){
                header("location: ".base_url()."/logout");
                die();
            }
            parent::__construct();
            getPermits(4);
        }
        
        public function category(){
            if($_SESSION['permitsModule']['r']){
                $data['page_tag'] = "Category";
                $data['page_title'] = "Categorias";
                $data['page_name'] = "category";
                $this->views->getView($this,"category",$data);
            }else{
                header("location: ".base_url()."/logout");
                die();
            }
        }
        public function subcategory(){
            if($_SESSION['permitsModule']['r']){
                $data['page_tag'] = "SubCategory";
                $data['page_title'] = "SubCategorias";
                $data['page_name'] = "subcategory";
                $this->views->getView($this,"subcategory",$data);
            }else{
                header("location: ".base_url()."/logout");
                die();
            }
        }
        /*************************Category methods*******************************/
        public function getCategories(){
            if($_SESSION['permitsModule']['r']){
                $html="";
                $request = $this->model->selectCategories();
                if(count($request)>0){
                    for ($i=0; $i < count($request); $i++) { 

                        $status="";
                        $btnEdit="";
                        $btnDelete="";
                        
                        if($_SESSION['permitsModule']['u']){
                            $btnEdit = '<button class="btn btn-success m-1" type="button" title="Editar" data-id="'.$request[$i]['idcategory'].'" name="btnEdit"><i class="fas fa-pencil-alt"></i></button>';
                        }
                        if($_SESSION['permitsModule']['d']){
                            $btnDelete = '<button class="btn btn-danger m-1" type="button" title="Eliminar" data-id="'.$request[$i]['idcategory'].'" name="btnDelete"><i class="fas fa-trash-alt"></i></button>';
                        }
                        if($request[$i]['status']==1){
                            $status='<span class="badge me-1 bg-success">Activo</span>';
                        }else{
                            $status='<span class="badge me-1 bg-danger">Inactivo</span>';
                        }
                        $html.='
                            <tr class="item" data-name="'.$request[$i]['name'].'">
                                <td><strong>Nombre: </strong>'.$request[$i]['name'].'</td>
                                <td><strong>Estado: </strong>'.$status.'</td>
                                <td class="item-btn">'.$btnEdit.$btnDelete.'</td>
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
        public function getCategory(){
            if($_SESSION['permitsModule']['r']){

                if($_POST){
                    if(empty($_POST)){
                        $arrResponse = array("status"=>false,"msg"=>"Error de datos");
                    }else{
                        $idCategory = intval($_POST['idCategory']);
                        $request = $this->model->selectCategory($idCategory);
                        if(!empty($request)){
                            $arrResponse = array("status"=>true,"data"=>$request);
                        }else{
                            $arrResponse = array("status"=>false,"msg"=>"Ha ocurrido un error, inténtelo de nuevo."); 
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
        public function setCategory(){
            if($_SESSION['permitsModule']['r']){
                if($_POST){
                    if(empty($_POST['txtName']) || empty($_POST['statusList'])){
                        $arrResponse = array("status" => false, "msg" => 'Datos incorrectos.');
                    }else{ 
                        $idCategory = intval($_POST['idCategory']);
                        $strName = ucwords(strClean($_POST['txtName']));
                        $intStatus = intval(strClean($_POST['statusList']));
                        $route = str_replace(" ","-",$strName);
                        $route = str_replace("?","",$route);
                        $route = strtolower(str_replace("¿","",$route));
                        
                        if($idCategory == 0){
                            if($_SESSION['permitsModule']['w']){

                                $option = 1;
                                $request= $this->model->insertCategory(
                                    $strName, 
                                    $intStatus, 
                                    $route
                                );
                            }
                        }else{
                            if($_SESSION['permitsModule']['u']){
                                $option = 2;
                                $request = $this->model->updateCategory(
                                    $idCategory, 
                                    $strName, 
                                    $intStatus, 
                                    $route
                                );
                            }
                        }
                        if($request > 0 ){
                            if($option == 1){
                                $arrResponse = array('status' => true, 'msg' => 'Datos guardados.');
                            }else{
                                $arrResponse = array('status' => true, 'msg' => 'Datos Actualizados correctamente.');
                            }
                        }else if($request == 'exist'){
                            $arrResponse = array('status' => false, 'msg' => '¡Atención! la categoria ya existe, ingrese otro.');		
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
        public function delCategory(){
            if($_SESSION['permitsModule']['d']){

                if($_POST){
                    if(empty($_POST['idCategory'])){
                        $arrResponse=array("status"=>false,"msg"=>"Error de datos");
                    }else{
                        $id = intval($_POST['idCategory']);
                        $request = $this->model->deleteCategory($id);
                        if($request=="ok"){
                            $arrResponse = array("status"=>true,"msg"=>"Se ha eliminado");
                        }else if($request =="exist"){
                            $arrResponse = array("status"=>false,"msg"=>"La categoria tiene asignada al menos una subcategoria, no se puede eliminar.");
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
        /*************************SubCategory methods*******************************/
        public function getSubCategories(){
            if($_SESSION['permitsModule']['r']){
                $html="";
                $request = $this->model->selectSubCategories();
                if(count($request)>0){
                    for ($i=0; $i < count($request); $i++) { 

                        $status="";
                        $btnEdit="";
                        $btnDelete="";
                        
                        if($_SESSION['permitsModule']['u']){
                            $btnEdit = '<button class="btn btn-success m-1" type="button" title="Editar" data-id="'.$request[$i]['idsubcategory'].'" name="btnEdit"><i class="fas fa-pencil-alt"></i></button>';
                        }
                        if($_SESSION['permitsModule']['d']){
                            $btnDelete = '<button class="btn btn-danger m-1" type="button" title="Eliminar" data-id="'.$request[$i]['idsubcategory'].'" name="btnDelete"><i class="fas fa-trash-alt"></i></button>';
                        }
                        if($request[$i]['status']==1){
                            $status='<span class="badge me-1 bg-success">Activo</span>';
                        }else{
                            $status='<span class="badge me-1 bg-danger">Inactivo</span>';
                        }
                        $html.='
                            <tr class="item" data-name="'.$request[$i]['name'].'">
                                <td><strong>Nombre: </strong>'.$request[$i]['name'].'</td>
                                <td><strong>Categoría: </strong>'.$request[$i]['category'].'</td>
                                <td><strong>Estado: </strong>'.$status.'</td>
                                <td class="item-btn">'.$btnEdit.$btnDelete.'</td>
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
        public function getSubCategory(){
            if($_SESSION['permitsModule']['r']){

                if($_POST){
                    if(empty($_POST)){
                        $arrResponse = array("status"=>false,"msg"=>"Error de datos");
                    }else{
                        $idCategory = intval($_POST['idSubCategory']);
                        $request = $this->model->selectSubCategory($idCategory);
                        if(!empty($request)){
                            $arrResponse = array("status"=>true,"data"=>$request);
                        }else{
                            $arrResponse = array("status"=>false,"msg"=>"Ha ocurrido un error, inténtelo de nuevo."); 
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
        public function setSubCategory(){
            if($_SESSION['permitsModule']['r']){
                if($_POST){
                    if(empty($_POST['txtName']) ||empty($_POST['categoryList'])|| empty($_POST['statusList'])){
                        $arrResponse = array("status" => false, "msg" => 'Datos incorrectos.');
                    }else{ 
                        $idSubCategory = intval($_POST['idSubCategory']);
                        $strName = ucwords(strClean($_POST['txtName']));
                        $idCategory = intval(strClean($_POST['categoryList']));
                        $intStatus = intval(strClean($_POST['statusList']));
                        $route = str_replace(" ","-",$strName);
                        $route = str_replace("?","",$route);
                        $route = strtolower(str_replace("¿","",$route));
                        
                        if($idSubCategory == 0){
                            if($_SESSION['permitsModule']['w']){

                                $option = 1;
                                $request= $this->model->insertSubCategory(
                                    $idCategory,
                                    $strName, 
                                    $intStatus, 
                                    $route
                                );
                            }
                        }else{
                            if($_SESSION['permitsModule']['u']){
                                $option = 2;
                                $request = $this->model->updateSubCategory(
                                    $idSubCategory, 
                                    $idCategory,
                                    $strName, 
                                    $intStatus, 
                                    $route
                                );
                            }
                        }
                        if($request > 0 ){
                            if($option == 1){
                                $arrResponse = array('status' => true, 'msg' => 'Datos guardados.');
                            }else{
                                $arrResponse = array('status' => true, 'msg' => 'Datos Actualizados correctamente.');
                            }
                        }else if($request == 'exist'){
                            $arrResponse = array('status' => false, 'msg' => '¡Atención! la subcategoria ya existe, ingrese otro.');		
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
        public function delSubCategory(){
            if($_SESSION['permitsModule']['d']){

                if($_POST){
                    if(empty($_POST['idSubCategory'])){
                        $arrResponse=array("status"=>false,"msg"=>"Error de datos");
                    }else{
                        $id = intval($_POST['idSubCategory']);
                        $request = $this->model->deleteSubCategory($id);
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
    }
?>