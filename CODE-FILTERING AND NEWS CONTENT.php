______________________________________________________________________________ DATABASE SETUP__________________________________________________________________________________
--LABEL: DATABASE SCHEMA (structure of the news articles and categories)
CREATE TABLE IF NOT EXISTS `articles` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `genre` varchar(50) NOT NULL,          
  `title` varchar(255) NOT NULL,         
  `summary` text NOT NULL,              
  `author` varchar(100) NOT NULL,        
  `content` text NOT NULL,               
  `published_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- LABEL: SAMPLE DATA (CATEGORIES & ENTRIES)

INSERT INTO `articles` (`genre`, `title`, `summary`, `author`, `content`) VALUES
('Technology', 'New AI Breakthrough Transforms Natural Language Processing', 'Researchers announce a significant advancement in language models, improving context understanding by 40%.', 'Sarah Chen', 'In a groundbreaking development that has sent ripples through the tech industry, a consortium of leading AI researchers has unveiled a revolutionary advancement in natural language processing. The new model, dubbed "Linguistics 2.0," utilizes a novel architecture that allows it to maintain context over thousands of words, far surpassing current capabilities...'),
('Business', 'Global Markets Show Resilience Amid Economic Shifts', 'Stock indices remain stable as investors look towards new quarterly reports and central bank announcements.', 'Michael Torres', 'The global financial landscape is showing signs of steady recovery as major markets across Asia and Europe reported minor gains this morning. Analysts point to the surprisingly strong performance of the manufacturing sector as a key driver of this stability...');

______________________________________________________________________________ VSCODE FILES__________________________________________________________________________________
<-----------------------------------------------------------File 3: news_content.php----------------------------------------------------------------------------------------->

<?php

$conn = mysqli_connect("localhost", "root", "", "newsfeed");

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
?>

<------------------------------------------------------------------File 2: index.php----------------------------------------------------------------------------------------->

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

       
        .card { border: 1.5px solid #000; width: 320px; padding: 20px; cursor: pointer; display: flex; flex-direction: column; }
        
        
        .genre-tag { 
            background: #FFFF00; font-size: 12px; line-height: 16px; font-weight: bold; 
            text-transform: uppercase; padding: 3px 8px; margin-bottom: 12px; align-self: flex-start;
        }

        
        .card h3 { 
            font-family: "Times New Roman", Times, serif; font-size: 18px; 
            line-height: 28px; font-weight: bold; margin: 0 0 10px 0; 
        }

        
        .summary-preview { font-family: "Times New Roman", Times, serif; font-size: 14px; line-height: 20px; color: #444; margin-bottom: 15px; }

        hr.card-hr { border: 0; border-top: 1.5px solid #000; margin: 10px 0; }

        
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

<--------------------------------------------------------------File 3: news_content.php-------------------------------------------------------------------------------------->
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
