<?php
    date_default_timezone_set('America/Los_Angeles');
    require_once __DIR__."/../vendor/autoload.php";
    require_once __DIR__."/../src/Student.php";
    require_once __DIR__."/../src/Course.php";

    use Symfony\Component\Debug\Debug;
    Debug::enable();
    $app = new Silex\Application();
    $app['debug'] = true;

    $server = 'mysql:host=localhost;dbname=university';
    $username = 'root';
    $password = 'root';
    $DB = new PDO($server, $username, $password);

    use Symfony\Component\HttpFoundation\Request;
    Request::enableHttpMethodParameterOverride();

    $app->register(new Silex\Provider\TwigServiceProvider(), array(
    'twig.path' => __DIR__.'/../views'
    ));

    $app->get("/", function() use ($app) {
      return $app['twig']->render("home.html.twig", array('students' => Student::getAll(), 'courses' => Course::getAll()));
    });

    $app->get("/student", function() use ($app) {
      return $app['twig']->render("students.html.twig", array('students' => Student::getAll()));
    });

    $app->get("/course", function() use ($app) {
      return $app['twig']->render("courses.html.twig", array('courses' => Course::getAll()));
    });

    $app->post("/addstudent", function() use ($app) {
        $name = $_POST['name'];
        $enroll_date = $_POST['enroll_date'];
        $student = new Student($name, $enroll_date);
        $student->save();
        return $app['twig']->render('students.html.twig', array('students' => Student::getAll()));
    });

    $app->post("/deletestudents", function() use ($app) {
        Student::deleteAll();
        return $app['twig']->render('students.html.twig', array('students' => Student::getAll()));
    });

    $app->post("/addcourse", function() use ($app) {
        $name = $_POST['name'];
        $course_number = $_POST['course_number'];
        $course = new Course($name, $course_number);
        $course->save();
        return $app['twig']->render('courses.html.twig', array('courses' => Course::getAll()));
    });

    $app->post("/deletecourses", function() use ($app) {
        Course::deleteAll();
        return $app['twig']->render('courses.html.twig', array('courses' => Course::getAll()));
    });

    $app->get("/student/{id}", function($id) use ($app) {
        $student = Student::find($id);
        return $app['twig']->render("student.html.twig", array('student' => $student, 'courses' => $student->getCourses(), 'all_courses' => Course::getAll()));
    });

    $app->post("/add_course_student", function() use ($app) {
        $course = Course::find($_POST['course_id']);
        $student = Student::find($_POST['student_id']);
        $student->addCourse($course);
        return $app['twig']->render("student.html.twig", array('student' => $student, 'courses' => $student->getCourses(), 'all_courses' => Course::getAll()));
    });

    $app->patch("/updatestudent/{id}", function($id) use ($app) {
        $student = Student::find($id);
        $student->update($_POST['name']);
        return $app['twig']->render("student.html.twig", array('student' => $student, 'courses' => $student->getCourses(), 'all_courses' => Course::getAll()));
    });

    $app->get("/course/{id}", function($id) use ($app) {
        $course = Course::find($id);
        return $app['twig']->render("course.html.twig", array('course' => $course, 'students' => $course->getStudents(), 'all_students' => Student::getAll()));
    });

    $app->post("/add_student_course", function() use ($app) {
        $course = Course::find($_POST['course_id']);
        $student = Student::find($_POST['student_id']);
        $course->addStudent($student);
        return $app['twig']->render("course.html.twig", array('course' => $course, 'students' => $course->getStudents(), 'all_students' => Student::getAll()));
    });

    $app->patch("/updatecourse/{id}", function($id) use ($app) {
        $course = Course::find($id);
        $course->update($_POST['name'], $_POST['course_number']);
        return $app['twig']->render("course.html.twig", array('course' => $course, 'students' => $course->getStudents(), 'all_students' => Student::getAll()));
    });

    $app->delete("/deletecourse/{id}", function($id) use ($app) {
        $course = Course::find($id);
        $course->delete();
        return $app['twig']->render('courses.html.twig', array('courses' => Course::getAll()));
    });

    $app->delete("/deletestudent/{id}", function($id) use ($app) {
        $student = Student::find($id);
        $student->delete();
        return $app['twig']->render('students.html.twig', array('students' => Student::getAll()));
    });

    $app->get("/thiscourse/{id}", function($id) use ($app) {
        $course = Course::find($id);
        return $app['twig']->render("course.html.twig", array('course' => $course, 'students' => $course->getStudents(), 'all_students' => Student::getAll()));
    });

    $app->get("/thisstudent/{id}", function($id) use ($app) {
        $student = Student::find($id);
        return $app['twig']->render('student.html.twig', array('student' => $student, 'courses' => $student->getCourses(), 'all_courses' => Course::getAll()));
    });
    return $app;
?>
