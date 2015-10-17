<?php

namespace BTervoort\SocialStream;

/**
 * Provide a post stream
 * @author Bram
 */
interface IStreamProvider {
    
    /**
     * Read a stream of posts from the provider
     * @return IStreamPost[] List of gathered posts
     */
    public function readStream();
}
