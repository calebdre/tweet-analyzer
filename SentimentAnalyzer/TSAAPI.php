<?php namespace TweetAnalyzer\SentimentAnalyzer;
// https://www.tweetsentimentapi.com/
use Requests;
use TweetAnalyzer\Keys;

class TSAAPI implements SentimentAnalyzer
{
    public function analyze($text){
        $request = Requests::get(
            "https://jamiembrown-tweet-sentiment-analysis.p.mashape.com/api/?text=" . urlencode($text),
            ["Accept" => "application/json", "X-Mashape-Key" => Keys::MASHSHAPE_KEY]
        )->body;

        $sentiment = json_decode($request, true)['sentiment'];

        // true = positive, false = negative
        // yes, positive is misspelled in the API
        if($sentiment == "positiive"){
            return true;
        }else{
            return false;
        }
    }
}