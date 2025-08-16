<?php
error_reporting(E_ALL);
ini_set("display_errors", 1);
include('./models/usuario.php');

class configControllers {
    private $usuario;

    public function __construct() {
        $this->usuario = new usuario;
    }

    private $menus = [
        1 => [
            ['label' => 'Área', 'link' => '?c=area'],
            ['label' => 'Data', 'link' => '?c=dato'],
            ['label' => 'Móvil', 'link' => '?c=movil'],
            ['label' => 'Proveedor', 'link' => '?c=proveedor'],
            ['label' => 'Usuario', 'link' => '?c=usuario'],
        ],
        2 => [
            ['label' => 'Data', 'link' => '?c=dato'],
            ['label' => 'Proveedor', 'link' => '?c=proveedor'],
        ],
    ];

    public function index() {
        session_start();

        // Eliminar acceso
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['eliminar'])) {
            $rol = $_POST['rol'];
            $link = $_POST['link'];

            // Eliminar por link
            $this->menus[$rol] = array_filter($this->menus[$rol], function($item) use ($link) {
                return $item['link'] !== $link;
            });
        }

        // Editar acceso
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['editar'])) {
            $rol = $_POST['rol'];
            $oldLink = $_POST['old_link'];
            $newLabel = $_POST['label'];
            $newLink = $_POST['link'];

            foreach ($this->menus[$rol] as &$item) {
                if ($item['link'] === $oldLink) {
                    $item['label'] = $newLabel;
                    $item['link'] = $newLink;
                    break;
                }
            }
        }

        // Agregar nuevo acceso
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['agregar'])) {
            $rol = $_POST['rol'];
            $label = $_POST['label'];
            $link = $_POST['link'];

            $this->menus[$rol][] = ['label' => $label, 'link' => $link];
        }

        $menusPorRol = $this->menus;

        $nombresRol = [
            1 => 'Administrador',
            2 => 'usuario',
        ];

        require_once 'views/config.php';
    }
}
