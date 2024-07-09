<?php
require_once 'app/controllers/apiController.php';
require_once 'app/models/categoriesModel.php';

class CategoriesController extends ApiController
{
    private $model;
    private $authHelper;

    function __construct()
    {
        parent::__construct();
        $this->model = new CategoriesModel();
        $this->authHelper = new AuthHelper();
    }

    function get($params = [])
    {

        $permitidos = ['category_id', 'category_name']; // Los campos permitidos para ordenamiento

        $sortField = isset($_GET['sort']) ? $_GET['sort'] : 'category_name'; // Toma lo que esta en el sort o el predeterminado
        $sortOrder = isset($_GET['order']) && $_GET['order'] === 'desc' ? 'DESC' : 'ASC'; // Si esta seteado y es descendente -> desc, sino ascendente por defecto

        if (!in_array($sortField, $permitidos)) { // Si lo que hay no se corresponde con un campo permitido corto acá
            return $this->view->response("Bad Request", 400);
        }

        if (empty($params)) {

            if (isset($_GET))

                $categories = $this->model->getCategories($sortField, $sortOrder);
            return $this->view->response($categories, 200);
        } else {
            $categories = $this->model->getCategoryById($params[":ID"]);
            if (!empty($categories)) {
                return $this->view->response($categories, 200);
            } else {
                return $this->view->response("Categoria no encontrada", 404);
            }
        }
    }

    function deleteCategory($params = [])
    {
        $user = $this->authHelper->currentUser();
        if (!$user) {
            $this->view->response('Unauthorized', 401);
            return;
        }

        $category_id = $params[':ID'];
        $category = $this->model->getCategoryById($category_id);

        if ($category) {
            $this->model->deleteCategory($category_id);
            $this->view->response("Categoria id=$category_id eliminada con éxito", 200);
        } else
            $this->view->response("Categoria id=$category_id no encontrada", 404);
    }

    function createCategory($params = [])
    {
        $user = $this->authHelper->currentUser();
        if (!$user) {
            $this->view->response('Unauthorized', 401);
            return;
        }

        $body = $this->getData(); // Desarma el json y genera un objeto

        $name = $body->category_name;

        $id = $this->model->createCategory($name);

        $this->view->response('La categoria se insertó con id=' . $id, 201);
    }

    function updateCategoria($params = [])
    {
        $user = $this->authHelper->currentUser();
        if (!$user) {
            $this->view->response('Unauthorized', 401);
            return;
        }

        $category_id = $params[':ID']; // Capturo el id
        $category = $this->model->getCategoryById($category_id);

        if ($category) { // Me fijo q exista
            $body = $this->getData(); // Desarma el json y genera un objeto

            $name = $body->category_name;

            $this->model->updateCategory($category_id, $name); // Si existe, agarro toda la info y actualizo

            $this->view->response("Categoria id=$category_id se modificó con éxito", 200);
        } else
            $this->view->response("Categoria id=$category_id no encontrada", 404); // Si no existe
    }

}