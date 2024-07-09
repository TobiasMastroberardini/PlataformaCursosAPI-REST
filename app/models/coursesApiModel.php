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

    public function getAllCourses()
    {
        $query = $this->db->prepare('SELECT * FROM courses');
        $query->execute();
        return $query->fetchAll(PDO::FETCH_OBJ);
    }

    public function getCourseByMinutes($order)
    {
        $query = $this->db->prepare('SELECT * FROM courses ORDER BY minutes $order');
        $query->execute([]);
        return $query->fetchAll(PDO::FETCH_OBJ);
    }


    public function createCourse($data)
    {
        $query = $this->db->prepare('INSERT INTO courses (category, description, link, teacher_id, title, minutes) VALUES (?, ?, ?, ?, ?, ?)');
        $query->execute([$data['category'], $data['description'], $data['link'], $data['teacher_id'], $data['title'], $data['minutes']]);
    }


    public function updateCourse($data, $course_id)
    {
        $query = $this->db->prepare('UPDATE courses SET category = ?, description = ?, link = ?, teacher_id = ?, title = ?, minutes = ? WHERE course_id = ?');
        $query->execute([$data['category'], $data['description'], $data['link'], $data['teacher_id'], $data['title'], $data['minutes'], $course_id]);
    }

    public function deleteCourse($course_id)
    {
        $query = $this->db->prepare('DELETE FROM courses WHERE course_id = ?');
        $query->execute([$course_id]);
    }
}