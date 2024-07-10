<?php
require_once 'libs/Router.php';
require_once './app/controllers/apiController.php';
require_once './app/controllers/coursesController.php';
require_once './app/controllers/userApiController.php';
require_once './app/controllers/categoriesController.php';


$router = new Router();

$router->addRoute('courses', 'GET', 'CoursesController', 'getCourse');
$router->addRoute('courses/filtrar', 'GET', 'CoursesController', 'getCourseFilter');
$router->addRoute('courses/:ID', 'GET', 'CoursesController', 'getCourse');
$router->addRoute('courses/:ID/:subrecurso', 'GET', 'CoursesController', 'getCourse');
$router->addRoute('courses/:ID', 'PUT', 'CoursesController', 'updateCourse');
$router->addRoute('courses', 'POST', 'CoursesController', 'createCourse');
$router->addRoute('courses/:ID', 'DELETE', 'CoursesController', 'deleteCourse');

$router->addRoute('categories', 'GET', 'categoriesController', 'get');
$router->addRoute('category/:ID', 'GET', 'categoriesController', 'get');
$router->addRoute('category/:ID', 'PUT', 'categoriesController', 'updateCategory');
$router->addRoute('category/:ID', 'DELETE', 'categoriesController', 'deleteCategory');
$router->addRoute('category', 'POST', 'categoriesController', 'createssCategory');

// Router productos por categoria
$router->addRoute('courses/category/:ID', 'GET', 'coursesController', 'getCoursesByCategory');

$router->addRoute('user/token', 'GET', 'userApiController', 'getToken');

$router->route($_GET['resource'], $_SERVER['REQUEST_METHOD']);


?>