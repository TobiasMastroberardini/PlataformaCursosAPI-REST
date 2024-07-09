<?php
require_once 'apiController.php';
require_once 'app/helpers/authApiController.php';
require_once 'app/models/usersModel.php';
require_once 'app/views/apiView.php';

class UserApiController extends ApiController
{
    private $model;
    private $authHelper;
    private $apiView;

    function __construct()
    {
        parent::__construct();
        $this->authHelper = new AuthHelper();
        $this->model = new UserModel();
        $this->apiView = new ApiView();
    }

    function getToken($params = [])
    {
        $basic = $this->authHelper->getAuthHeaders();

        if (empty($basic)) {
            $this->apiView->response('No envió encabezados de autenticación.', 401);
            return;
        }

        $basic = explode(" ", $basic);

        if ($basic[0] != "Basic") {
            $this->apiView->response('Los encabezados de autenticación son incorrectos.', 401);
            return;
        }

        $userpass = base64_decode($basic[1]);
        $userpass = explode(":", $userpass);

        $email = $userpass[0];
        $password = $userpass[1];

        $user = $this->model->getByEmail($email);

        $userdata = ["name" => $user];

        if ($user && password_verify($password, $user->password)) {

            $token = $this->authHelper->createToken($userdata);
            $this->apiView->response($token, 200);
            return;
        } else {
            $this->apiView->response('El usuario o contraseña son incorrectos.', 401);
            return;
        }
    }
}