<?php

class Menu 
{
    
    private $codigo_tipo_usuario;
    private $url_menu;
    private $menu;

    function __construct($codigo_tipo_usuario, $url_menu, $menu)
    {
        $this->codigo_tipo_usuario = $codigo_tipo_usuario;
        $this->url_menu = $url_menu;
        $this->menu = $menu;
    }

    public function getCodigoTipoUsuario()
    {
        return $this->codigo_tipo_usuario;
    }
     
    public function setCodigoTipoUsuario($codigo_tipo_usuario)
    {
        $this->codigo_tipo_usuario = $codigo_tipo_usuario;
    }
    
    public function getUrlMenu()
    {
        return $this->url_menu;
    }
     
    public function setUrlMenu($url_menu)
    {
        $this->url_menu = $url_menu;
    }
    
    public function getMenu()
    {
        return $this->menu;
    }
     
    public function setMenu($menu)
    {
        $this->menu = $menu;
    }

    public function generarMenu($link)
    {
        $sql = sprintf(
            "SELECT codigo_tipo_usuario, url_menu, menu
            FROM tbl_menus
            WHERE codigo_tipo_usuario = '%s'",
            stripslashes($this->codigo_tipo_usuario)
        );
        $resultado = $link->ejecutarInstruccion($sql);
        while ($fila = $link->obtenerFila($resultado))
        {
            echo "<li><a href='".$fila['url_menu']."'";
            if ($fila["url_menu"] == $this->url_menu)
            {
                echo ' class="menu-top-active" ';
            }
            echo ">".$fila['menu']."</a></li>";
        }
        $link->liberarResultado($resultado);
    }

    public function verificarAcceso($link)
    {
        $sql = sprintf(
            "SELECT codigo_tipo_usuario, url_menu
            FROM tbl_menus
            WHERE codigo_tipo_usuario = '%s'
            AND url_menu = '%s'",
            stripslashes($this->codigo_tipo_usuario),
            stripslashes($this->url_menu)
        );
        $resultado = $link->ejecutarInstruccion($sql);
        if ($link->cantidadRegistros($resultado) > 0)
        {
            return array( "acceso" => true );
        }
        else
        {
            return array( "acceso" => false );
        }
    }

    public static function generarSettings($url_imagen, $nombres, $apellidos)
    {
        echo '<a class="media-left" href="#"><img src="'.$url_imagen.'" alt="" class="img-rounded" /></a><div class="media-body"><h4 class="media-heading">'.$nombres.' '.$apellidos.'</h4></div>';
    }
}

?>
