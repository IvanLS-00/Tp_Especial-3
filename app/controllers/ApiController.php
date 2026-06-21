<?php
require_once 'app/models/RopaModel.php';
require_once 'app/views/ApiView.php';

class ApiController {
    private $model;
    private $view;
    private $data;

    public function __construct() {
        $this->model = new RopaModel();
        $this->view = new ApiView();
        $this->data = file_get_contents("php://input");
    }

    private function getData() {
        return json_decode($this->data);
    }

    public function handleRopa($params) {
        $method = $_SERVER['REQUEST_METHOD'];
        $id = isset($params[1]) && is_numeric($params[1]) ? $params[1] : null;

        switch ($method) {
            case 'GET':
                if ($id) {
                    $this->getRopa($id);
                } else {
                    $this->getAllRopa();
                }
                break;
            case 'POST':
                $this->addRopa();
                break;
            case 'PUT':
                if ($id) {
                    $this->updateRopa($id);
                } else {
                    $this->view->response("Debe especificar un ID para modificar.", 400);
                }
                break;
            default:
                $this->view->response("Método no permitido", 405);
                break;
        }
    }

    public function getRopa($id) {
        $prenda = $this->model->getRopaById($id);

        if ($prenda) {
            return $this->view->response($prenda, 200);
        } else {
            return $this->view->response("La prenda con el ID $id no existe.", 404);
        }
    }

    public function getAllRopa() {
        $sort = $_GET['sort'] ?? 'ropa_id';
        $order = $_GET['order'] ?? 'ASC';

        $ropas = $this->model->getRopa($sort, $order);
        return $this->view->response($ropas, 200);
    }

    public function addRopa() {
        $datos = $this->getData();

        if (empty($datos->nombre) || !isset($datos->precio) || empty($datos->talle_id)) {
            return $this->view->response("Datos incompletos. Se requiere nombre, precio y talle_id.", 400);
        }

        $id = $this->model->insertRopa($datos->nombre, $datos->precio, $datos->talle_id);
        
        if ($id) {
            $nuevaPrenda = $this->model->getRopaById($id);
            return $this->view->response($nuevaPrenda, 201);
        } else {
            return $this->view->response("Error al insertar la prenda. Verifique que el talle_id exista.", 500);
        }
    }

    public function updateRopa($id) {
        $prendaExiste = $this->model->getRopaById($id);
        if (!$prendaExiste) {
            return $this->view->response("La prenda con el ID $id no existe.", 404);
        }

        $datos = $this->getData();

        if (empty($datos->nombre) || !isset($datos->precio) || empty($datos->talle_id)) {
            return $this->view->response("Datos incompletos.", 400);
        }

        $this->model->updateRopa($id, $datos->nombre, $datos->precio, $datos->talle_id);
        
        $prendaActualizada = $this->model->getRopaById($id);
        return $this->view->response($prendaActualizada, 200);
    }
}