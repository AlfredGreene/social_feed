<?php
namespace BTervoort\SocialStream;

/**
 * A post from a stream
 * @author Bram
 */
interface IStreamPost {
    /**
     * When it was posted
     * @return \DateTime
     */
    public function getDate();
    
    /**
     * Breef message content
     * @var string
     */
    public function getMessage();
    
    /**
     * Url to link to the full message
     * @var string
     */
    public function getUrl();
    
    /**
     * where the message came from
     * @var string
     */
    public function getSource();
}
