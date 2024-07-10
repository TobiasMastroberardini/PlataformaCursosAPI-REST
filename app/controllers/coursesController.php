<?php
require_once 'app/models/coursesModel.php';
require_once 'app/views/apiView.php';
class CoursesController extends ApiController
{
    private $coursesModel;
    private $apiView;
    private $authHelper;

    public function __construct()
    {
        parent::__construct();
        $this->apiView = new ApiView();
        $this->coursesModel = new CoursesModel();
        $this->authHelper = new AuthHelper();
    }



    public function getCourse($params = [])
    {
        if (empty($params)) {

            $page = isset($_GET['page']) ? $_GET['page'] : null;
            $limit = isset($_GET['limit']) ? $_GET['limit'] : null;
            $sort = isset($_GET['sort']) ? $_GET['sort'] : null;
            $order = isset($_GET['order']) ? strtoupper($_GET['order']) : 'ASC';

            if ($page == null & $limit == null) {
                $courses = $this->coursesModel->getCourses();
            } else if ($page != null & $limit != null) {
                $courses = $this->coursesModel->getCoursesPaginated($page, $limit);

            }

            if ($courses) {
                if ($sort && $order) {
                    switch ($sort) {
                        case 'category':
                            $orderedCourses = $this->coursesModel->getOrderCoursesByCategory($order);
                            $this->apiView->response($orderedCourses, 200);
                            break;
                        case 'teacher':
                            $orderedCourses = $this->coursesModel->getOrderCoursesByTeacher($order);
                            $this->apiView->response($orderedCourses, 200);
                            break;
                        case 'minutes':
                            $orderedCourses = $this->coursesModel->getOrderCoursesByMinutes($order);
                            $this->apiView->response($orderedCourses, 200);
                            break;
                        default:
                            $this->apiView->response("no hay cursos para mostrar", 404);
                            break;
                    }
                } else {
                    $this->apiView->response($courses, 200);
                }
            } else {
                $this->apiView->response("no hay cursos para mostrar", 404);
            }

        } else if (isset($params[':ID'])) {
            $id = $params[':ID'];
            $course = $this->coursesModel->getCourseById($id);
            if ($course) {
                if (isset($params[':subrecurso'])) {
                    switch ($params[':subrecurso']) {
                        case 'category':
                            $this->apiView->response($course->category, 200);
                            break;
                        case 'teacher':
                            $this->apiView->response($course->teacher_id, 200);
                            break;
                        case 'minutes':
                            $this->apiView->response($course->minutes, 200);
                            break;
                        case 'title':
                            $this->apiView->response($course->title, 200);
                            break;
                        case 'description':
                            $this->apiView->response($course->description, 200);
                            break;
                        case 'link':
                            $this->apiView->response($course->link, 200);
                            break;
                        default:
                            $this->apiView->response('La curso no contiene ' . $params[':subrecurso'] . '.', 404);
                            break;
                    }
                } else {
                    $this->apiView->response($course, 200);
                }
            } else {
                $this->apiView->response('no existe curso con el id = ' . $id, 404);
            }
        }
    }
    public function filterCourses($params)
    {
        if (isset($params[':category'])) {
            $category = $params[':category'];
            $courses = $this->coursesModel->getCoursesByCategory($category);
            $errorMessage = "No hay cursos en la categoría especificada";
        } elseif (isset($params[':teacher'])) {
            $teacher = $params[':teacher'];
            $courses = $this->coursesModel->getCoursesByTeacher($teacher);
            $errorMessage = "No hay cursos impartidos por el profesor especificado";
        } else {
            // Handle case where no category or teacher parameter is provided
            $this->apiView->response("Falta parámetro de categoría o profesor", 400);
            return;
        }

        if ($courses) {
            $this->apiView->response($courses, 200);
        } else {
            $this->apiView->response($errorMessage, 404);
        }
    }


    public function updateCourse($params = [])
    {
        $user = $this->authHelper->currentUser();
        if (!$user) {
            $this->apiView->response('Unauthorized', 401);
            return;
        }

        if (isset($params[':ID'])) {
            $id = $params[':ID'];
            $existeId = $this->coursesModel->getCourseById($id);
            if ($existeId) {
                $body = $this->getData();
                if (isset($body->title) && isset($body->description) && isset($body->teacher_id) && isset($body->link) && isset($body->category) && isset($body->minutes)) {
                    $data = [
                        'title' => $body->title,
                        'description' => $body->description,
                        'teacher_id' => $body->teacher_id,
                        'link' => $body->link,
                        'category' => $body->category,
                        'minutes' => $body->minutes
                    ];
                    $this->coursesModel->updateCourse($data, $id);
                    $this->apiView->response('se actualizó el curso con éxito', 200);
                    $this->getCourse();
                } else {
                    $this->apiView->response('complete todos los campos', 400);
                }
            } else {
                $this->apiView->response('no existe un curso con ese id', 404);
            }
        } else {
            $this->apiView->response('seleccione un curso', 400);
        }
    }


    public function createCourse()
    {

        $user = $this->authHelper->currentUser();
        if (!$user) {
            $this->apiView->response('Unauthorized', 401);
            return;
        }
        $body = $this->getData();
        if (isset($body->title) && isset($body->description) && isset($body->teacher_id) && isset($body->link) && isset($body->category) && isset($body->minutes)) {
            $course = $this->coursesModel->getCourse($body->title, $body->description, $body->teacher_id, $body->link, $body->category, $body->minutes);
            if (!$course) {
                $this->coursesModel->createCourse($body->title, $body->description, $body->teacher_id, $body->link, $body->category, $body->minutes);
                $this->apiView->response('se agregó el curso correctamente', 201);
                $this->getCourse();
            } else {
                $this->apiView->response('el curso ya existe', 404);
            }
        } else {
            $this->apiView->response('complete todos los campos', 400);
        }
    }

    public function deleteCourse($params = [])
    {
        // Verificar autenticación
        $user = $this->authHelper->currentUser();
        if (!$user) {
            $this->apiView->response('Unauthorized', 401);
            return;
        }

        if (isset($params[':ID'])) {
            $course_id = $params[':ID'];
            $course = $this->coursesModel->getCourseById($course_id);
            if ($course) {
                $this->coursesModel->deleteCourse($course_id);
                $this->apiView->response("Curso id=$course_id eliminado con éxito", 200);
            } else {
                $this->apiView->response("Curso id=$course_id no encontrado", 404);
            }
        } else {
            $this->apiView->response("ID de curso no proporcionado.", 400);
        }
    }
}
?>