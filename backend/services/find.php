<?php

    include '../config/api_config.php';

    if ($_SERVER['REQUEST_METHOD'] !== 'GET') :
        http_response_code(405);
        echo json_encode([
            'sucess' => 0,
            'message' => 'Bad request detected! Only GET method is allowed.',
        ]);
        exit;
    endif;

    require '../config/db_connection.php';
    $operations = new Connection();
    $connection = $operations->dbConnection();
    $table_name = "tb_courses";
    $course_id = $_GET['id'];

    try {
        $query = is_numeric($course_id) 
            ? "SELECT * FROM $table_name WHERE courseId = '$course_id'"
            : "SELECT * FROM $table_name";
        
        $statement = $connection->prepare($query);
        $statement->execute();
        if ($statement->rowCount() > 0) :
            $data = null;
            if (is_numeric($course_id)) {
                $data = $statement->fetch(PDO::FETCH_ASSOC);
            } else {
                $data = $statement->fetchAll(PDO::FETCH_ASSOC);
            }

            echo json_encode([
                'success' => 1,
                'data' => $data,
            ]);
        else :
            echo json_encode([
                'success' => 0,
                'message' => 'No record found',
            ]);
        endif;
    } catch (PDOException $e) {
        http_response_code(500);
        echo json_encode([
            'success' => 0,
            'message' => $e->getMessage(),
        ]);
        exit;
    }
?>