<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class CrudDashboard extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->model("Dashboard");
        $this->load->library("session");
        $idUsuario=$this->session->userdata("iduser");
        if(empty($idUsuario))
        {
            die($this->load->view("viewSesionCaducada", null, true));
        }

    }

    function index($fechaInicial="", $fechaFinal="", $empresaInterna="")
    {
        $data['empresasInternas']=$this->Dashboard->getEmpresasInternas();
        $data['status']=$this->Dashboard->getStatus();
        $data['fechaInicial']=$fechaInicial;
        $data['fechaFinal']=$fechaFinal;
        $data['idEmpresaInterna']=$empresaInterna;

        $data = $this->security->xss_clean($data);
        print $this->load->view("viewDashboard", $data, TRUE);

    }

    //GENERA LA GRAFICA DE LOS CONTRATOS - //Ya toma en cuenta que no esten finalizados
    function getGraficasContratos($fechaInicial="1950-01-01", $fechaFinal="2032-12-31", $empresaInterna="")
    {


        $fechaInicial=urldecode($fechaInicial);
        $fechaFinal=urldecode($fechaFinal);
        $fechas=$this->Dashboard->getFechas($fechaInicial, $fechaFinal, $empresaInterna);
        $status=$this->Dashboard->getStatus();
        $arregloFinal=array();
        $contador=0;
        foreach ($status as $estado)
        {
            $array=array();
            $idStatus=$estado['idStatusContrato'];
            $labelStatus=$estado['etiqueta'];
            $color=$estado['clase'];
            for($i=0; $i<sizeof($fechas); $i++)
            {
                $array[$i]=intval($this->Dashboard->getInformacionStatus($idStatus, $fechas[$i]['fecha'], $empresaInterna));
            }

            $arregloFinal[$contador++]=array($labelStatus, $array, $color);
        }

        $arrayFechas=array();

        foreach ($fechas as $fecha)
        {

            array_push($arrayFechas, $fecha['fecha']);

        }

        echo json_encode(array($arrayFechas, $arregloFinal));



    }

    //GENERA LA GRAFICA DE LAS FIANZAS
        //Ya toma en cuenta que no esten finalizados
    function getGraficasFianzas($fechaInicial="1950-01-01", $fechaFinal="2032-12-31", $empresaInterna="")
    {


        $fechaInicial=urldecode($fechaInicial);
        $fechaFinal=urldecode($fechaFinal);
        $fianzas=$this->Dashboard->getFianzas($fechaInicial, $fechaFinal, $empresaInterna);
        $fechaHoy=date("Y-m-d");
        $vigentePagado=0;
        $vigenteNoPagado=0;
        $expiradoPagado=0;
        $expiradoNoPagado=0;
        foreach ($fianzas as $fianza)
        {
            //vigente
            if(strtotime($fechaHoy)>strtotime($fianza['vigencia']))
            {
                if($fianza['status']==1)
                    $expiradoPagado++;
                else
                    $expiradoNoPagado++;
            }
            else
            {
                if($fianza['status']==1)
                    $vigentePagado++;
                else
                    $vigenteNoPagado++;
            }
        }

        echo json_encode(array($vigentePagado, $vigenteNoPagado,$expiradoPagado,$expiradoNoPagado));

    }
    //Ya tomaen cuenta solo las que no estan finalziadas
    function verStatusContratos($fechaInicial, $fechaFinal, $idEmpresaInterna="")
    {


        $data['fechaInicial']=$fechaInicial;
        $data['fechaFinal']=$fechaFinal;
        $data['idEmpresaInterna']=$idEmpresaInterna;
        $data['tarjetas']=$this->Dashboard->getTarjetasContratos($fechaInicial, $fechaFinal, $idEmpresaInterna);
        $data = $this->security->xss_clean($data);
        print $this->load->view("viewDashboardStatusContratos", $data, TRUE);
    }
    //Ya tomaen cuenta solo las que no estan finalziadas
    function verStatusFianzas($fechaInicial, $fechaFinal, $idEmpresaInterna="")
    {


        $data['fechaInicial']=$fechaInicial;
        $data['fechaFinal']=$fechaFinal;
        $data['idEmpresaInterna']=$idEmpresaInterna;
        $fechaInicial=urldecode($fechaInicial);
        $fechaFinal=urldecode($fechaFinal);
        $fianzas=$this->Dashboard->getFianzas($fechaInicial, $fechaFinal, $idEmpresaInterna);
        $fechaHoy=date("Y-m-d");
        $vigentePagado=0;
        $vigenteNoPagado=0;
        $expiradoPagado=0;
        $expiradoNoPagado=0;
        foreach ($fianzas as $fianza)
        {
            //vigente
            if(strtotime($fechaHoy)>strtotime($fianza['vigencia']))
            {
                if($fianza['status']==1)
                    $expiradoPagado++;
                else
                    $expiradoNoPagado++;
            }
            else
            {
                if($fianza['status']==1)
                    $vigentePagado++;
                else
                    $vigenteNoPagado++;
            }
        }

        $data['tarjetas']=array($vigentePagado, $vigenteNoPagado,$expiradoPagado,$expiradoNoPagado);
        $data = $this->security->xss_clean($data);
        print $this->load->view("viewDashboardStatusFianzas", $data, TRUE);

    }
    //Creo que ya toma ne cuenta solo las finalizadas - Noexiste el metodo getTablaContratos
    function visualizarTablaContrato($fechaInicial, $fechaFinal, $status)
    {



        $data['fechaInicial']=$fechaInicial;

        $data['fechaFinal']=$fechaFinal;

        $data['tarjetas']=$this->Dashboard->getTablaContratos($fechaInicial, $fechaFinal, $status);
        $data = $this->security->xss_clean($data);
        print $this->load->view("viewDashboardStatusContratos", $data, TRUE);

    }
    //Ya toma en cuenta las finalizadas
    function visualizarTablaStatusContrato($fechaInicial, $fechaFinal,$idStatus, $idEmpresaInterna="")
    {


        $fechaInicial=urldecode($fechaInicial);

        $fechaFinal=urldecode($fechaFinal);


        $this->load->model("Proyectos");

        $data['solicitudes'] = $this->Proyectos->getSolcitud(null, $fechaInicial, $fechaFinal, $idStatus, $idEmpresaInterna);

        $data['getPr'] = $this->Proyectos->getPr();

        $data['proyectoIndividual']=0;

        $data['posiblesEstados']=$this->Proyectos->getAllStatus();
        $this->load->model("Permisos");
        //permisos de contratos de proyecto
        $data['permisos']=$this->Permisos->getPermisosUsuarioModulo($this->session->userdata('idTipo'), 7);
        //permisos de fianzas
        $data['permisosFianzas']=$this->Permisos->getPermisosUsuarioModulo($this->session->userdata('idTipo'), 8);
        //permisos de versiones
        $data['permisosVersiones']=$this->Permisos->getPermisosUsuarioModulo($this->session->userdata('idTipo'), 10);
        //permisos de versiones
        $data['permisosStatusContrato']=$this->Permisos->getPermisosUsuarioModulo($this->session->userdata('idTipo'), 5);

        $data['idProyecto']=null;
        $data['idEmpresaInterna']=$idEmpresaInterna;
        $data['fechaInicial']=$fechaInicial;
        $data['fechaFinal']=$fechaFinal;
        $data['statusSeleccionado']=$idStatus;
        $data = $this->security->xss_clean($data);
        print $this->load->view('viewtodosolicitudes', $data, TRUE);

    }
    //No estoy sseguro si ya toma las finalizadas
    function visualizarTablaStatusFianza($fechaInicial, $fechaFinal, $idVigencia, $idPago, $idEmpresaInterna=null)
    {


        $this->load->model("Proyectos");
        $data['fechaInicial']=$fechaInicial;
        $data['fechaFinal']=$fechaFinal;
        $data['idVigencia']=$idVigencia;
        $data['idPago']=$idPago;
        $data['idEmpresaInterna']=$idEmpresaInterna;
        //variable que sirve para especificar que no se requiere un idContratoProyecto
        $data['sinContratoProyecto']="0";
        $idUsuario=$this->session->userdata("iduser");


        $data['idProyecto'] = $this->Proyectos->getIdProyecto();

        $data['idProyecto'] = $data['idProyecto']['idProyecto'];

        $data['fianzasContratos'] = $this->Proyectos->getFianzasContratos(0, $fechaInicial, $fechaFinal, $idPago, $idVigencia);

        $data['fianzaIndividual']=0;
        $this->load->model("Permisos");
        $data['permisos']=$this->Permisos->getPermisosUsuarioModulo($this->session->userdata('idTipo'), 8);
        $data['permisosDocumentosFianza']=$this->Permisos->getPermisosUsuarioModulo($this->session->userdata('idTipo'), 9);
        $data = $this->security->xss_clean($data);
        print $this->load->view('viewTodoFianzasContrato', $data, TRUE);

    }
    function verTarjetasContratosPorVencer($diasTolerancia=36500, $fechaInicial="1950-01-01", $fechaFinal="2032-12-31", $idEmpresaInterna="")
    {


        $data['diasTolerancia']=$diasTolerancia;
        $data['fechaInicial']=$fechaInicial;
        $data['fechaFinal']=$fechaFinal;
        $data['idEmpresaInterna']=$idEmpresaInterna;
        $data['tarjetas']=$this->Dashboard->getTarjetasContratosVencimiento($fechaInicial, $fechaFinal, $idEmpresaInterna, $diasTolerancia);
        $data = $this->security->xss_clean($data);
        print $this->load->view("viewDashboardStatusContratosVencimiento", $data, TRUE);
    }
    function visualizarTablaStatusContratoVencimiento($diasTolerancia, $idStatus)
    {


        $data['diasTolerancia']=$diasTolerancia;
        $data['verBtnEliminar']=1;
        $this->load->model("Proyectos");

        $data['solicitudes'] = $this->Dashboard->getContratosVencimiento($diasTolerancia, $idStatus);
        $data['getPr'] = $this->Proyectos->getPr();
        $data['proyectoIndividual']=0;
        $data['posiblesEstados']=$this->Proyectos->getAllStatus();
        $this->load->model("Permisos");
        //permisos de contratos de proyecto
        $data['permisos']=$this->Permisos->getPermisosUsuarioModulo($this->session->userdata('idTipo'), 7);
        //permisos de fianzas
        $data['permisosFianzas']=$this->Permisos->getPermisosUsuarioModulo($this->session->userdata('idTipo'), 8);
        //permisos de versiones
        $data['permisosVersiones']=$this->Permisos->getPermisosUsuarioModulo($this->session->userdata('idTipo'), 10);
        //permisos de versiones
        $data['permisosStatusContrato']=$this->Permisos->getPermisosUsuarioModulo($this->session->userdata('idTipo'), 5);

        $data['idProyecto']=null;
        $data['statusSeleccionado']=$idStatus;
        $data = $this->security->xss_clean($data);
        print $this->load->view('viewtodosolicitudesVencimiento', $data, TRUE);

    }
    function verTarjetasFianzasPorVencer($diasTolerancia, $fechaInicial="1950-01-01", $fechaFinal="2032-12-31", $idEmpresaInterna="")
    {


        $data['diasTolerancia']=$diasTolerancia;
        $data['fechaInicial']=$fechaInicial;
        $data['fechaFinal']=$fechaFinal;
        $data['idEmpresaInterna']=$idEmpresaInterna;
        $fechaInicial=urldecode($fechaInicial);
        $fechaFinal=urldecode($fechaFinal);
        $fianzas=$this->Dashboard->getFianzasVencimiento($diasTolerancia, $fechaInicial, $fechaFinal, $idEmpresaInterna);
        $fechaHoy=date("Y-m-d");
        $vigentePagado=0;
        $vigenteNoPagado=0;
        $expiradoPagado=0;
        $expiradoNoPagado=0;
        foreach ($fianzas as $fianza)
        {
            //vigente
            if(strtotime($fechaHoy)>strtotime($fianza['vigencia']))
            {
                if($fianza['status']==1)
                    $expiradoPagado++;
                else
                    $expiradoNoPagado++;
            }
            else
            {
                if($fianza['status']==1)
                    $vigentePagado++;
                else
                    $vigenteNoPagado++;
            }
        }

        $data['tarjetas']=array($vigentePagado, $vigenteNoPagado,$expiradoPagado,$expiradoNoPagado);
        $data = $this->security->xss_clean($data);

        print $this->load->view("viewDashboardStatusFianzasVencimiento", $data, TRUE);

    }
    function visualizarTablaStatusFianzaVencimiento($diasTolerancia, $fechaInicial, $fechaFinal, $idVigencia, $idPago, $idEmpresaInterna=null)
    {

        $this->load->model("Proyectos");
        $data['diasTolerancia']=$diasTolerancia;
        $data['fechaInicial']=$fechaInicial;
        $data['fechaFinal']=$fechaFinal;
        $data['idVigencia']=$idVigencia;
        $data['idPago']=$idPago;
        $data['idEmpresaInterna']=$idEmpresaInterna;
        $data['general']=false;
        $data['verBtnEliminar']=true;
        //variable que sirve para especificar que no se requiere un idContratoProyecto
        $data['sinContratoProyecto']="0";
        $data['idProyecto'] = $this->Proyectos->getIdProyecto();
        $data['idProyecto'] = $data['idProyecto']['idProyecto'];


        $data['fianzasContratos'] = $this->Dashboard->getFianzasContratosVencimiento($fechaInicial,$fechaFinal, $idEmpresaInterna, $idPago, $diasTolerancia, $idVigencia);

        $data['fianzaIndividual']=0;
        $this->load->model("Permisos");
        $data['permisos']=$this->Permisos->getPermisosUsuarioModulo($this->session->userdata('idTipo'), 8);
        $data['permisosDocumentosFianza']=$this->Permisos->getPermisosUsuarioModulo($this->session->userdata('idTipo'), 9);
        $data = $this->security->xss_clean($data);
        print $this->load->view('viewTodoFianzasContratoVencimiento', $data, TRUE);

    }



}