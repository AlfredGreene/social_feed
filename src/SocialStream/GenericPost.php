<?php

namespace BTervoort\SocialStream;

/**
 * A generic usable implementation of IStreamPost,
 * used by the facebook and twitter providers
 *
 * @author Bram
 */
class GenericPost implements IStreamPost {
    /** @var \Datetime */
    private $date;
    /** @var string */
    private $message;
    /** @var string */
    private $url;
    /** @var string */
    private $source;

    /**
     * Build a generic post 
     * @param \DateTime $date
     * @param type $message the breef message 
     * @param type $url url to the origional post
     * @param type $source where the post came from
     */
    function __construct(\DateTime $date, $message, $url, $source) {
        $this->date = $date;
        $this->message = $message;
        $this->url = $url;
        $this->source = $source;
    }
    
    /**
     * @inheritdoc
     */
    public function getDate() {
        return $this->date;
    }

    /**
     * @inheritdoc
     */
    public function getMessage() {
        return $this->message;
    }

    /**
     * @inheritdoc
     */
    public function getUrl() {
        return $this->url;
    }
    
    /**
     * @inheritdoc
     */
    public function getSource() {
        return $this->source;
    }

}
