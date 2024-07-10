<?php
require_once 'config.php';
class DB
{
    private $db;
    public function __construct()
    {
        $this->db = new PDO("mysql:host=" . MYSQL_HOST . ";dbname=" . MYSQL_DB . ";charset=" . MYSQL_Charset, MYSQL_USER, MYSQL_PASS);
    }
    public function connect()
    {
        return $this->db;
    }

    function deploy()
    {
        $query = $this->db->query('SHOW TABLES');
        $tables = $query->fetchAll();
        if (count($tables) == 0) {
            $sql = <<<END
            CREATE TABLE `categories` (
            `category_id` int(11) NOT NULL,
            `category_name` varchar(50) DEFAULT NULL
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

            INSERT INTO `categories` (`category_id`, `category_name`) VALUES

            (1, 'Front-end'),

            (2, 'Back-end'),

            (3, 'OS'),

            (4, 'Lenguajes'),

            (6, 'Logica'),

            (7, 'Bases de datos'),

            (8, 'Idiomas'),

            (9, 'Cloud'),


            (10, 'Frameworks'),

            (11, 'DevOps');



            CREATE TABLE `courses` (

            `course_id` int(11) NOT NULL,

            `title` varchar(255) NOT NULL,

            `description` text DEFAULT NULL,

            `teacher_id` int(11) DEFAULT NULL,

            `link` varchar(255) DEFAULT NULL,

            `category` int(9) DEFAULT NULL,

            `minutes` float NOT NULL

            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


            INSERT INTO `courses` (`course_id`, `title`, `description`, `teacher_id`, `link`, `category`, `minutes`) VALUES

            (23, 'Clase de Inglés para Principiantes | TODO LO ESENCIAL EN UN VIDEO | Aprende Inglés desde Cero', '¿Quieres conocer la estrategia completa de cómo aprender inglés rápido y fácil para principiantes (con una oferta especial de mi curso)?', 15, 'https://www.youtube.com/embed/Z6GGAQOMX8c', 8, 102),

            (25, 'Curso de SQL desde CERO (Completo)', 'En este curso de SQL desde CERO Completo vas a aprender a manejar SQL, el lenguaje mas usado del mundo para bases de datos relacionales, un lenguaje requisito para cualquier perfil IT.', 13, 'https://www.youtube.com/embed/DFg1V-rO6Pg', 7, 441),

            (26, 'Aprende SQL ahora! curso completo gratis desde cero', 'Curso completo de SQL ', 2, 'https://www.youtube.com/embed/uUdKAYl-F7g', 7, 78),

            (27, 'Curso COMPLETO de HTML GRATIS desde cero: SEO, semántica y más', '¡Sumérgete en el emocionante mundo de la creación web! Aprende HTML desde cero en este curso completo y totalmente gratuito. ¡Prepárate para construir sitios web asombrosos y dar rienda suelta a tu creatividad en línea! No te lo pierdas.', 1, 'https://www.youtube.com/embed/3nYLTiY5skU', 1, 114),

            (28, '¡APRENDE CSS GRATIS! Curso de CSS desde cero para principiantes', '???? Aprende CSS desde cero Desde Cero\r\n¡Inicia tu viaje en diseño web! Este curso te enseñará los conceptos básicos de CSS de manera rápida y sencilla. Sin experiencia previa necesaria. Crea sitios web impresionantes ahora. ????‍????????', 1, 'https://www.youtube.com/embed/hrxjBqZWsb0', 1, 103),


            (29, 'FLUTTER: COMO Crear una APP DESDE CERO (para Principiantes)', 'Flutter es el framework multiplataforma para crear aplicaciones iOS y Android con una misma base de código mejor valorado en la actualidad. Te explico desde cero qué es, cómo funciona, pros y contras, cómo configurarlo y crear tu primera app usando Dart como lenguaje de programación.', 3, 'https://www.youtube.com/embed/-pWSQYpkkjk', 4, 120),


                (30, 'Crea una APP con PYTHON y CHATGPT desde cero', 'Python es el lenguaje de programación con el que podemos hacer uso del API oficial de ChatGPT. Vamos a crear nuestra primera aplicación desde cero con esta Inteligencia Artificial, para así aprender a integrarla en nuestros proyectos.', 3, 'https://www.youtube.com/embed/b8COygWdvmw', 2, 48),

                    (31, 'Aprende CSS ahora! curso completo GRATIS desde cero', 'Curso gratuito de CSS', 2, 'https://www.youtube.com/embed/wZniZEbPAzk', 1, 125),

                    (32, 'Aprende linux ahora! curso desde cero para principiantes', 'Curso para principiantes de Linux', 2, 'https://www.youtube.com/embed/L906Kti3gzE', 3, 37),


                    (33, 'CURSO de PHP: Aprende Funciones, Clases, Imports y más', '¡Aprende PHP desde cero! ???? Descubre cómo llamar a APIs, dominar funciones y tipos, y mucho más. Desde la creación de clases hasta el manejo experto de archivos.', 1, 'https://www.youtube.com/embed/V2Q1eRUlnlM', 4, 95),

                    (34, 'Curso de GIT desde CERO (Completo)', 'CURSO DE GIT', 13, 'https://www.youtube.com/embed/9ZJ-K-zk_Go', 11, 251),

                    (35, 'CURSO de ANGULAR desde CERO con Nicobytes de Platzi', 'Nicobytes me enseña Angular desde cero... ¡y hay muchas cosas que me gustan! Y otras que me sorprenden...\r\n', 1, 'https://www.youtube.com/embed/sS90VVmBPcg', 10, 98),

                    (36, 'Curso de LÓGICA DE PROGRAMACIÓN Desde Cero', 'Curso de lógica para aprender cualquier lenguaje de programación desde cero, resolviendo ejercicios y siguiendo una ruta de estudio.', 3, 'https://www.youtube.com/embed/TdITcVD64zI', 6, 449),

                    (37, 'Curso de AWS Desde Cero | Amazon Web Services ', 'En este Curso aprenderas desde Cero las bases de Amazon Web Services, desde instalar el CLI de AWS hasta conocer sus servicios', 1, 'https://www.youtube.com/embed/zQyrhjEAqLs', 9, 120);




                    CREATE TABLE `teachers` (


                    `teacher_id` int(11) NOT NULL,

                    `name` varchar(100) NOT NULL,

                    `profile_picture` varchar(255) DEFAULT NULL,

                    `description` text DEFAULT NULL,

                    `bio` varchar(255) NOT NULL

                    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

                    

                    INSERT INTO `teachers` (`teacher_id`, `name`, `profile_picture`, `description`, `bio`) VALUES

                    (1, 'MiduDev', 'https://yt3.googleusercontent.com/ytc/AIdro_kv84TB3x0uLWcJwfLWDX0rA9R_r22ckPwvpWxsS5x29eE=s160-c-k-c0x00ffffff-no-rj', 'Software Engineer especialista en Front-end', '+15 años de experiencia. Ingeniero de Software y Creador de Contenido sobre Programación de Barcelona, España 🇪🇸. Especializado en el desarrollo de aplicaciones web únicas.'),

                    (2, 'HolaMundo', 'https://yt3.googleusercontent.com/Z69fhRL9_OaXsDz-XsCUe2sGIqU7G1F5Mwl0PwlBsx_ll13K0nLb47q7_RMen7NHvzMVDgd2=s160-c-k-c0x00ffffff-no-rj', 'Ingeniero de software', 'Soy un ingeniero de software chileno que vive en Nueva Zelanda, encontré mi pasión en ayudar a ingenieros novatos, profesionales y aspirantes en mejorar sus habilidades, ganar más dinero, conocer su verdadero valor y finalmente mejorar su calidad de vida.'),

                    (3, 'MoureDev', 'https://yt3.googleusercontent.com/BrHvTVuz3HnKJx656FpXzm_B8il50fI281AC0PtrE7RgHazzPqmUudw7yUzqmnuFsaCp6YkTEQ=s160-c-k-c0x00ffffff-no-rj', 'Software Engineer, GitHub Star, Microsoft MVP', 'MoureDev es el reflejo de mi ilusión por crecer como profesional dentro de la industria del desarrollo del software. Como freelance, me he especializado en desarrollo de aplicaciones iOS, Android y web.\r\n\r\n '),

                    (13, 'Dalto', 'https://yt3.googleusercontent.com/jHpWdf9qWNdrCjxfQxCxR0aiYY9Y1IO7s6Jwlk-OgKxS8nzjEMffakE6mdOdp2u22R3130U0nQ=s160-c-k-c0x00ffffff-no-rj', 'Programador Full-Stack', 'Mi nombre es Lucas Dalto, soy programador, desarrollador y divulgador.\r\n\r\n - Más de 6 Años en el rubro IT.\r\n - Enseño programación.\r\n - Canal #1 en Argentina de divulgación gratuita.\r\n- Entiendo el algoritmo de cada red y me adapto.'),

                    (15, 'Kale Anders', 'https://yt3.googleusercontent.com/rwVHhTYDZmyh9fwEGiSHk3qDXZiYG1nKrxNV6kWeSBCCSrNKi3L4s2qUXxNB2jQOjQtneuxznEA=s160-c-k-c0x00ffffff-no-rj', 'Soy experto en aprendizaje de idiomas', '-Enseño intuitivamente, NO intelectualmente. Así que CERO clases de gramática o libros y ejercicios aburridos.\r\n\r\n- Todo se basa en la ciencia del aprendizaje de idiomas.');


                    CREATE TABLE `users` (

                    `user_id` int(11) NOT NULL,

                    `fullname` varchar(255) NOT NULL,

                    `email` varchar(100) NOT NULL,

                    `password` varchar(255) NOT NULL,

                    `is_admin` int(11) NOT NULL

                    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


                    INSERT INTO `users` (`user_id`, `fullname`, `email`, `password`, `is_admin`) VALUES

                    (1, 'Tobias Mastroberardini', 'tmastroberardini1@gmail.com', '$2y$10$hGmKvJNMi356jwP1j0N.LOHyRvKIIj4GMwntY1t7vH7AzTVmFoeyW', 1),

                    (2, 'juan garcia', 'juan@gmail.com', '$2y$10$hGmKvJNMi356jwP1j0N.LOHyRvKIIj4GMwntY1t7vH7AzTVmFoeyW', 0);


                    ALTER TABLE `categories`

                    ADD PRIMARY KEY (`category_id`);

                    

                    ALTER TABLE `courses`

                    ADD PRIMARY KEY (`course_id`),

                    ADD KEY `teacher_id` (`teacher_id`),

                    ADD KEY `category` (`category`);



                    ALTER TABLE `teachers`

                    ADD PRIMARY KEY (`teacher_id`);


                    ALTER TABLE `users`

                    ADD PRIMARY KEY (`user_id`),


                    ADD UNIQUE KEY `email` (`email`);


                    ALTER TABLE `categories`

                    MODIFY `category_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

                    

                    ALTER TABLE `courses`

                    MODIFY `course_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;


                    ALTER TABLE `teachers`

                    MODIFY `teacher_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;


                    ALTER TABLE `users`

                    MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;


                    ALTER TABLE `courses`

                    ADD CONSTRAINT `courses_ibfk_1` FOREIGN KEY (`teacher_id`) REFERENCES `teachers` (`teacher_id`),

                    ADD CONSTRAINT `fk_courses_categories` FOREIGN KEY (`category`) REFERENCES `categories` (`category_id`);

                    COMMIT;

END;
            $this->db->query($sql);

        }

    }
}
?>