<?php

require_once 'app/models/model.php';
class CoursesModel extends DB
{

    public function getCourses()
    {
        $query = $this->connect()->prepare('SELECT * FROM courses');
        $query->execute();
        $courses = $query->fetchAll(PDO::FETCH_OBJ);
        return $courses;
    }

    public function getCourseById($course_id)
    {
        $query = $this->connect()->prepare('SELECT * FROM courses WHERE course_id=?');
        $query->execute([$course_id]);
        $course = $query->fetch(PDO::FETCH_OBJ);
        return $course;
    }

    public function getCoursesByCategory($id)
    {
        $query = $this->connect()->prepare('SELECT * FROM courses WHERE category=?');
        $query->execute([$id]);
        $course = $query->fetch(PDO::FETCH_OBJ);
        return $course;
    }

    public function getCoursesByMinutes($id)
    {
        $query = $this->connect()->prepare('SELECT * FROM courses WHERE minutes=?');
        $query->execute([$id]);
        $course = $query->fetch(PDO::FETCH_OBJ);
        return $course;
    }

    public function getCoursesByTitle($id)
    {
        $query = $this->connect()->prepare('SELECT * FROM courses WHERE title=?');
        $query->execute([$id]);
        $course = $query->fetch(PDO::FETCH_OBJ);
        return $course;
    }

    public function deleteCourse($course_id)
    {
        $query = $this->connect()->prepare('DELETE FROM courses WHERE course_id=?');
        $query->execute([$course_id]);
    }
    public function updateCourse($data, $course_id)
    {
        $query = $this->connect()->prepare('UPDATE courses SET category = ?, description = ?, link = ?, teacher_id = ?, title = ?, minutes = ? WHERE course_id = ?');
        $query->execute([
            $data['category'],
            $data['description'],
            $data['link'],
            $data['teacher_id'],
            $data['title'],
            $data['minutes'],
            $course_id
        ]);
    }

    public function getCourse($title, $description, $teacher_id, $link, $category, $minutes)
    {
        $query = $this->connect()->prepare('SELECT course_id FROM courses WHERE title=? AND description=? AND teacher_id=? AND link=? AND category=? AND minutes=?');
        $query->execute([$title, $description, $teacher_id, $link, $category, $minutes]);
        $course = $query->fetch(PDO::FETCH_OBJ);
        return $course;
    }

    public function createCourse($title, $description, $teacher_id, $link, $category, $minutes)
    {
        $query = $this->connect()->prepare('INSERT INTO courses (title,description,teacher_id,link,category,minutes) VALUES (?,?,?,?,?,?)');
        $query->execute([$title, $description, $teacher_id, $link, $category, $minutes]);
    }

    public function getCoursesByTitile($order)
    {
        $query = $this->connect()->prepare("SELECT * FROM courses ORDER BY title $order");
        $query->execute([]);

        return $query->fetchAll(PDO::FETCH_OBJ);
    }
    public function getCourseByDescription($order)
    {
        $query = $this->connect()->prepare("SELECT * FROM courses ORDER BY description $order");
        $query->execute([]);

        return $query->fetchAll(PDO::FETCH_OBJ);
    }
    public function getCoursesByTeacher($order)
    {
        $query = $this->connect()->prepare("SELECT * FROM courses ORDER BY teacher_id $order");
        $query->execute([]);

        return $query->fetchAll(PDO::FETCH_OBJ);
    }
    public function getCoursesByLink($order)
    {
        $query = $this->connect()->prepare("SELECT * FROM courses ORDER BY link $order");
        $query->execute([]);

        return $query->fetchAll(PDO::FETCH_OBJ);
    }
}