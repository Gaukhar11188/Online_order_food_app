<?php
include_once('newdb.php');
session_start(); 

$pdo = connect();

if (isset($_SESSION['login'])) {
    $userLogin = $_SESSION['login'];

    if ($pdo) {
        try {
            $stmtUser = $pdo->prepare("SELECT user_id FROM users WHERE login_ = :userLogin");
            $stmtUser->bindParam(':userLogin', $userLogin, PDO::PARAM_STR);
            $stmtUser->execute();

            if ($stmtUser->rowCount() > 0) {
                $userData = $stmtUser->fetch(PDO::FETCH_ASSOC);
                $userId = $userData['user_id'];

                $stmt = $pdo->prepare("SELECT * FROM orders WHERE user_id = :userId");
                $stmt->bindParam(':userId', $userId, PDO::PARAM_INT);
                $stmt->execute();
              
                $orderItems = $stmt->fetchAll(PDO::FETCH_ASSOC);

                foreach ($orderItems as $row) {
                    echo '<tr>';
                    

                    echo '<td class="product-name">';
                    echo '<a href="#" class="h5 text-black order-link" data-order-id="' . $row['order_id'] . '">' . $row['order_id'] . '</a>';
                    echo '</td>';
                    


                    echo '<td class="product-name">';
                    echo '<h2 class="h5 text-black">'.$row['order_date'].'</h2>';
                    echo'</td>';

                    echo '<td class="product-name">';
                    echo '<h2 class="h5 text-black">'.$row['total_amount'].'</h2>';
                    echo'</td>';

                    echo '<td class="product-name">';
                    echo '<h2 class="h5 text-black">'.$row['status'].'</h2>';
                    echo'</td>';

                    echo '</tr>';
                }
            } else {
                echo '<tr>';
                    

                echo '<td class="product-name">';
                echo '<h2 class="h5 text-black">No data</h2>';
                echo'</td>';

                echo '<td class="product-name">';
                echo '<h2 class="h5 text-black">No data</h2>';
                echo'</td>';

                echo '<td class="product-name">';
                echo '<h2 class="h5 text-black">No data</h2>';
                echo'</td>';

                echo '</tr>';
            }
        } catch (PDOException $e) {
            echo json_encode(['error' => 'Database error: ' . $e->getMessage()]);
        }
    } else {
        echo json_encode(['error' => 'Database connection error.']);
    }
}
?>