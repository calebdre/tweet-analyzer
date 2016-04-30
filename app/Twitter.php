<?php namespace TweetAnalyzer;
use Codebird\Codebird;
use TweetAnalyzer\SentimentAnalyzer\SentimentAnalyzer;
class Twitter
{
    /**
     * @var Codebird
     */
    private $cb;


    /**
     * @var SentimentAnalyzer
     */
    private $sentimentAnalyzer;

    /**
     * @param SentimentAnalyzer $analyzer
     */
    public function __construct(SentimentAnalyzer $analyzer)
    {
        Codebird::setConsumerKey(Keys::KEY, Keys::KEY_PRIVATE);
        $this->cb = Codebird::getInstance();
        Codebird::setBearerToken($this->cb->oauth2_token()->access_token);
        $this->sentimentAnalyzer = $analyzer;
    }

    /**
     * @param array $query
     * @return array
     */
    public function fetch($query){
        $st = ((array) $this->cb->search_tweets('q="'.$query.'"', true));
        $newTweets = [];

        foreach($st['statuses'] as $tweet){
            $sentiment = $this->sentimentAnalyzer->analyze($tweet->text);
            $tweetInfo = [
                "user"=> "@".$tweet->user->screen_name,
                "user_link"=> "http://twitter.com/".$tweet->user->screen_name,
                "tweet_link"=> "http://twitter.com/statuses/" . $tweet->id,
                "message"=>$tweet->text,
                "sentiment" => $sentiment ? "positive" : "negative",
            ];

            $newTweets[] = $tweetInfo;
        }

        $positiveTweets = array_filter($newTweets, function($tweet){
            return $tweet['sentiment'] == "positive";
        });

        $negativeTweets = array_filter($newTweets, function($tweet){
            return $tweet['sentiment'] == "negative";
        });

        return [
            'query' => $query,
            'tweet_count' => count($newTweets),
            'all_tweets' => $newTweets,
            'positive_tweet_count' => count($positiveTweets),
            'positive_tweets' => $positiveTweets,
            'negative_tweet_count' => count($negativeTweets),
            'negative_tweets' => $negativeTweets
        ];
    }
}