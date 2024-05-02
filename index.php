<?php

// 328/quiz/index.php
// This is my CONTROLLER!

// Turn on error reporting
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Require the necessary file
require_once ('vendor/autoload.php');
require_once ('model/data-layer.php');

// Instantiate the F3 Base class
$f3 = Base::instance();

// Define a default route
// https://jmcniel.greenriverdev.com/328/quiz/
$f3->route('GET /', function() {

    // Render a view page
    $view = new Template();
    echo $view->render('views/home-page.html');
});

$f3->route('GET|POST /survey', function($f3) {
    $name = $_POST['name'];

    if($_SERVER['REQUEST_METHOD']== 'POST') {
        // set variables
        if (isset($_POST['answers']))
            $answers = implode(', ', $_POST['answers']);
        else
            $questions = $_POST['answers'];

        $f3->set('SESSION.name', $name);
        $f3->set('SESSION.answers', $answers);

        //reroute to summary
        $f3->reroute('summary');
    }

    // get data from model and add to hive
    $questions = getQuestions();
    $f3->set('questions', $questions);

    // render view page
    $view = new Template();
    echo $view->render('views/survey.html');
});


//Summary
$f3->route('GET /summary', function($f3) {

    //var_dump( $f3->get('SESSION'));

    // Render a view page
    $view = new Template();
    echo $view->render('views/summary.html');
});

// Run Fat-Free
$f3->run();