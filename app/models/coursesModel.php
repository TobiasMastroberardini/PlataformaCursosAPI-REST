<?php

require_once 'app/models/model.php';
class CoursesModel extends DB
{

    public function getCoursesPaginated($offset, $limit)
    {
        $query = $this->connect()->prepare('SELECT * FROM courses LIMIT :offset, :limit');
        $query->bindParam(':offset', $offset, PDO::PARAM_INT);
        $query->bindParam(':limit', $limit, PDO::PARAM_INT);
        $query->execute();
        return $query->fetchAll(PDO::FETCH_OBJ);
    }

    public function getCourses()
    {
        $query = $this->connect()->prepare('SELECT * FROM courses');
        $query->execute();
        return $query->fetchAll(PDO::FETCH_OBJ);
    }

    public function getCourseById($course_id)
    {
        $query = $this->connect()->prepare('SELECT * FROM courses WHERE course_id=?');
        $query->execute([$course_id]);
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

    public function createCourse($title, $description, $teacher_id, $link, $category, $minutes)
    {
        $query = $this->connect()->prepare('INSERT INTO courses (title,description,teacher_id,link,category,minutes) VALUES (?,?,?,?,?,?)');
        $query->execute([$title, $description, $teacher_id, $link, $category, $minutes]);
    }

    public function getCourse($title, $description, $teacher_id, $link, $category, $minutes)
    {
        $query = $this->connect()->prepare('SELECT course_id FROM courses WHERE title=? AND description=? AND teacher_id=? AND link=? AND category=? AND minutes=?');
        $query->execute([$title, $description, $teacher_id, $link, $category, $minutes]);
        $course = $query->fetch(PDO::FETCH_OBJ);
        return $course;
    }

    public function getCoursesByCategory($category)
    {
        $query = $this->connect()->prepare("SELECT * FROM courses WHERE category = ?");
        $query->execute([$category]); // Pasar el parámetro $category aquí
        return $query->fetchAll(PDO::FETCH_OBJ);
    }

    public function getCoursesByTeacher($teacher_id)
    {
        $query = $this->connect()->prepare("SELECT * FROM courses WHERE teacher_id = ?");
        $query->execute([$teacher_id]);
        return $query->fetchAll(PDO::FETCH_OBJ);
    }

    public function getOrderCoursesByCategory($order)
    {
        $query = $this->connect()->prepare("SELECT * FROM courses ORDER BY category $order");
        $query->execute();
        return $query->fetchAll(PDO::FETCH_OBJ);
    }

    public function getOrderCoursesByMinutes($order)
    {
        $query = $this->connect()->prepare("SELECT * FROM courses ORDER BY minutes $order");
        $query->execute();
        return $query->fetchAll(PDO::FETCH_OBJ);
    }

    public function getOrderCoursesByTeacher($order)
    {
        $query = $this->connect()->prepare("SELECT * FROM courses ORDER BY teacher_id $order");
        $query->execute();
        return $query->fetchAll(PDO::FETCH_OBJ);
    }
}