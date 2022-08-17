<?php 
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;
    
    require_once('Libraries/PHPMailer/Exception.php');
    require_once('Libraries/PHPMailer/PHPMailer.php');
    require_once('Libraries/PHPMailer/SMTP.php');

    function base_url(){
        return BASE_URL;
    }
    function media(){
        return BASE_URL."/Assets";
    }
    function headerPage($data=""){

        $view_header="Views/Template/header_page.php";
        require_once ($view_header);
    }
    function footerPage($data=""){

        $view_footer="Views/Template/footer_page.php";
        require_once ($view_footer);
    }
    function headerAdmin($data=""){

        $view_header="Views/Template/header_admin.php";
        require_once ($view_header);
    }
    function footerAdmin($data=""){

        $view_footer="Views/Template/footer_admin.php";
        require_once ($view_footer);
    }
    function getModal(string $nameModal, $data){
    
        $view_modal = "Views/Template/Modals/{$nameModal}.php";
        require_once $view_modal;        
    }
    function dep($data){
    
        $format  = print_r('<pre>');
        $format .= print_r($data);
        $format .= print_r('</pre>');
        return $format;
    }
    function formatNum(int $num){
        $num = MS.number_format($num,0,DEC,MIL).MD;
        return $num;
    }
    function emailNotification(){
        require_once("Models/StoreModel.php");
        $obj = new StoreModel();
        $request = $obj->selectMails();
        $total = 0;
        if(!empty($request)){
            foreach ($request as $email) {
                if($email['status']!=1)$total++;
            }
        }
        return $total;
    }
    function sessionUser(int $idpersona){
        require_once("Models/LoginModel.php");
        $objLogin = new LoginModel();
        $request = $objLogin ->sessionLogin($idpersona);
        return $request;
    }
    //Genera un token
    function token(){
        $r1 = bin2hex(random_bytes(10));
        $r2 = bin2hex(random_bytes(10));
        $r3 = bin2hex(random_bytes(10));
        $r4 = bin2hex(random_bytes(10));
        $token = $r1.'-'.$r2.'-'.$r3.'-'.$r4;
        return $token;
    }
    function code(){
        $code = bin2hex(random_bytes(3));;
        return $code;
    }
    function statusCoupon(){
        require_once("Models/CustomerTrait.php");
        class CouponSt{
            use CustomerTrait;
            public function getStatusCoupon(){
                return $this->statusCouponSuscriberT();
            }

        }
        $s = new CouponSt();
        $arrStatus = array();
        if(!empty($s->getStatusCoupon())){
            $arrStatus = array("code"=>$s->getStatusCoupon()['code'],"discount"=>$s->getStatusCoupon()['discount']);
        }
        return $arrStatus;
    }
    //Producción
    /*function sendEmail($data,$template){
        $mail = new PHPMailer(true);
        $mail->CharSet = 'UTF-8';

        $asunto = $data['asunto'];
        $emailDestino = $data['email_usuario'];
        $nombre="";
        if(!empty($data['nombreUsuario'])){
            $nombre= $data['nombreUsuario'];
        }
        $empresa = NOMBRE_REMITENTE;
        $remitente = $data['email_remitente'];
        ob_start();
        require_once("Views/Template/Email/".$template.".php");
        $mensaje = ob_get_clean();

        //Server settings
        $mail->SMTPDebug = 0;                      //Enable verbose debug output
        $mail->isSMTP();                                            //Send using SMTP
        $mail->Host       = 'smtp.hostinger.com';                     //Set the SMTP server to send through
        $mail->SMTPAuth   = true; 
        $mail->Username   = $remitente;
        $mail->Password   = REMITENTE_PASSWORD;
                                //Enable SMTP authentication
                             //SMTP username
                                       //SMTP password
        $mail->SMTPSecure = 'ssl';            //Enable implicit TLS encryption
        $mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`
        
        //Recipients
        $mail->setFrom($remitente,$empresa);
        $mail->addAddress($emailDestino, $nombre);     //Add a recipient
        if(!empty($data['email_copia'])){
            $mail->addBCC($data['email_copia']);
            $mail->addBCC($remitente);
        }
        

        //Content
        $mail->isHTML(true);                                  //Set email format to HTML
        $mail->Subject = $asunto;
        $mail->Body    = $mensaje;

        return $mail->send();
    }*/
    //Pruebas
    function sendEmail($data,$template){
        $mail = new PHPMailer(true);
        $mail->CharSet = 'UTF-8';

        $asunto = $data['asunto'];
        $emailDestino = $data['email_usuario'];
        $nombre="";
        if(!empty($data['nombreUsuario'])){
            $nombre= $data['nombreUsuario'];
        }
        $empresa = NOMBRE_REMITENTE;
        $remitente = $data['email_remitente'];
        ob_start();
        require_once("Views/Template/Email/".$template.".php");
        $mensaje = ob_get_clean();

        //Server settings
        $mail->SMTPDebug = 0;                      //Enable verbose debug output
        $mail->isSMTP();                                            //Send using SMTP
        $mail->Host       = 'smtp.office365.com';                     //Set the SMTP server to send through
        $mail->SMTPAuth   = true; 
        $mail->Username   = $remitente;
        $mail->Password   = REMITENTE_PASSWORD;
                                //Enable SMTP authentication
                             //SMTP username
                                       //SMTP password
        $mail->SMTPSecure = 'tls';            //Enable implicit TLS encryption
        $mail->Port       = 587;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`
        
        //Recipients
        $mail->setFrom($remitente,$empresa);
        $mail->addAddress($emailDestino, $nombre);     //Add a recipient
        if(!empty($data['email_copia'])){
            $mail->addBCC($data['email_copia']);
            $mail->addBCC($remitente);
        }
        

        //Content
        $mail->isHTML(true);                                  //Set email format to HTML
        $mail->Subject = $asunto;
        $mail->Body    = $mensaje;

        return $mail->send();
    }
    function orderFiles($files){
        $arrFiles = [];
        for ($i=0; $i < count($files['name']) ; $i++) { 
            $data = array("tmp_name"=>$files['tmp_name'][$i]);
            $rename ='product_'.bin2hex(random_bytes(6)).'.png';
            $arrFile = array(
                "name"=>$files['name'][$i],
                "rename"=>$rename,
            );
            uploadImage($data, $rename);
            array_push($arrFiles,$arrFile);
        }
        return $arrFiles;
    }
    function getTokenPaypal(){
        $payLogin = curl_init(URLPAYPAL."/v1/oauth2/token");
        curl_setopt($payLogin, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($payLogin, CURLOPT_RETURNTRANSFER,TRUE);
        curl_setopt($payLogin, CURLOPT_USERPWD, CLIENT_ID.":".SECRET);
        curl_setopt($payLogin, CURLOPT_POSTFIELDS, "grant_type=client_credentials");
        $result = curl_exec($payLogin);
        $err = curl_error($payLogin);
        curl_close($payLogin);
        if($err){
            $request = "CURL Error #:" . $err;
        }else{
            $objData = json_decode($result);
            $request =  $objData->access_token;
        }
        return $request;
    }

    function curlConnectionGet(string $ruta, string $contentType = null, string $token){
        $content_type = $contentType != null ? $contentType : "application/x-www-form-urlencoded";
        if($token != null){
            $arrHeader = array('Content-Type:'.$content_type,
                            'Authorization: Bearer '.$token);
        }else{
            $arrHeader = array('Content-Type:'.$content_type);
        }
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $ruta);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $arrHeader);
        $result = curl_exec($ch);
        $err = curl_error($ch);
        curl_close($ch);
        if($err){
            $request = "CURL Error #:" . $err;
        }else{
            $request = json_decode($result);
        }
        return $request;
    }
    function curlConnectionPost(string $ruta, string $contentType = null, string $token){
        $content_type = $contentType != null ? $contentType : "application/x-www-form-urlencoded";
        if($token != null){
            $arrHeader = array('Content-Type:'.$content_type,
                            'Authorization: Bearer '.$token);
        }else{
            $arrHeader = array('Content-Type:'.$content_type);
        }
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $ruta);
        curl_setopt($ch, CURLOPT_POST, TRUE);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $arrHeader);
        $result = curl_exec($ch);
        $err = curl_error($ch);
        curl_close($ch);
        if($err){
            $request = "CURL Error #:" . $err;
        }else{
            $request = json_decode($result);
        }
        return $request;
    }
    function getFile(string $url, $data){
        ob_start();
        require_once("Views/{$url}.php");
        $file = ob_get_clean();
        return $file;        
    }
    function getPermits($idmodulo){
        //dep($idmodulo);exit;
        require_once("Models/RoleModel.php");
        $roleModel = new RoleModel();
        $idrol = intval($_SESSION['userData']['roleid']);
        $arrPermisos = $roleModel->permitsModule($idrol);
        $permisos = '';
        $permisosMod ='';
        if(count($arrPermisos)>0){
            $permisos = $arrPermisos;
            $permisosMod = isset($arrPermisos[$idmodulo]) ? $arrPermisos[$idmodulo] : "";
        }
        $_SESSION['permit'] = $permisos;
        $_SESSION['permitsModule'] = $permisosMod;
    }

    function uploadImage(array $data, string $name){
        $url_temp = $data['tmp_name'];
        $destino = 'Assets/images/uploads/'.$name;
        $move = move_uploaded_file($url_temp, $destino);
        return $move;
    }

    function deleteFile(string $name){
        unlink('Assets/images/uploads/'.$name);
    }
    
    function months(){
        $months = array("January", 
                      "February", 
                      "March", 
                      "April", 
                      "May", 
                      "June", 
                      "July", 
                      "August", 
                      "September", 
                      "October", 
                      "November", 
                      "Dicember");
        return $months;
    }
    //Elimina exceso de espacios entre palabras
    function strClean($strCadena){
        $string = preg_replace(['/\s+/','/^\s|\s$/'],[' ',''], $strCadena);
        $string = trim($string); //Elimina espacios en blanco al inicio y al final
        $string = stripslashes($string); // Elimina las \ invertidas
        $string = str_ireplace("<script>","",$string);
        $string = str_ireplace("</script>","",$string);
        $string = str_ireplace("<script src>","",$string);
        $string = str_ireplace("<script type=>","",$string);
        $string = str_ireplace("SELECT * FROM","",$string);
        $string = str_ireplace("DELETE FROM","",$string);
        $string = str_ireplace("INSERT INTO","",$string);
        $string = str_ireplace("SELECT COUNT(*) FROM","",$string);
        $string = str_ireplace("DROP TABLE","",$string);
        $string = str_ireplace("OR '1'='1","",$string);
        $string = str_ireplace('OR "1"="1"',"",$string);
        $string = str_ireplace('OR ´1´=´1´',"",$string);
        $string = str_ireplace("is NULL; --","",$string);
        $string = str_ireplace("is NULL; --","",$string);
        $string = str_ireplace("LIKE '","",$string);
        $string = str_ireplace('LIKE "',"",$string);
        $string = str_ireplace("LIKE ´","",$string);
        $string = str_ireplace("OR 'a'='a","",$string);
        $string = str_ireplace('OR "a"="a',"",$string);
        $string = str_ireplace("OR ´a´=´a","",$string);
        $string = str_ireplace("OR ´a´=´a","",$string);
        $string = str_ireplace("--","",$string);
        $string = str_ireplace("^","",$string);
        $string = str_ireplace("[","",$string);
        $string = str_ireplace("]","",$string);
        $string = str_ireplace("==","",$string);
        return $string;
    }

    function clear_cadena(string $cadena){
        //Reemplazamos la A y a
        $cadena = str_replace(
        array('Á', 'À', 'Â', 'Ä', 'á', 'à', 'ä', 'â', 'ª'),
        array('A', 'A', 'A', 'A', 'a', 'a', 'a', 'a', 'a'),
        $cadena
        );
 
        //Reemplazamos la E y e
        $cadena = str_replace(
        array('É', 'È', 'Ê', 'Ë', 'é', 'è', 'ë', 'ê'),
        array('E', 'E', 'E', 'E', 'e', 'e', 'e', 'e'),
        $cadena );
 
        //Reemplazamos la I y i
        $cadena = str_replace(
        array('Í', 'Ì', 'Ï', 'Î', 'í', 'ì', 'ï', 'î'),
        array('I', 'I', 'I', 'I', 'i', 'i', 'i', 'i'),
        $cadena );
 
        //Reemplazamos la O y o
        $cadena = str_replace(
        array('Ó', 'Ò', 'Ö', 'Ô', 'ó', 'ò', 'ö', 'ô'),
        array('O', 'O', 'O', 'O', 'o', 'o', 'o', 'o'),
        $cadena );
 
        //Reemplazamos la U y u
        $cadena = str_replace(
        array('Ú', 'Ù', 'Û', 'Ü', 'ú', 'ù', 'ü', 'û'),
        array('U', 'U', 'U', 'U', 'u', 'u', 'u', 'u'),
        $cadena );
 
        //Reemplazamos la N, n, C y c
        $cadena = str_replace(
        array('Ñ', 'ñ', 'Ç', 'ç',',','.',';',':'),
        array('N', 'n', 'C', 'c','','','',''),
        $cadena
        );
        return $cadena;
    }
    //Genera una contraseña de 10 caracteres
	function passGenerator($length = 10){
        $pass = "";
        $longitudPass=$length;
        $cadena = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz1234567890";
        $longitudCadena=strlen($cadena);

        for($i=1; $i<=$longitudPass; $i++)
        {
            $pos = rand(0,$longitudCadena-1);
            $pass .= substr($cadena,$pos,1);
        }
        return $pass;
    }

    function getCatFooter(){
        require_once("Models/CategoriasModel.php");
        $categoria = new CategoriasModel();
        $request = $categoria->getCategoriasFooter();
        return $request;
    }

?>