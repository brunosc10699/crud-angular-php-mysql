<?php
    include '../config/api_config.php';

    if ($_SERVER['REQUEST_METHOD'] !== 'PUT') :
        http_response_code(405);
        echo json_encode([
            'success' => 0,
            'message' => 'Only PUT method is allowed!',
        ]);
        exit;
    endif;

    http_response_code(400);
    if (!isset($_GET['id'])) {
        echo json_encode([
            'success' => 0,
            'message' => 'Missing corse\'s id parameter in the url!'
        ]);
        exit;
    } elseif (!is_numeric($_GET['id'])) {
        echo json_encode([
            'success' => 0,
            'message' => 'Course\'s id parameter in the url must be a valid number!'
        ]);
        exit;
    }

    require '../config/db_connection.php';
    $operations = new Connection();
    $connection = $operations->dbConnection();
    $table_name = "tb_courses";
    $course_id = $_GET['id'];

    $data = json_decode(file_get_contents("php://input"));
    if (!isset($data->courseName) || !isset($data->coursePrice)) :
        echo json_encode([
            'success' => 0,
            'message' => 'Course name and course price are mandatory fields!'
        ]);
        exit;
    elseif (empty(trim($data->courseName)) || empty(trim($data->coursePrice))) :
        echo json_encode([
            'success' => 0,
            'message' => 'Please fill in all fields'
        ]);
        exit;
    endif;

    try {
        $course_name = htmlspecialchars(trim($data->courseName));
        $course_price = $data->coursePrice;
        $query = "UPDATE $table_name 
                  SET courseName = :course_name, coursePrice = :course_price
                  WHERE courseId = :course_id";
        $statement = $connection->prepare($query);
        $statement->bindValue(':course_name', $course_name, PDO::PARAM_STR);
        $statement->bindValue(':course_price', $course_price, PDO::PARAM_STR);
        $statement->bindValue(':course_id', $course_id, PDO::PARAM_INT);

        if ($statement->execute()) {
            http_response_code(204);
            echo json_encode([
                'success' => 1,
                'message' => 'Data successfully updated'
            ]);
            exit;
        }
        echo json_encode([
            'success' => 0,
            'message' => 'Bad Request! There is some problem in updating data.'
        ]);
        exit;
    } catch (PDOException $e) {
        http_response_code(500);
        echo json_encode([
            'success' => 0,
            'message' => $e->getMessage()
        ]);
        exit;
    }
?>