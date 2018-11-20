<?php
session_start();
if (!isset($_SESSION['game']))
    $_SESSION['game'] = "false";
if (!isset($_SESSION['page']))
    $_SESSION['page'] = "start";
if (!isset($_SESSION['questions']))
    $_SESSION['questions'] = 0;
if (!isset($_SESSION['level']))
    $_SESSION['level'] = 1;
if (!isset($_SESSION['points']))
    $_SESSION['points'] = 0;
if (!isset($_SESSION['easy_questions']))
    $_SESSION['easy_questions'] = array();
if (!isset($_SESSION['medium_questions']))
    $_SESSION['medium_questions'] = array();
if (!isset($_SESSION['hard_questions']))
    $_SESSION['hard_questions'] = array();
if (!isset($_SESSION['performance']))
    $_SESSION['performance'] = array();
include 'top.html';
include 'questions.php';
include 'nicknames.php';
?>
    <script>
        document.getElementById('home_page').classList.add('active');
        document.getElementById('homepage_mobile').classList.add('active');
    </script>
    <br/><br/>
    <div class="padding-all">
        <div class="container">
            <form id="form" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                <div class="text-center">

                    <?php
                    $questions = new question();
                    $num_questions = 5;
                    if ($_SESSION['game'] != "true")
                        $_SESSION['page'] = "start";
                    else $_SESSION['page'] = "game";
                    if ($_SESSION['page'] == "start") {
                        echo '<h3>WELCOME</h3><br/><input id="button" name="button" type="submit" value="START">';
                        echo '</div></form></div></div><br/><br/>';
                        $_SESSION['game'] = "true";
                        $_SESSION['page'] = "game";
                    }
                    if ($_SERVER["REQUEST_METHOD"] == "POST") {
                        if (($_POST['button'] == 'END GAME') || ($_POST['button'] == 'CANCEL')) {
                            session_unset();
                            $page = $_SERVER['PHP_SELF'];
                            if ($_POST['button'] == 'END GAME')
                                echo '<h3>GAME HAS ENDED</h3> <br/>';
                            echo '<h5>Wait a moment..</h5></div></form></div></div><br/><br/>';
                            echo '<meta http-equiv="Refresh" content="0;' . $page . '">';
                        } else if (($_POST['button'] == 'NEXT') || ($_POST['button'] == 'FINISH') || ($_POST['button'] == 'START')) {
                            if ($_POST['button'] != 'START') {
                                if($_SESSION['level']==0){
                                $msg = "<h5>Question: " . ($_SESSION['questions']) . ", Level: Easy<br />Points: " . $_POST["points"];
                                }
                                if($_SESSION['level']==1){
                                $msg = "<h5>Question: " . ($_SESSION['questions']) . ", Level: Medium<br />Points: " . $_POST["points"];
                                }
                                if($_SESSION['level']==2){
                                $msg = "<h5>Question: " . ($_SESSION['questions']) . ", Level: Hard<br />Points: " . $_POST["points"];
                                }
                                if ($_POST["right"] != $_POST["ans"]) {
                                    if (($_SESSION['level'] == 1) || ($_SESSION['level'] == 2)) $_SESSION['level']--;
                                    $msg .= '<br />Answer: Wrong</h5><br />';
                                } else {
                                    if (($_SESSION['level'] == 0) || ($_SESSION['level'] == 1)) $_SESSION['level']++;
                                    $_SESSION['points'] += $_POST["points"];
                                    $msg .= '<br />Answer: Correct</h5><br />';
                                }
                                array_push($_SESSION['performance'], $msg);
                            }
                            if ($_POST['button'] != 'FINISH') {
                                $questions->setQuestions($_SESSION['easy_questions'], $_SESSION['medium_questions'], $_SESSION['hard_questions']);
                                $questions->setLevel($_SESSION['level']);
                                $random = $questions->fetchQuestions();
                                switch ($_SESSION['level']) {
                                    case 0:
                                        array_push($_SESSION['easy_questions'], $random);
                                        break;
                                    case 1:
                                        array_push($_SESSION['medium_questions'], $random);
                                        break;
                                    case 2:
                                        array_push($_SESSION['hard_questions'], $random);
                                        break;
                                }
                            }
                            loadpage();
                        } else if ($_POST['button'] == 'SAVE') {
                            $success = nicknames::saveNickname($_POST['nickname'], $_SESSION['points']);
                            session_unset();
                            $page = $_SERVER['PHP_SELF'];
                            if ($success === true){echo '<h5>Your score is now saved</h5>';}
                            else echo '<h5>Your score is not saved</h5>';
                            echo '</div></form></div></div><br/><br/>';
                            echo '<meta http-equiv="Refresh" content="0;' . $page . '">';
                        } else {
                            echo '</div></form></div></div><br/><br/>';
                        }
                    }
                    function loadpage()
                    {
                        $_SESSION['questions']++;
                        if ($GLOBALS['questions'] != null)
                            if ($_SESSION['questions'] < $GLOBALS['num_questions'] + 1) {
                                echo '<h3>' . $GLOBALS['questions']->getQuestion() . '</h3>';
                                echo '<label><input type="radio" name="ans" value="a"/><span>' . $GLOBALS['questions']->getChoice1() . '</span></label>';
                                echo '<label><input type="radio" name="ans" value="b"/><span>' . $GLOBALS['questions']->getChoice2() . '</span></label><br/>';
                                echo '<label><input type="radio" name="ans" value="c"/><span>' . $GLOBALS['questions']->getChoice3() . '</span></label>';
                                echo '<label><input type="radio" name="ans" value="d"/><span>' . $GLOBALS['questions']->getChoice4() . '</span></label><br/>';
                                echo '<input type="hidden" name="right" value="' . $GLOBALS["questions"]->getRightChoice() . '"/>';
                                echo '<input type="hidden" name="points" value="' . $GLOBALS["questions"]->getquestion_points() . '"/>';
                                echo '<input id="button" name="button" type="submit" value="END GAME">';
                                if ($_SESSION['questions'] == $GLOBALS['num_questions']) echo '<input id="button" name="button" type="submit" value="FINISH">';
                                else echo '<input id="button" name="button" type="submit" value="NEXT">';
                                echo '<p>Question: ' . $_SESSION['questions'] . ' of ' . $GLOBALS['num_questions'] . '</p>';
                            } else {
                                echo '<h2>Performance Status:</h2><br/>';
                                foreach ($_SESSION['performance'] as $item)
                                    echo $item;
                                echo '<h3>Your score is: ' . $_SESSION['points'] . '<br /> Want to save your score?</h3>';
                                echo '<label><h5>If you want to save your score, please give a Nickname</h5></label><input type="text" name="nickname" placeholder="pkyria09">';
                                echo '<input id="button" name="button" type="submit" value="SAVE">';
                                echo '<input id="button" name="button" type="submit" value="CANCEL">';
                            }
                        echo '</div></form></div></div><br/>';
                    }
                    ?>
                    <a class="my-btn" href="index.php">Top</a>
<?php
include 'bottom.html';
?>