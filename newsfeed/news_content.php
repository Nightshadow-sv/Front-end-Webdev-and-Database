<?php 
include 'db.php'; 
$id = $_GET['id'];
$result = mysqli_query($conn, "SELECT * FROM articles WHERE id = $id");
$row = mysqli_fetch_assoc($result);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?php echo $row['title']; ?></title>
    <style>
        body { font-family: Arial, sans-serif; padding: 60px; max-width: 800px; margin: auto; color: #1a1a1a; }
        
        .back-btn { 
            background: #fff; border: 1.5px solid #000; padding: 8px 16px; 
            font-size: 12px; line-height: 16px; font-weight: bold; cursor: pointer; 
            margin-bottom: 40px; text-transform: uppercase;
        }

        .tag { background: #FFFF00; padding: 4px 10px; font-size: 12px; line-height: 16px; font-weight: bold; text-transform: uppercase; display: inline-block; }
        
        /* Page title: 30px (line-height: 36px) */
        h1 { 
            font-family: "Times New Roman", Times, serif; font-size: 30px; 
            line-height: 36px; font-weight: bold; margin: 20px 0; color: #000;
        }

        .meta-section { margin: 30px 0; }
        .meta-line { border: 0; border-top: 1.5px solid #000; margin: 12px 0; }
        
        /* Meta info: 14px (line-height: 20px) */
        .author-text { font-family: "Times New Roman", Times, serif; font-size: 14px; line-height: 20px; color: #888; display: block; font-weight: bold; }
        .date-text { font-family: "Times New Roman", Times, serif; font-size: 12px; line-height: 16px; color: #888; display: block; margin-top: 2px; }

        /* Summary as Section Header: 24px (line-height: 32px) */
        .summary-deck { 
            font-family: "Times New Roman", Times, serif; font-size: 24px; 
            line-height: 32px; color: #1a1a1a; margin-bottom: 30px; 
        }

        .body-main-wrapper { border-left: 5px solid #ff0000; padding-left: 25px; margin-top: 25px; }
        
        /* Body text: 16px (line-height: 24px) */
        .article-body { 
            font-family: "Times New Roman", Times, serif; font-size: 16px; 
            line-height: 24px; color: #222; 
        }
        .article-body p { margin-bottom: 25px; }
    </style>
</head>
<body>
    <button class="back-btn" onclick="history.back()">&larr; BACK</button>
    <br>
    <div class="tag"><?php echo strtoupper($row['genre']); ?></div>
    
    <h1><?php echo $row['title']; ?></h1>

    <div class="meta-section">
        <hr class="meta-line">
        <span class="author-text"><?php echo $row['author']; ?></span>
        <span class="date-text"><?php echo date('F j, Y', strtotime($row['published_at'])); ?></span>
        <hr class="meta-line">
    </div>

    <div class="summary-deck">
        <?php echo $row['summary']; ?>
    </div>

    <div class="body-main-wrapper">
        <div class="article-body">
            <?php echo nl2br($row['content']); ?>
        </div>
    </div>
</body>
</html>