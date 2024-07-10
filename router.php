<?php
require_once 'libs/Router.php';
require_once './app/controllers/apiController.php';
require_once './app/controllers/coursesController.php';
require_once './app/controllers/userApiController.php';
require_once './app/controllers/categoriesController.php';


$router = new Router();

// Rutas para cursos
$router->addRoute('courses', 'GET', 'CoursesController', 'getCourse');
$router->addRoute('courses/:ID', 'GET', 'CoursesController', 'getCourse');
$router->addRoute('courses/:ID/:subrecurso', 'GET', 'CoursesController', 'getCourse');
$router->addRoute('courses/:ID', 'PUT', 'CoursesController', 'updateCourse');
$router->addRoute('courses', 'POST', 'CoursesController', 'createCourse');
$router->addRoute('courses/:ID', 'DELETE', 'CoursesController', 'deleteCourse');

// Rutas para filtrado de cursos
$router->addRoute('courses/filter/category/:category', 'GET', 'CoursesController', 'filterCourses');
$router->addRoute('courses/filter/teacher/:teacher', 'GET', 'CoursesController', 'filterCourses');

// Rutas para categorias
$router->addRoute('categories', 'GET', 'categoriesController', 'get');
$router->addRoute('category/:ID', 'GET', 'categoriesController', 'get');
$router->addRoute('category/:ID', 'PUT', 'categoriesController', 'updateCategory');
$router->addRoute('category/:ID', 'DELETE', 'categoriesController', 'deleteCategory');
$router->addRoute('category', 'POST', 'categoriesController', 'createssCategory');

// Ruta para el token
$router->addRoute('user/token', 'GET', 'userApiController', 'getToken');

$router->route($_GET['resource'], $_SERVER['REQUEST_METHOD']);

?>