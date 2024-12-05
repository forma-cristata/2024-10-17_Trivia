<?php
require_once 'quiz.php';

if(session_status() != PHP_SESSION_ACTIVE) session_start();

if(!isset($_SESSION['quiz']))
{
    $_SESSION['quiz'] = null;
}

const ANSWERS = ["12", "pomona", "1918", "cabbage", "S"];
$q1 = $q2 = $q3 = $q4 = $q5 = "";
$q1Err = $q2Err = $q3Err = $q4Err = "";

if($_SERVER["REQUEST_METHOD"] == "POST")
{
    if(isset($POST['clear']))
    {
        session_destroy();
    }
    else{
        $q1 = intval($_POST["q1"]);
        $q2 = strtolower(htmlentities($_POST["q2"]));
        $q3 = intval($_POST["q3"]);
        $q4 = strtolower(htmlentities($_POST["q4"]));
        $q5 = htmlentities($_POST["q5"]);

        $answers = [$q1, $q2, $q3, $q4, $q5];
        $score = compareAnswers($answers);


        $numAnswers = count(ANSWERS);

        $percentage = $score / $numAnswers;
        $fraction = "$score/$numAnswers";




        $quiz = new Quiz($percentage, $fraction);
        $_SESSION['quiz'] = $quiz;


        header('Location: index.php');

    }
}

function compareAnswers($answers): int
{
    $score = 0;

    for($i = 0; $i < count($answers); $i++)
    {
        if($answers[$i] == ANSWERS[$i])
        {
            $score ++;
        }
    }
    return $score;
}
?>

<html lang="en" data-bs-theme="dark">
<head>
    <style>
        .error {color: #016b45;}
    </style>
    <title>Quiz</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="index.css">
</head>
<body>
<main class="container-lg my-3">
    <h2>SPOOKY QUIZ</h2>
<form method="post" action="index.php">


            <label for="q1">1. How many letters are in the word describing a fear of clowns?</label>
            <input  id="q1" name="q1" type="number" min="1" class="form-control d-inline-block w-25" value="<?php echo $q1;?>" required />
            <div class="error d-inline-block">* <?php echo $q1Err;?></div>
             <div class="answer" style="display:none;"><h5>12</h5></div>


        <br />

                <label for="q2" class="form-label d-inline-block">2. Which Roman goddess is thought to be honored on Halloween?</label>
                <input id="q2" name="q2" type="text" class="form-control d-inline-block w-25" value="<?php echo $q2;?>" required/>
                <div class="error d-inline-block">* <?php echo $q2Err;?></div>
                <div class="answer" style="display:none;"><h5>pomona</h5></div>

<br />
                <label for="q3" class="form-label d-inline-block">3. In Twilight, what year did Edward Cullen turn into a vampire?</label>
                <input id="q3" name="q3" type="number" min="0" max="2024" class="form-control d-inline-block w-25" value="<?php echo $q3;?>" required/>
                <div class="error d-inline-block">* <?php echo $q3Err;?></div>
                <div class="answer" style="display:none;"><h5>1918</h5></div>


    <br />

                <label for="q4" class="form-label d-inline-block">4. What vegetable was once thought to have supernatural powers on Halloween?</label>
                <input id="q4" name="q4" type="text" class="form-control d-inline-block w-25" value="<?php echo $q4;?>" required/>
                <div class="error d-inline-block">* <?php echo $q4Err;?></div>
                <div class="answer" style="display:none;"><h5>cabbage</h5></div>

    <br />
                    <label for="q5" value="<?php echo $q5;?>" class="form-check-label">5. What ancient Celtic festival marks the end of the harvest season and the beginning of winter? Select the first letter.</label><!--Samhain-->
                    <div class="wordsearch form-check">
                        <label class="form-check-label">
                            <input type="radio" class="form-check-input" id="q5" name="q5" checked />
                            <span>H</span>
                        </label>
                        <label class="form-check-label">
                            <input type="radio" class="form-check-input" id="q5" name="q5" />
                            <span>Y</span>
                        </label>
                        <label class="form-check-label">
                            <input type="radio" class="form-check-input" id="q5" name="q5" />
                            <span>W</span>
                        </label>
                        <label class="form-check-label">
                            <input type="radio" class="form-check-input answer-radio" id="q5" name="q5" />
                            <span>S</span>
                        </label>
                        <label class="form-check-label">
                            <input type="radio" class="form-check-input" id="q5" name="q5" />
                            <span>T</span>
                        </label>
                    </div>

        <br />
            <button type="submit" class="btn btn-primary">Submit</button>
</form>

<?php if (isset($_SESSION['quiz']) && ($_SESSION['quiz']!=null)) : ?>
    <div id="invisible-at-first">

        <h3 id="fraction"><?= $_SESSION['quiz']->getFraction(); ?></h3>
        <h3 id="percent"><?= $_SESSION['quiz']->getPercentage(); ?></h3>

    </div>
<?php else: ?>
    <?php endif; ?>
    </main>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

</body>
</html>