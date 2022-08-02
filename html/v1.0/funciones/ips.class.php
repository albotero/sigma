<?php
class ips {
    public $nombre;
    public $nit;
    public $telefono;
    public $logo;
    public $firma;
    
    private $ruta_img = "/img/ips";

    function __construct() {
        session_start();
        $this->logo = "{$this->ruta_img}/{$_SESSION['ips']}/logo.png";
        $this->firma = "{$this->ruta_img}/{$_SESSION['ips']}/firma/{$_SESSION['usr']}.png";
        switch ($_SESSION['ips']) {
            case 'pruebas':
                $this->nombre = 'Prueba IPS';
                $this->nit = 'NIT. 1.111.111.111-1';
                $this->telefono = '355 555 5555 - 311 111 1111';
                $this->logo = "{$this->ruta_img}/sigma/logo.png";
                $this->firma = "{$this->ruta_img}/sigma/firma/{$_SESSION['usr']}.png";
                break;
            case 'sigma': {
                $this->nombre = 'Sigma IPS';
                $this->nit = 'NIT. 2.222.222.222-2';
                switch ($_SESSION['usr']) {
                    case 'alebotero':
                        $this->telefono = '311 306 6308';
                        break;
                    case 'vjimenez':
                        $this->telefono = '311 789 7933';
                        break;
                }
            }
        }
    }
}
?>