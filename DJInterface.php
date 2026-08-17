<!DOCTYPE html>
<html lang="en">
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        table 
        {
            width: 80%;
            margin: 20px auto;
            border-collapse: collapse;
            background-color: #fff;
            border: 2px solid #031242;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        th, td 
        {
            padding: 3px 15px;
            border-bottom: 1px solid #ddd;
            text-align: left;
        }
        th 
        {
            background-color: #D3D3D3;
            cursor: pointer;
        }
        th:hover 
        {
            background-color: #031242;
        }
        tr:nth-child(even) 
        {
            background-color: #D3D3D3;
        }
        tr:hover 
        {
            background-color: #031242;
            color: white;
        }
        caption 
        {
            font-size: 24px;
            text-align: center;
            font-weight: bold;
            margin-bottom: 10px;
        }
        .formwithButtons
        {
            width: 50%;
            margin: 0 auto;
        }
        body
        {
            font-family:'Trebuchet MS', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #CBDDFB;
        }
        .button
        {
            font-family:'Trebuchet MS', sans-serif;
            width: 20%;
            padding: 5px;
            color: black; 
            border: 2px solid #031242;
            cursor: pointer;
        }
        .button:hover 
        {
            background-color: #031242;
            color: white;
        }
    </style>

    <?php
        $username = "z1952360";
        $password = "2004May03";
        try 
        { // if something goes wrong, an exception is thrown
            
            $dsn = "mysql:host=courses;dbname=z1952360";
            $pdo = new PDO($dsn, $username, $password);
        }
        catch(PDOexception $e) 
        { // handle that exception
            echo "Connection to database failed: " . $e->getMessage();
        }
    ?>
    
    <?php
        if ($_SERVER["REQUEST_METHOD"] == "POST")
        {
          $paid_queue = $_POST["paid_queue"];
          $normal_queue = $_POST["normal_queue"];
        }
    ?>

    <!-- HTML SECTION FOR BODY BEGINS -->

    <head>
        <title>DJ Interface</title>
    </head>
    <body>
        <div style="text-align: center;">
        <h1>DJ Mimi's Interface</h1>
        </div>

        <form class = "formwithButtons" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
            <button class="button" type="submit" name="paid_queue" value="SHOW PAID QUEUE">Paid Queue</button>
            <button class="button" type="submit" name="normal_queue" value="SHOW NORMAL QUEUE">Normal Queue</button>
        </form>

    </body>

    <!-- PHP SECTION FOR TABLES BEGINS -->

    <?php
        if($paid_queue == "SHOW PAID QUEUE")
        {
            $sql = "SELECT SingerName, Title, Artist, Version, Song.Song_id
                    FROM Queue
                    LEFT JOIN
                        Singer ON Singer.Singer_id = Queue.Singer_id
                    LEFT JOIN
                        Song ON Song.Song_id = Queue.Song_id
                    WHERE Money IS NOT NULL
                    GROUP BY Queue.Singer_id
                    ORDER BY Queue.Money DESC;";

            $result = $pdo->query($sql);
            echo "<table style='width:50%'>";
            echo "<tr>"; 
            echo "<th>SingerName</th>";
            echo "<th>Title</th>";
            echo "<th>Artist</th>";
            echo "<th>Version</th>";
            echo "<th>Song Number</th>";
            echo "</tr>";
            while($row = $result->fetch())
            {
                $singer_name = $row['SingerName'];
                $song_title = $row['Title'];
                $song_artist = $row['Artist'];
                $song_version = $row['Version'];
                $song_id = $row['Song_id'];
                echo "<tr>";
                echo "<td>$singer_name</td>";
                echo "<td>$song_title</td>";
                echo "<td>$song_artist</td>";
                echo "<td>$song_version</td>";
                echo "<td>$song_id</td>";
                echo "</tr>";
            }
            echo "</table>";
        }

        if($normal_queue == "SHOW NORMAL QUEUE")
        {
            $sql = "SELECT SingerName, Title, Artist, Version, Song.Song_id
                    FROM Queue
                    LEFT JOIN
                        Singer ON Singer.Singer_id = Queue.Singer_id
                    LEFT JOIN
                        Song ON Song.Song_id = Queue.Song_id
                    WHERE Money IS NULL
                    GROUP BY 
                    Queue.Singer_id;";

            $result = $pdo->query($sql);
            echo "<table style='width:50%'>";
            echo "<tr>"; 
            echo "<th>SingerName</th>";
            echo "<th>Title</th>";
            echo "<th>Artist</th>";
            echo "<th>Version</th>";
            echo "<th>Song Number</th>";
            echo "</tr>";
            while($row = $result->fetch())
            {
                $singer_name = $row['SingerName'];
                $song_title = $row['Title'];
                $song_artist = $row['Artist'];
                $song_version = $row['Version'];
                $song_id = $row['Song_id'];
                echo "<tr>";
                echo "<th>$singer_name</th>";
                echo "<td>$song_title</td>";
                echo "<td>$song_artist</td>";
                echo "<td>$song_version</td>";
                echo "<td>$song_id</td>";
                echo "</tr>";
            }
            echo "</table>";
        }
    ?>
</html>
