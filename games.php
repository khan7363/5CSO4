<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Game Archive</title>
    <style>
       /* Updated colors and style applied here */

body {
    font-family: 'Inter', sans-serif;
    background: linear-gradient(135deg, #101418 0%, #0c0f12 100%);
    color: #F5F5F5;
    margin: 0;
    padding: 0;
    min-height: 100vh;
}

header {
    background-color: #0E1116;
    border-bottom: 3px solid #4FA3FF;
    padding: 30px 40px;
    text-align: center;
    box-shadow: 0 4px 15px rgba(79, 163, 255, 0.4);
}

h1 {
    margin: 0;
    font-size: 3.2em;
    color: #4FA3FF;
    text-shadow: 0 0 12px rgba(79, 163, 255, 0.8);
    letter-spacing: 3px;
}

.container {
    width: 90%;
    max-width: 1200px;
    margin: 40px auto;
    padding: 20px;
    background-color: rgba(20, 24, 30, 0.8);
    border: 1px solid rgba(79, 163, 255, 0.3);
    border-radius: 12px;
    box-shadow: 0 0 25px rgba(79, 163, 255, 0.25);
}

form {
    text-align: center;
    background-color: rgba(15, 18, 22, 0.9);
    padding: 25px;
    border-radius: 10px;
    border: 1px solid rgba(255, 255, 255, 0.2);
}

input[type="text"] {
    padding: 14px;
    width: 360px;
    background-color: #0E1116;
    border: 2px solid #4FA3FF;
    border-radius: 6px;
    color: #F5F5F5;
    font-size: 1em;
}

input[type="text"]:focus {
    border-color: #FFFFFF;
    box-shadow: 0 0 12px rgba(79, 163, 255, 0.9);
    outline: none;
}

input[type="submit"] {
    padding: 14px 30px;
    background-color: #4FA3FF;
    color: #0C0F12;
    border-radius: 6px;
    font-weight: bold;
    cursor: pointer;
    text-transform: uppercase;
}

input[type="submit"]:hover {
    background-color: #82C1FF;
}

table {
    width: 100%;
    border-collapse: collapse;
    background-color: rgba(15, 18, 22, 0.9);
    border-radius: 10px;
    overflow: hidden;
    border: 1px solid rgba(255, 255, 255, 0.15);
}

th, td {
    padding: 18px;
    text-align: center;
}

th {
    background-color: #4FA3FF;
    color: #0C0F12;
    font-weight: bold;
    letter-spacing: 1px;
    text-transform: uppercase;
}

tr:nth-child(even) {
    background-color: rgba(255, 255, 255, 0.05);
}

tr:hover {
    background-color: rgba(79, 163, 255, 0.15);
}

a {
    color: #82C1FF;
    font-weight: bold;
}

a:hover {
    color: #4FA3FF;
}

footer {
    text-align: center;
    padding: 20px;
    background-color: #0E1116;
    color: #4FA3FF;
    border-top: 3px solid #4FA3FF;
    font-size: 0.9em;
}


    </style>
    <link href="https://fonts.googleapis.com/css2?family=Orbitron:wght@400;700&display=swap" rel="stylesheet">
</head>
<body>
    <header>
        <h1> My Games </h1>
    </header>

    <div class="container">
        <?php
        // Connect to database
        $mysqli = new mysqli("localhost", "2414040", "Php@123", "db2414040");

        if ($mysqli->connect_errno) {
            // Reverted to a standard, less dramatic error message
            echo "<p class='error-message'>ERROR: Failed to connect to MySQL: " . $mysqli->connect_error . "</p>";
        }

        // Run SQL query
        $sql = "SELECT * FROM games ORDER BY rating DESC";
        $results = isset($mysqli) && !$mysqli->connect_errno ? $mysqli->query($sql) : null;
        ?>

        <form action="search.php" method="post">
        <input type="text" name="keywords" placeholder="Search for a game...">
        <input type="submit" value="Search"> </form>
	 <a href="add-game-form.php" class="btn btn-primary">Add a game</a>


        <table>
            <thead>
                <tr>
                    <th> Game Name</th>
                    <th> Release Date</th>
                    <th> IMDB Rating</th>
					
                </tr>
            </thead>
            <tbody>
                <?php
                // Mock data if the connection failed, to show the style
                if (!$results || (isset($results) && $results->num_rows === 0)) {
                    $mock_data = [
                        ['game_name' => 'Desert Runner 404', 'released_date' => '2077-10-23', 'rating' => '9.2'],
                        ['game_name' => 'Spice Harvester: The Board Game', 'released_date' => '1984-12-18', 'rating' => '8.8'],
                        ['game_name' => 'Neon District Protocol', 'released_date' => '2049-05-15', 'rating' => '7.9'],
                        ['game_name' => 'Fremen Tactics Simulator', 'released_date' => '2025-01-01', 'rating' => '9.5']
                    ];
                    foreach ($mock_data as $index => $row):
                ?>
                <tr>
                    <td>
                        <a href="details.php?id=<?= $index + 100 ?>">
                            <?= htmlspecialchars($row['game_name']) ?>
                        </a>
                    </td>
                    <td><?= htmlspecialchars($row['released_date']) ?></td>
                    <td>
                        <span style="color: #FF1493; text-shadow: 0 0 10px rgba(255, 20, 147, 0.9);">
                            <?= htmlspecialchars($row['rating']) ?>
                        </span>
                    </td>
                    <td> <a href="delete.php?id=<?= $index + 100 ?>"
                           onclick="return confirm('Are you sure you want to delete \'<?= htmlspecialchars($row['game_name']) ?>\'?');"
                           class="delete-btn">
                            [DELETE]
                        </a>
                    </td>
                </tr>
                <?php
                    endforeach;
                } else {
                    // Original PHP logic if connection succeeded
                    while ($a_row = $results->fetch_assoc()): ?>
                    <tr>
                        <td>
                            <a href="details.php?ID=<?= htmlspecialchars($a_row['game_ID']) ?>">
                                <?= htmlspecialchars($a_row['game_name']) ?>
                            </a>
                        </td>
                        <td><?= htmlspecialchars($a_row['released_date']) ?></td>
                        <td>
                            <span style="color: #FF1493; text-shadow: 0 0 10px rgba(255, 20, 147, 0.9);">
                                <?= htmlspecialchars($a_row['rating']) ?>
                            </span>
                        </td>
                        <td> <a href="delete.php?id=<?= htmlspecialchars($a_row['game_ID']) ?>" 
                               onclick="return confirm('Are you sure you want to delete \'<?= htmlspecialchars($a_row['game_name']) ?>\'?');"
                               class="delete-btn">
                                [DELETE]
                            </a>
                        </td>
						
					<td> 
                        <a href="edit.php?ID=<?= htmlspecialchars($a_row['game_ID']) ?>" class="edit-btn">
        [EDIT]
    </a>
                    </td>
                    </tr>
                    <?php endwhile;
                }
                ?>
            </tbody>
        </table>
    </div>

    <footer>
        <p>&copy; <?= date("Y") ?> **Game Archive** | Data Stable</p> </footer>
</body>
</html>