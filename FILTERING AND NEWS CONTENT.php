
                UNDER VSCODE
<---------------for db.php----------------------------->
<?php
$conn = mysqli_connect("localhost", "root", "", "news_portal_db");
?>

<-------------------for index----------------------------->
<?php include 'db.php'; ?>
<!DOCTYPE html>
<html>
<head>
    <title>The Feed</title>
    <style>
        body { font-family: sans-serif; padding: 20px; }
        .filter-links a { margin-right: 15px; text-decoration: none; font-weight: bold; color: black; }
        
        .card { 
            border: 2px solid black; padding: 15px; width: 300px; 
            display: inline-block; margin: 10px; vertical-align: top;
            box-shadow: 5px 5px 0px black; 
        }
        .genre-tag { background: yellow; padding: 2px 5px; font-size: 12px; font-weight: bold; }
    </style>
</head>
<body>
    <h1>THE FEED</h1>
    <p>News from around the world</p> [cite: 44]

    <div class="filter-links">
        <a href="index.php">All</a>
        <a href="index.php?category=Technology">Technology</a>
        <a href="index.php?category=Business">Business</a>
    </div>

    <hr>

    <div>
        <?php
      
        $cat = isset($_GET['category']) ? $_GET['category'] : '';
        $sql = "SELECT * FROM articles";
        if($cat != '') { $sql .= " WHERE genre = '$cat'"; }

        $result = mysqli_query($conn, $sql);
        while($row = mysqli_fetch_assoc($result)) {
        ?>
            <div class="card">
                <span class="genre-tag"><?php echo strtoupper($row['genre']); ?></span>
                <h3><?php echo $row['title']; ?></h3>
                <p><?php echo $row['summary']; ?></p>
                <a href="news_content.php?id=<?php echo $row['id']; ?>">Read More</a>
            </div>
        <?php } ?>
    </div>


<---------------for news_content.php----------------------------->
<?php 
include 'db.php'; 
$id = $_GET['id'];
$result = mysqli_query($conn, "SELECT * FROM articles WHERE id = $id");
$row = mysqli_fetch_assoc($result);
?>
<!DOCTYPE html>
<html>
<head>
    <style>body { font-family: sans-serif; line-height: 1.6; padding: 40px; }</style>
</head>
<body>
    <button onclick="history.back()">BACK</button> [cite: 59]
    <p><strong><?php echo $row['genre']; ?></strong></p>
    <h1><?php echo $row['title']; ?></h1>
    <p>By <?php echo $row['author']; ?> | <?php echo $row['published_at']; ?></p> [cite: 64, 65]
    <hr>
    <p><strong><?php echo $row['summary']; ?></strong></p>
    <p><?php echo $row['content']; ?></p> [cite: 66, 67]
</body>
</html>
</body>
</html>
