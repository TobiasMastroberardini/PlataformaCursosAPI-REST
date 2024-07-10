Endpoints:

Cursos:

Obtener todos los Cursos: /APIPlataformacursos/courses -> Metodo GET

Obtener Curso por ID: /APIPlataformacursos/courses/:ID -> Metodo GET

por ejemplo /APIPlataformacursos/courses/31 devuelve:

{
    "course_id": 31,
    "title": "Aprende CSS ahora! curso completo GRATIS desde cero",
    "description": "Curso gratuito de CSS",
    "teacher_id": 2,
    "link": "https://www.youtube.com/embed/wZniZEbPAzk",
    "category": 1,
    "minutes": 125
}



Sobrecursos:

title , teacher, category , description , link , minutes

las formas de uso son las siguientes: /APIPlataformacursos/courses/:ID/:sobrecurso -> Metodo GET

/APIPlataformacursos/courses/31/title : "Aprende CSS ahora! curso completo GRATIS desde cero"
/APIPlataformacursos/courses/31/teacher : 2 (ID de profesor)
/APIPlataformacursos/courses/31/category : 1 (ID categoria)
/APIPlataformacursos/courses/31/description : "Curso gratuito de CSS"
/APIPlataformacursos/courses/31/link : "https://www.youtube.com/embed/wZniZEbPAzk"
/APIPlataformacursos/courses/31/minutes : 125




Paginar:

Para paginar se debe establecer el page y el limit. Se hace de la siguiente manera:

/APIPlataformacursos/courses?page=2&limit=10

por ejemplo aca lista 10 objetos empezando por el indice 2 del arregelo (o sea el tercer objeto)



Obtener Token para poder realizar POST, PUT y DELETE de cursos:

/APIPlataformacursos/user/token -> Metodo GET

Los encabezados deben ser en Basic Auth:

Username: webadmin
Password: admin



Subir un Curso:

Se debera colocar en Bearer Token, el token anteriormente generado para poder realizar el POST

/APIPlataformacursos/courses -> Metodo POST

body:

   {
        "title": "Curso de APIs en PHP",
        "description": "Aprende a crear APIs ",
        "teacher_id": 1,
        "link": "link",
        "category": 7,
        "minutes": 100
    }



Editar un curso:

Se debera colocar en Bearer Token, el token anteriormente generado para poder realizar el PUT

/APIPlataformacursos/courses/:ID -> Metodo PUT

por ejemplo:

/APIPlataformacursos/courses/45 -> Metodo PUT

body:

   {
        "title": "Curso de APIs en PHP",
        "description": "Aprende a crear APIs en PHP",
        "teacher_id": 1,
        "link": "link",
        "category": 7,
        "minutes": 120
    }



Eliminar cursos:

/APIPlataformacursos/courses/:ID -> Metodo DELETE

por ejemplo:

/APIPlataformacursos/courses/45 -> Metodo DELETE



Filtrar los cursos:

Filtrar por categoria:

/APIPlataformacursos/courses/filter/category/:ID

por ejemplo:

/APIPlataformacursos/courses/filter/category/7 -> Metodo GET


Filtrar por profesor:

/APIPlataformacursos/courses/filter/teacher/:ID

por ejemplo:

/APIPlataformacursos/courses/filter/category/1 -> Metodo GET



Rutas:

$router->addRoute('courses', 'GET', 'CoursesController', 'getCourse');
$router->addRoute('courses/:ID', 'GET', 'CoursesController', 'getCourse');
$router->addRoute('courses/:ID/:subrecurso', 'GET', 'CoursesController', 'getCourse');
$router->addRoute('courses/:ID', 'PUT', 'CoursesController', 'updateCourse');
$router->addRoute('courses', 'POST', 'CoursesController', 'createCourse');
$router->addRoute('courses/:ID', 'DELETE', 'CoursesController', 'deleteCourse');
$router->addRoute('courses/filter/category/:category', 'GET', 'CoursesController', 'filterCourses');
$router->addRoute('courses/filter/teacher/:teacher', 'GET', 'CoursesController', 'filterCourses');

