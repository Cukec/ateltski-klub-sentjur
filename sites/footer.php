<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- <link rel="stylesheet" href="styles/footer.css"> -->
    <style>
        footer {
            background-color: #f1f1f1; /* Light gray background for contrast */
            display: flex;
            padding: 2vh;
            justify-content: space-between;
            flex-wrap: wrap;
            border-top: 2px solid gray;
        }

        footer h3 {
            color: gray;
            margin-bottom: 10px;
        }

        footer p {
            color: gray;
            margin: 5px 0;
        }

        .kontakt, .sponsor, .finance {
            text-align: center;
            flex: 1;
        }

        .sponsor {
            padding-top: 3vh;
            display: flex;
            justify-content: center;
            gap: 2vw;
        }

        .sponsor img {
            max-width: 100%;
            max-height: 10vw;
        }

        /* Responsive styling for smaller screens */
        @media (max-width: 768px) {
            footer {
                flex-direction: column;
                align-items: center;
            }
            .sponsor {
                justify-content: center;
            }
        }
    </style>
</head>
    <?php

    $sql = "SELECT * FROM footer";

    $stmt = $conn->prepare($sql);
    $stmt->execute();

    $result = $stmt->get_result();

    $row = $result->fetch_assoc();
    
    ?>
    
    <footer>
        <div class="kontakt">
            <h3>Atletski klub Šentjur</h3>
            <p><?php echo $row['street'] ?></p>
            <p><?php echo $row['post'] ?></p>
            <h3>Kontakti</h3>
            <p><?php echo $row['contact_person'] ?></p>
            <p>&#9742; <?php echo $row['tel'] ?></p>
            <p><?php echo $row['mail'] ?></p>
        </div>
        <div class="sponsor">
            <img src="../assets/obcina-sentjur.jpg" alt="obcina-sentjur-logo">
            <img src="../assets/asfalt-kovac.jpg" alt="asfalt-kovac-logo">
        </div>
        <div class="finance">
            <h3 id="fin">Finance</h3>
            <p>Davčna Številka: <?php echo $row['tax_number'] ?></p>
            <p><?php echo $row['tax_note'] ?></p>
            <p>TRR: <?php echo $row['trr'] ?></p>
            <p>Banka: <?php echo $row['bank'] ?></p>
            <h3>Ostalo</h3>
            <p><?php echo $row['other'] ?></p>
        </div>
    </footer>
</html>