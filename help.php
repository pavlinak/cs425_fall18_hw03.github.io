<?php
include 'top.html';
session_start();
session_unset();
?>

<script>
    document.getElementById('help_page').classList.add('active');
    document.getElementById('helppage_mobile').classList.add('active');
</script>

<div class="padding-top-bottom">
    <div class="container">
        <table>
            <tr>
                <h3>INSTRUCTIONS:</h3>
            </tr>
            <tr>
                <ul>
                    <li>-You can switch through pages from the tabs at</li>
                    <li>the navigation bar at the top of the page.</li>
                    <li>-At the Help tab, you can see instructions</li>
                    <li>about the game and the website.</li>
                    <li>-At the Scores tab, you can see the saved scores.</li>
                    <li>-At the Home tab, you can find the Home Page.</li>

                </ul>
            </tr>
            <tr>
                <h5>How to play the game:</h5>
                <ul>
                    <li>1) Go to Home Page from the navigation bar.</li>
                    <li>2) Press the START button in the middle of the screen.</li>
                    <li>3) Choose your answer.</li>
                    <li>4) Press button NEXT.</li>
                    <li>5) Repeat steps 3 and 4 until your reach question 5.</li>
                    <li>6) When you reach question 5, </li>
                    <li>choose your answer and press button FINISH.</li>
                </ul>
            </tr>
            <tr><h5>When you finish the game</h5>
                <li>You can view your performance statistics of the game. </li>
                <li>You can save your score by giving a nickname.</li></tr>
        </table>
    </div>
</div>

<a class="my-btn" href="help.php">Top</a>

<?php
include 'bottom.html';
?>