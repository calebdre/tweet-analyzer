<?php
use TweetAnalyzer\SentimentAnalyzer\TSAAPI;

require "vendor/autoload.php";

class TSATest extends PHPUnit_Framework_TestCase{
    public function testCanTellNegativeSentiment(){
        $sa = new TSAAPI();
        $this->assertEquals(false, $sa->analyze("this sucks"));
    }

    public function testCanTellPositiveSentiment(){
        $sa = new TSAAPI();
        $this->assertEquals(true, $sa->analyze("this is awesome"));
    }
}