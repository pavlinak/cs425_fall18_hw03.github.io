<?php
include 'top.html';
include 'nicknames.php';
session_start();
session_unset();
?>

<script>
    document.getElementById('high_scores_page').classList.add('active');
</script>

 <div class="padding-all">
        <div class="text-center">
            <h2>Saved High Scores:</h2>
            <br/>
            <div class="container">
                <?php
                $nicknames = nicknames::getNicknames();
                $nicknames_array = explode(PHP_EOL, $nicknames);
                echo '<table style="text-align:center;"><tbody>';
                foreach ($nicknames_array as $item)
		    if ($item != "")
                        echo '<br/>' . $item . '<br/></li></td></tr><br/>';
                echo '</tbody></table><br/>';
                ?>
            </div>
        </div>
    </div>
    <a class="my-btn" href="scores.php">Top</a>
<?php
include 'bottom.html';
?>