<?php namespace TweetAnalyzer\SentimentAnalyzer;

interface SentimentAnalyzer
{
    /**
     * @param string $text
     * @return boolean
     */
   function analyze($text);
}