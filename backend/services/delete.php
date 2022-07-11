<?php
    include '../config/api_config.php';

    $method = $_SERVER['REQUEST_METHOD'];

    if ($method === 'OPTIONS') {
        die();
    }

    if ($method !== 'DELETE') :
        http_response_code(405);
        echo json_encode([
            'success' => 0,
            'message' => 'Only DELETE method is allowed!'
        ]);
        exit;
    endif;

    http_response_code(400);
    if (!isset($_GET['id'])) {
        echo json_encode([
            'success' => 0,
            'message' => 'Missing course\'s id parameter in the url!'
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
    $course_id = $_GET['id'];
    $table_name = "tb_courses";

    http_response_code(500);
    try {
        $query = "SELECT courseId FROM $table_name WHERE courseId = :course_id";
        $statement = $connection->prepare($query);
        $statement->bindValue(':course_id', $course_id, PDO::PARAM_INT);
        $statement->execute();
        
        if ($statement->rowCount() > 0) :
            $query = "DELETE FROM $table_name
                      WHERE courseId = :course_id";
            $statement = $connection->prepare($query);
            $statement->bindValue(':course_id', $course_id, PDO::PARAM_INT);
            
            if ($statement->execute()) {
                http_response_code(204);
                echo json_encode([
                    'success' => 1,
                    'message' => 'Data successfully deleted!'
                ]);
                exit;
            }
            echo json_encode([
                'success' => 0,
                'message' => 'Something went wrong! Data not deleted.'
            ]);
            exit;
        else :
            http_response_code(404);
            echo json_encode([
                'success' => 0,
                'message' => 'No data found by this id: ' + $course_id
            ]);
            exit;
        endif;
    } catch (PDOException $e) {
        echo json_encode([
            'success' => 0,
            'message' => $e.getMessage()
        ]);
        exit;
    }

?>
