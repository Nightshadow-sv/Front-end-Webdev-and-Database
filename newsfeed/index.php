<?php include 'db.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>THE FEED</title>
    <style>
        body { font-family: Arial, sans-serif; padding: 40px; background: #fff; color: #1a1a1a; }
        
        /* Page Title: 30px (line-height: 36px) */
        h1 { font-size: 30px; line-height: 36px; font-weight: bold; margin: 0; text-transform: uppercase; }
        .sub { font-size: 14px; line-height: 20px; color: #666; margin-top: 5px; }
        hr.title-divider { border: 0; border-top: 1.5px solid #000; margin: 10px 0 25px 0; }

        .filters { margin-bottom: 30px; display: flex; flex-wrap: wrap; gap: 10px; }
        .filters a { 
            text-decoration: none; color: #000; font-weight: bold; 
            font-size: 12px; line-height: 16px; text-transform: uppercase; 
            padding: 8px 14px; border: 1.5px solid #000; 
        }
        .active { background-color: #ff0000 !important; color: #fff !important; border-color: #ff0000 !important; }

        .container { display: flex; flex-wrap: wrap; gap: 20px; }

        /* THE CARD */
        .card { border: 1.5px solid #000; width: 320px; padding: 20px; cursor: pointer; display: flex; flex-direction: column; }
        
        /* Tags/Small Labels: 12px (line-height: 16px) */
        .genre-tag { 
            background: #FFFF00; font-size: 12px; line-height: 16px; font-weight: bold; 
            text-transform: uppercase; padding: 3px 8px; margin-bottom: 12px; align-self: flex-start;
        }

        /* Article titles on cards: 18px (line-height: 28px) */
        .card h3 { 
            font-family: "Times New Roman", Times, serif; font-size: 18px; 
            line-height: 28px; font-weight: bold; margin: 0 0 10px 0; 
        }

        /* Preview text: 14px */
        .summary-preview { font-family: "Times New Roman", Times, serif; font-size: 14px; line-height: 20px; color: #444; margin-bottom: 15px; }

        hr.card-hr { border: 0; border-top: 1.5px solid #000; margin: 10px 0; }

        /* Meta Info: 14px (line-height: 20px) | Timestamps: 12px */
        .card-footer { display: flex; justify-content: space-between; font-size: 14px; line-height: 20px; color: #888; font-weight: bold; }
        .date { font-size: 12px; line-height: 16px; font-weight: normal; }
    </style>
</head>
<body>
    <h1>THE FEED</h1>
    <p class="sub">News from around the world</p>
    <hr class="title-divider">

    <div class="filters">
        <?php 
            $s = isset($_GET['genre']) ? $_GET['genre'] : 'All'; 
            $categories = ['All', 'Technology', 'Business', 'Politics', 'Science', 'Health', 'Sports'];
            foreach ($categories as $cat) {
                $activeClass = ($s == $cat) ? 'active' : '';
                $url = ($cat == 'All') ? 'index.php' : "index.php?genre=$cat";
                echo "<a href='$url' class='$activeClass'>$cat</a>";
            }
        ?>
    </div>

    <div class="container">
        <?php
        $sql = "SELECT * FROM articles";
        if($s != 'All') { $sql .= " WHERE genre = '$s'"; }
        $res = mysqli_query($conn, $sql);
        while($row = mysqli_fetch_assoc($res)) { ?>
            <div class="card" onclick="location.href='news_content.php?id=<?php echo $row['id']; ?>'">
                <div class="genre-tag"><?php echo strtoupper($row['genre']); ?></div>
                <h3><?php echo $row['title']; ?></h3>
                <div class="summary-preview"><?php echo $row['summary']; ?></div>
                <hr class="card-hr">
                <div class="card-footer">
                    <div class="author"><?php echo $row['author']; ?></div>
                    <div class="date"><?php echo date('d/m/Y', strtotime($row['published_at'])); ?></div>
                </div>
            </div>
        <?php } ?>
    </div>
</body>
</html>