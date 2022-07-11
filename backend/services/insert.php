<?php
    
    include '../config/api_config.php';

    $method = $_SERVER['REQUEST_METHOD'];

    if ($method === 'OPTIONS') {
        die();
    }

    if ($_SERVER['REQUEST_METHOD'] !== 'POST') :
        http_response_code(405);
        echo json_encode([
            'success' => 0,
            'message' => 'Only POST method is allowed.',
        ]);
        exit;
    endif;

    require '../config/db_connection.php';
    $operations = new Connection();
    $connection = $operations->dbConnection();
    $table_name = "tb_courses";

    $data = json_decode(file_get_contents("php://input"));

    http_response_code(400);
    if (!isset($data->courseName) || !isset($data->coursePrice)) :
        echo json_encode([
            'success' => 0,
            'message' => 'Please enter compulsory fields: course name and course price',
        ]);
        exit;
    elseif (empty(trim($data->courseName)) || empty(trim($data->coursePrice))) :
        echo json_encode([
            'success' => 0,
            'message' => 'Please fill in all fields!',
        ]);
        exit;
    endif;

    try {
        $course_name = htmlspecialchars(trim($data->courseName));
        $course_price = $data->coursePrice;
        $query = "INSERT INTO $table_name (courseName, coursePrice)
                  VALUES (:course_name, :course_price)";

        $statement = $connection->prepare($query);
        $statement->bindValue(':course_name', $course_name, PDO::PARAM_STR);
        $statement->bindValue(':course_price', $course_price, PDO::PARAM_STR);

        if ($statement->execute()) {
            http_response_code(201);
            echo json_encode([
                'success' => 1,
                'message' => 'Data successfully inserted!',
            ]);
            exit;
        }
        echo json_encode([
            'success' => 0,
            'message' => 'Bad Reqest! There is some problem in inserting data.'
        ]);
        exit;
    } catch (PDOException $e) {
        http_response_code(500);
        echo json_encode([
            'success' => 0,
            'message' => $e->getMessage(),
        ]);
        exit;
    }
?>
