<?php
namespace BTervoort\SocialStream;

use Facebook\Facebook;

/**
 * Get the facebook posts from a page
 *
 * @author Bram
 */
class FacebookProvider implements IStreamProvider{
    /** @var Facebook */
    private $facebook;
    private $page_id;
    private $limit;
    private $accesstoken;
    
    /**
     * 
     * @param Facebook $facebook facebook communication object
     * @param type $page_id      id of the page to read
     * @param type $limit        nr of post go get from the facebook page
     * @param type $accesstoken  application access token
     */
    function __construct(Facebook $facebook, $page_id, $limit, $accesstoken) {
        $this->facebook = $facebook;
        $this->page_id = $page_id;
        $this->limit = $limit;
        $this->accesstoken = $accesstoken;
    }
    
    /**
     * @inheritdoc
     */
    public function readStream() {
        $response = $this->facebook->get('/' . $this->page_id 
                . '/posts?limit='. $this->limit, $this->accesstoken);
        $posts = $response->getDecodedBody()['data'];
        $result = [];
        foreach ($posts as $post) {
            $result[] = new GenericPost(new \DateTime($post['created_time']), 
                    (strstr($post['message'], "\n", true) ?: $post['message']), 
                    'https://www.facebook.com/'. $post['id'], 'facebook');
        }
        return $result;
    }
}
