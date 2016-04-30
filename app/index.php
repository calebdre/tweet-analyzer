<?php
require "../vendor/autoload.php";

use TweetAnalyzer\SentimentAnalyzer\TSAAPI;
use TweetAnalyzer\Twitter;

Flight::route('/analyze/@text', function($text){
    $tw = new Twitter(new TSAAPI());
    Flight::json($tw->fetch($text));
});

Flight::start();