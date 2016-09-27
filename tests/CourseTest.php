<?php

    /**
    * @backupGlobals disabled
    * @backupStaticAttributes disabled
    */

    require_once "src/Course.php";
    require_once "src/Student.php";

    $server = 'mysql:host=localhost;dbname=university_test';
    $username = 'root';
    $password = 'root';
    $DB = new PDO($server, $username, $password);

    class CourseTest extends PHPUnit_Framework_TestCase
    {
        protected function tearDown()
        {
            Course::deleteAll();
            Student::deleteAll();
        }

        function test_getName()
        {
            // Assemble
            $name = "Beginner History";
            $course_number = "HIST100";
            $id = null;
            $test_course = new Course($name, $course_number, $id);

            // Act
            $result = $test_course->getName();

            // Assert
            $this->assertEquals($name, $result);
        }

        function test_getCourseNumber()
        {
            // Assemble
            $name = "Beginner History";
            $course_number = "HIST100";
            $id = null;
            $test_course = new Course($name, $course_number, $id);

            // Act
            $result = $test_course->getCourseNumber();

            // Assert
            $this->assertEquals($course_number, $result);
        }

        function test_getId()
        {
            // Assemble
            $name = "Beginner History";
            $course_number = "HIST100";
            $id = null;
            $test_course = new Course($name, $course_number, $id);

            // Act
            $result = $test_course->getId();

            // Assert
            $this->assertEquals($id, $result);
        }

        function test_save()
        {
            // Assemble
            $name = "Beginner History";
            $course_number = "HIST100";
            $id = null;
            $test_course = new Course($name, $course_number, $id);

            $test_course->save();

            //act
            $result = Course::getAll();

            //assert
            $this->assertEquals($test_course, $result[0]);
        }

        function test_getAll()
        {
            // Assemble
            $name = "Beginner History";
            $course_number = "HIST100";
            $id = null;
            $test_course = new Course($name, $course_number, $id);
            $test_course->save();

            $name2 = "Beginner History";
            $course_number2 = "HIST100";
            $id = null;
            $test_course2 = new Course($name2, $course_number2, $id);

            $test_course2->save();

            //act
            $result = Course::getAll();

            //assert
            $this->assertEquals([$test_course, $test_course2], $result);
        }

        function deleteAll()
        {
            // Assemble
            $name = "Beginner History";
            $course_number = "HIST100";
            $id = null;
            $test_course = new Course($name, $course_number, $id);
            $test_course->save();

            $name2 = "Beginner History";
            $course_number2 = "HIST100";
            $id = null;
            $test_course2 = new Course($name2, $course_number2, $id);
            $test_course2->save();

            //act
            Course::deleteAll();
            $result = Course::getAll();

            //assert
            $this->assertEquals([], $result);
        }

        function test_update_name()
        {
            // Assemble
            $name = "Beginner History";
            $course_number = "HIST100";
            $id = null;
            $test_course = new Course($name, $course_number, $id);
            $test_course->save();

            $new_name = "Advanced History";
            $new_course_number = "HIST200";

            $test_course->update($new_name, $new_course_number);
            $result = $test_course->getName();

            $this->assertEquals($new_name, $result);
        }

        function test_update_course_number()
        {
            // Assemble
            $name = "Beginner History";
            $course_number = "HIST100";
            $id = null;
            $test_course = new Course($name, $course_number, $id);
            $test_course->save();

            $new_name = "Advanced History";
            $new_course_number = "HIST200";

            $test_course->update($new_name, $new_course_number);
            $result = $test_course->getCourseNumber();

            $this->assertEquals($new_course_number, $result);
        }

        function test_delete()
        {
            $name = "Beginner History";
            $course_number = "HIST100";
            $id = null;
            $test_course = new Course($name, $course_number, $id);
            $test_course->save();

            $result = $test_course->delete();

            $this->assertEquals([], $test_course->getAll());
        }

        function test_find()
        {
            $name = "Beginner History";
            $course_number = "HIST100";
            $id = null;
            $test_course = new Course($name, $course_number, $id);
            $test_course->save();

            $name2 = "Beginner History";
            $course_number2 = "HIST100";
            $id = null;
            $test_course2 = new Course($name2, $course_number2, $id);
            $test_course2->save();

            $find_id = $test_course2->getId();
            $result = Course::find($find_id);

            $this->assertEquals($test_course2, $result);
        }

        function test_add_student()
        {
            $name = "Beginner History";
            $course_number = "HIST100";
            $id = null;
            $test_course = new Course($name, $course_number, $id);
            $test_course->save();

            $name = "Hector";
            $date = "78";
            $test_student = new Student($name, $date, $id);
            $test_student->save();

            $test_course->addStudent($test_student);
            $result = $test_course->getStudents();

            $this->assertEquals([$test_student], $result);
        }

        function test_getStudents()
        {
            $name = "Beginner History";
            $course_number = "HIST100";
            $id = null;
            $test_course = new Course($name, $course_number, $id);
            $test_course->save();

            $name = "Hector";
            $date = "78";
            $test_student = new Student($name, $date, $id);
            $test_student->save();

            $name2 = "Hector";
            $date2 = "78";
            $test_student2 = new Student($name2, $date2, $id);
            $test_student2->save();

            $test_course->addStudent($test_student);
            $test_course->addStudent($test_student2);

            $result = $test_course->getStudents();

            $this->assertEquals([$test_student, $test_student2], $result);
        }
    }
?>
