<?php

namespace BTervoort\SocialStream;

use TwitterAPIExchange;

/**
 * Read posts from twitter
 *
 * @author Bram
 */
class TwitterProvider implements IStreamProvider{

    /** @var TwitterAPIExchange */
    private $twitterAPIExchange;
    private $params;

    /**
     * Construct a twitter provider based on the twitterAPIEXchange api.
     * 
     * example for parameters would be [user_id => '319525252', count => 5]
     * to get 5 post from the users timeline.
     * 
     * @param TwitterAPIExchange $twitterAPIExchange
     * @param array $params {params to add to the statuses/user_timeline call}
     */
    public function __construct(TwitterAPIExchange $twitterAPIExchange, array $params) {
        $this->twitterAPIExchange = $twitterAPIExchange;
        $this->params = $params;
    }
    
    /**
     * @inheritdoc
     */
    public function readStream() {
        $tweets = $this->twitterAPIExchange
            ->setGetfield('?' . http_build_query(array_merge($this->params, [
                'trim_user' => true,
                'exclude_replies' => true,
                'contributor_details' => false,
            ])))
            ->buildOauth('https://api.twitter.com/1.1/statuses/user_timeline.json', 'GET')
            ->performRequest(true, [
                CURLOPT_SSL_VERIFYHOST => false,
                CURLOPT_SSL_VERIFYPEER => 0,
            ]);
        $result = [];
        foreach(json_decode($tweets) as $twit) {
            $result[] = new GenericPost(new \DateTime($twit->created_at), 
                    $twit->text, 'https://twitter.com/statuses/' . $twit->id, 'twitter');
        }
        return $result;
    }
}
