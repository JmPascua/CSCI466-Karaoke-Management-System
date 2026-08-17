<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Song Sign-Up</title>
    <style>
        .error{color: #FF0000;} 
        body 
        {
            font-family:'Trebuchet MS', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #CBDDFB;
        }
        h1 
        {
            text-align: center;
            color: #000000;
        }
        h2
        {
            text-align: center;
        }
        .buttons_for_order
        {
            width: 50%;
            margin: 0 auto;
        }
        .song_choice_style
        {
            width: 50%;
            margin: 0 auto;
            background-color: lightgray;
            padding: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border: 2px solid #031242;
        }
        .button2 
        {
            width: 100%;
            padding: 10px;
            font-family:'Trebuchet MS', sans-serif;
            color: black;
            border: none;
            border: 2px solid #031242;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s;
        }
        .button2:hover 
        {
            background-color: #031242;
            color: white;
        }
        label 
        {
            font-weight: bold;
        }
        input[type="text"],
        input[type="number"],
        select 
        {
            width: 100%;
            padding: 10px;
            margin-bottom: 20px;
            border: 1px solid #ccc;
            box-sizing: border-box;
        }
        .button
        {
            font-family:'Trebuchet MS', sans-serif;
            width: 10%;
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
          $ORDER = $_POST["Order"];
          $normal_queue = $_POST["normal_queue"];
          $singer_name = $_POST["singer_name"];
          $song_choice = $_POST["song_choice"];
          $money = $_POST["payment_amount"];
          $sign_up = $_POST["sign_up"];
        }
    ?>  
</head>
<body>
    <h1>Yellow Jungle Karaoke System</h1>
    <br>
    <h2>Sign-up</h2>
    
    </script>
    <form class="song_choice_style" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">

        <label for="singer_name">Name:</label><br>
        <input type="text" id="singer_name" name="singer_name" required><br><br>

        <label for="song_choice">Song:</label><br>
        <select id="song_choice" name="song_choice" required>
            <option value=''></option>
            <?php
                $sql = "SELECT Song_id, Title, Version
                        FROM Song;";
                $result = $pdo->query($sql);
                
                while($row = $result->fetch())
                {
                    $song_id = $row['Song_id'];
                    $title = $row['Title'];
                    $version = $row['Version'];

                    echo "<option value=$song_id>$title ($version) </option>";
                }

            ?>
        </select><br><br>

        <label for="payment_amount">Payment Amount ($):</label><br>
        <input type="number" id="payment_amount" name="payment_amount" placeholder=0><br><br>
        
        <button class="button2" type="submit" name="sign_up" value="singer_ready">Sign Up</button>
    </form>

    <br>

    <h2>Song Search</h2>
    <form class="buttons_for_order" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
    <button class="button" type="submit" name="Order" value="ORDER BY Title ASC">Asc</button>
    <button class="button" type="submit" name="Order" value="ORDER BY Title DESC">Desc</button>
    </form>

    <?php
        $sql = "SELECT Title, Version, Artist, GROUP_CONCAT(Contributor.ContributorName) AS Features, Role
                FROM Song
                LEFT JOIN 
                    Feature ON Song.Song_id = Feature.Song_id
                LEFT JOIN
                    Contributor ON Feature.Contributor_id = Contributor.Contributor_id
                GROUP BY 
                    Song.Song_id
                $ORDER;";

        $result = $pdo->query($sql);

        echo "<table style='width:50%'>";
        echo "<tr>";
        echo "<th>Title</th>";
        echo "<th>Version</th>";
        echo "<th>Artist</th>";
        echo "<th>Feature</th>";
        echo "<th>Role</th>";
        echo "</tr>";
        while($row = $result->fetch())
            {
                $song_title = $row['Title'];
                $song_version = $row['Version'];
                $song_artist = $row['Artist'];
                $features = $row['Features'];
                $roles = $row['Role'];
                echo "<tr>";
                echo "<td>$song_title</td>";
                echo "<td>$song_version</td>";
                echo "<td>$song_artist</td>";
                echo "<td>$features</td>";
                echo "<td>$roles</td>";
                echo "</tr>";
            }
            echo "</table>";
    ?>
</body>
<?php
if($sign_up == "singer_ready")
{
    $stmt = "SELECT * FROM Singer;";
    $sign_result = $pdo->query($stmt);

    $rowCount = $sign_result->rowCount();
    $rowCount++;

    $stmt = "INSERT INTO Singer
            VALUES
            ($rowCount, '$singer_name');";

    $sign_result = $pdo->exec($stmt);

    if(empty($money))
    {
        echo "hello";
        $stmt = "INSERT INTO Queue(Singer_id, Song_id)
                 VALUES
                 ($rowCount, $song_choice);";
    }   
    else
    {
        $stmt = "INSERT INTO Queue
                 VALUES
                 ($rowCount, $song_choice, $money);";
    }

    $sign_result = $pdo->exec($stmt);
}
?>
</html>
