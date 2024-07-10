<?php
require_once 'apiController.php';
require_once 'app/helpers/authApiController.php';
require_once 'app/models/usersModel.php';
require_once 'app/views/apiView.php';

class UserApiController extends ApiController
{
    private $model;
    private $authHelper;

    function __construct()
    {
        parent::__construct();
        $this->authHelper = new AuthHelper();
        $this->model = new UserModel();
    }

    function getToken($params = [])
    {
        $basic = $this->authHelper->getAuthHeaders();

        if (empty($basic)) {
            $this->view->response('No envió encabezados de autenticación.', 401);
            return;
        }
        $basic = explode(" ", $basic);
        if ($basic[0] != "Basic") {
            $this->view->response('Los encabezados de autenticación son incorrectos.', 401);
            return;
        }
        $userpass = base64_decode($basic[1]);

        $userpass = explode(":", $userpass);
        $user = $userpass[0];
        $pass = $userpass[1];
        $usuario = $this->model->getByEmail($user);
        $userdata = [$usuario, password_verify($pass, $usuario->password)];

        if ($usuario && password_verify($pass, $usuario->password)) {
            $token = $this->authHelper->createToken($userdata);
            $this->view->response($token);
        } else {
            $this->view->response('El usuario o contraseña son incorrectos.', 401);
        }

    }
}