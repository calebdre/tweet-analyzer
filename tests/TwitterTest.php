<?php
use TweetAnalyzer\SentimentAnalyzer\TSAAPI;
use TweetAnalyzer\Twitter;

require "vendor/autoload.php";

class TwitterTest extends PHPUnit_Framework_TestCase{
    public function testCanFetchTweets(){
        $twitter = new Twitter(new TSAAPI());
        $tweets = $twitter->fetch("@apple");
        $this->assertEquals(true, is_array($tweets));

        $this->assertEquals(0, count(array_diff([
            'query',
            'tweet_count',
            'all_tweets',
            'positive_tweets',
            'positive_tweet_count',
            "negative_tweets",
            "negative_tweet_count"
        ], array_keys($tweets))));

        $firstTweet = $tweets['all_tweets'][0];
        $this->assertEquals(0, count(array_diff([
            "user",
            "user_link",
            "tweet_link",
            "message",
            "sentiment"
        ], array_keys($firstTweet))));
    }
}