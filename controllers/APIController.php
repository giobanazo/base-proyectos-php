<?php 

namespace Controllers;
use Model\Cita;
use Model\Servicio;
use Model\CitaServicio;

class APIController {
    public static function index() {
        $servicios = Servicio::all();

        echo json_encode($servicios);
    }

    public static function guardar() {

        // Almacena la Cita y devuelve el ID
        $cita = new Cita($_POST);
        $resultado = $cita->guardar();

        $id = $resultado['id'];
        // Almacena las Citas y los Servicios

        // Almacena los Servicios con el ID de la cita
        $idServicios = explode(",", $_POST['servicios']); // explode() es como el split() convierte un string en un arreglo

        foreach($idServicios as $idServicio) {

            $args = [
                'citaId' => $id,
                'servicioId' => $idServicio
            ];

            $citaServicio = new CitaServicio($args);
            $citaServicio->guardar();
        }

        // Retornamos una respuesta
        echo json_encode(['resultado' => $resultado]);
    }

    public static function eliminar() {

        if($_SERVER['REQUEST_METHOD'] == 'POST') {
            $id = $_POST['id'];

            $cita = Cita::find($id);
            $cita->eliminar();

            // $_SERVER['HTTP_REFERER'] nos devuelve la ruta actual en el que estamos
            header('Location: ' . $_SERVER['HTTP_REFERER']);
        }
    }
}