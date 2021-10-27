<?php

    //print_r($_POST);

    require "./php/PHPMailer/Exception.php";
    require "./php/PHPMailer/OAuth.php";
    require "./php/PHPMailer/PHPMailer.php";
    require "./php/PHPMailer/POP3.php";
    require "./php/PHPMailer/SMTP.php";

    use PHPMailer\PHPMailer\PHPMailer;
	use PHPMailer\PHPMailer\SMTP;
	use PHPMailer\PHPMailer\Exception;


    class Mensagem {
        private $nome = null;
        private $email = null;
        private $projeto = null;
        private $Mensagem = null;
        public $status = Array( 'codigo_status'  => null , 'descricao_status'  => '');

        public function __get($atrr){
            return $this->$atrr;
        }
        public function __set($atrr, $valor){
            $this->$atrr = $valor;
        }

        public function mensagemValida(){

            if (empty($this->nome) || empty($this->email) || empty($this->projeto) || empty($this->Mensagem) ) {
                return false;
            }
           return true;

        }
    }

    $mensagem = new Mensagem();

    $mensagem->__set('nome', $_POST['nome']);
    $mensagem->__set('email', $_POST['Email']);
    $mensagem->__set('projeto', $_POST['Projeto']);
    $mensagem->__set('Mensagem', $_POST['Mensagem']);

 


    if(!$mensagem -> mensagemValida()){
        echo "Mensagem não é valida";
        header('Location: index.html');
       
    } else

    $mail = new PHPMailer(true);
   

    try {

        //Server settings
        $mail->CharSet = 'UTF-8';
        $mail->Encoding = 'base64';                    //Enable verbose debug output
        $mail->isSMTP();                                            //Send using SMTP
        $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
        $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
        $mail->Username   = 'alexparkwithu@gmail.com';                     //SMTP username
        $mail->Password   = '';                               //SMTP password
        $mail->SMTPSecure = 'tls';            //Enable implicit TLS encryption
        $mail->Port       = 587;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`
    
        //Recipients
        $mail->setFrom('alexparkwithu@gmail.com', $mensagem->__get('email'));
        $mail->addAddress('alexandremarcelinon5@gmail.com');     //Add a recipient
       // $mail->addAddress('ellen@example.com');               //Name is optional
       // $mail->addReplyTo('info@example.com', 'Information');
        //$mail->addCC('cc@example.com');
       // $mail->addBCC('bcc@example.com');
    
        //Attachments
        //$mail->addAttachment('/var/tmp/file.tar.gz');         //Add attachments
       // $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    //Optional name
    
        //Content
        $mail->isHTML(true);                                  //Set email format to HTML
        $mail->Subject = $mensagem->__get('nome');
        $mail->Body    = $mensagem->__get('Mensagem');
        //$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';
    
        $mail->send();


        $mensagem->$status['codigo_status'] = 1;
        $mensagem->$status['descricao_status'] = 'Email enviado com sucesso';

        header('Location:index.php?envio=1');
    
    
    } catch (Exception $e) {
    
        $mensagem ->status['codigo_status'] = 2;
        $mensagem ->status['descricao_status'] = 'Não foi possivél enviar esse email. Por favor tente mais tarde!';
        echo $mail->ErrorInfo;
        header('Location:index.php?envio=2');
    }

  
    
    if(isset($_GET['envio']) && $_GET['envio'] == 1){
        echo 'here we go';
    }

?>