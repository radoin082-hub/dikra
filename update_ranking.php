<?php
/*function updateRanking($dbname) {
    // Paramètres de connexion à la base de données
    $servername = "localhost";
    $username = "root";
    $password = "";


    try {
        // Connexion à la base de données MySQL via PDO
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        // Configuration des options PDO pour afficher les erreurs de requête SQL
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Récupérer les données envoyées depuis le client
        $data = json_decode(file_get_contents('php://input'), true);

        // Parcourir les données et mettre à jour les classements dans la base de données
        foreach ($data as $item) {
            $studentId = $item['student_id'];
            $newRanking = $item['new_ranking'];
            $newAverage = $item['new_average'];

            $sql = "SELECT * FROM users WHERE id = :studentId";
            $stmt = $conn->prepare($sql);

            $stmt->bindParam(':studentId', $studentId);
            $stmt->execute();

            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            
            if ($result != true) {

                echo "hello";

                $sql = "INSERT INTO  users ( ranking , average) VALUES (:newRanking, :newAverage) ";
                $stmt = $conn->prepare($sql);
                $stmt->bindParam(':newRanking', $newRanking, PDO::PARAM_INT);
                $stmt->bindParam(':newAverage', $newAverage, PDO::PARAM_INT);
                
                $stmt->execute();
                echo 'hello ';
            }


            if ($result) {
                // Mettre à jour le classement de l'étudiant dans la base de données
                $sql = "UPDATE users SET ranking = :newRanking, average = :newAverage WHERE id = :studentId";
                $stmt = $conn->prepare($sql);
                $stmt->bindParam(':newRanking', $newRanking, PDO::PARAM_INT);
                $stmt->bindParam(':newAverage', $newAverage, PDO::PARAM_INT);
                $stmt->bindParam(':studentId', $studentId, PDO::PARAM_INT);
                $stmt->execute();
                echo $studentId;
                echo $newAverage;
                echo $newRanking;
                echo 'donne\n ';
            } else {
                http_response_code(400);
                echo "The id does not exist in the database." . $studentId . '\n';
            }
        }
    } catch(PDOException $e) {
        echo "Erreur PDO : " . $e->getMessage();
    }
    // print_r( $result);

    $conn = null;
}

// updateRanking("etudiant", "etudiantl3");
updateRanking("project");*/
function updateRanking($dbname) {
    $servername = "localhost";
    $username = "root";
    $password = "";

    try {
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $data = json_decode(file_get_contents('php://input'), true);

        foreach ($data as $item) {
            $studentId = $item['student_id'];
            $newRanking = $item['new_ranking'];
            $newAverage = $item['new_average'];

            $sql = "SELECT * FROM users WHERE id = :studentId";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':studentId', $studentId);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($result) {
                $sql = "UPDATE users SET ranking = :newRanking, average = :newAverage WHERE id = :studentId";
            } else {
                $sql = "INSERT INTO users (id, ranking, average) VALUES (:studentId, :newRanking, :newAverage)";
            }
            

            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':studentId', $studentId, PDO::PARAM_INT);
            $stmt->bindParam(':newRanking', $newRanking, PDO::PARAM_INT);
            $stmt->bindParam(':newAverage', $newAverage, PDO::PARAM_INT);
            $stmt->execute();
        }
    } catch(PDOException $e) {
        echo "Erreur PDO : " . $e->getMessage();
    }
    $conn = null;
}

updateRanking("project");

