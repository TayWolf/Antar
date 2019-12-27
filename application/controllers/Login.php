<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Login extends CI_Controller
{
    public function index()
    {
        $this->session->sess_destroy();
        $this->load->helper('captcha');

        if(isset($_POST['password'])) //si la variable contiene algún valor
        {

            $this->form_validation->set_rules('username', 'Usuario', 'trim|required|min_length[2]|max_length[30]');
            $this->form_validation->set_rules('password', 'Password', 'trim|required|min_length[2]|max_length[64]');
            if ($this->form_validation->run() == FALSE)
            {
                $this->session->set_flashdata('mensaje','true');
                echo "<script>
				  var r =confirm('El usuario y/o contraseña no son validos.');
                  if (r == true){
                    location.href='".base_url()."';
                     
                  }else{
                    location.href='".base_url()."';}</script>";
                return;
            }
            $googleCaptcha=$this->input->post("g-recaptcha-response");
            if(!empty($googleCaptcha))
            {
                $arrContextOptions=array(
                    "ssl"=>array(
                        "verify_peer"=>false,
                        "verify_peer_name"=>false,
                    ),
                );
                $secretKey = '6Lf5eaoUAAAAALuFKfFTszgSUI1aF0IYb-4X411j';
                $verifyResponse = file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret='.$secretKey.'&response='.$googleCaptcha.'&remoteip='.$this->input->ip_address(), false, stream_context_create($arrContextOptions));
                //$verifyResponse = file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret='.$secretKey.'&response='.$googleCaptcha.'&remoteip='.$this->input->ip_address());
                $responseData = json_decode($verifyResponse, true);
                if($responseData['success'])
                {
                    $this->load->model("usuarios"); //cargamos el controlador de User
                    $result=$this->usuarios->login($this->input->post('username'),$this->input->post('password'));
                    if($result)//si es verdadero el dato ver el modelo User
                    {
                        $name= $result->nickName;
                        $tipo=$result->idTipo;
                        $iduser=$result->idUser;
                        $nombreUser=$result->nombreUser;
                        $area=$result->idArea;
                        // $foto=$result->fotoUser;
                        $array = array(
                            'iduser' => $iduser, //generamos la variable idUsuario
                            'nickName' => $name, //Generamos la variable de usuario
                            'idTipo' => $tipo, //Generamos la variable de tipo de usuario
                            'nombreUser' => $nombreUser,
                            'IP' => $this->input->ip_address()
                        );
                        session_start();
                        $this->session->set_userdata($array);


                        //$idSesionCreada=$this->usuarios->getSessionID();
                        //$array['ci_session'] =$idSesionCreada;
                        //$this->usuarios->insertSession($array);
                        redirect('tablero');

                    }
                    else
                    {
                        $this->session->set_flashdata('mensaje','true');
                        echo "<script>
							var r =confirm('El usuario o Contraseña es incorrecta.');
							if (r == true){
								location.href='".base_url()."';
				 
							}else{
								location.href='".base_url()."';}</script>";
                    }
                }
                else
                {
                    echo "<script>
                        var r = confirm('Por favor, selecciona la casilla \"No soy un Robot\"');
                          if (r == true){
                            location.href='".base_url()."';
                          }else{
                            location.href='".base_url()."';}</script>";
                }

            }
            else
            {
                echo "<script>
                        var r = confirm('Por favor, selecciona la casilla \"No soy un Robot\"');
                          if (r == true){
                            location.href='".base_url()."';
                          }else{
                            location.href='".base_url()."';}</script>";
            }

        }
        else
        {
            $this->load->view('login_view');
        }
    }
}