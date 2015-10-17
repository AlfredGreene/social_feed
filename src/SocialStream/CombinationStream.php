<?php
namespace BTervoort\SocialStream;

use ArrayObject;
use IteratorIterator;

/**
 * Read all streams and combine them
 *
 * @author B Tervoort
 */
class CombinationStream {
    /** @var array */
    private $providers;
    
    /**
     * contructs a combination stream
     */
    public function __construct() {
        $this->providers = [];
    }
    
    /**
     * AddProvider To the combination to read
     * @param IStreamProvider $provider
     */
    public function addProvider(IStreamProvider $provider) {
        $this->providers[] = $provider;
    }
    
    /**
     * Is the provider registered with this stream
     * @param IStreamProvider $provider
     * @return boolean
     */
    public function containsProvider(IStreamProvider $provider) {
        foreach($this->providers as $key => $prov) {
            if($prov === $provider) {
                return true;
            }
        }
        
        return false;
    }
    
    /**
     * RemoveProvider remove a stream from the combination to read
     * @param IStreamProvider $provider
     */
    public function removeProvider(IStreamProvider $provider) {
        foreach($this->providers as $key => $prov) {
            if($prov === $provider) {
                array_splice($this->providers, $key, 1);
                return;
            }
        }
    }
    
    /**
     * Read the combinatios of streams and give the posts back sorted
     * @return IStreamPost[] post element from the streams
     */
    public function readStream() {
        $result = [];
        foreach ($this->providers as $prov) {
            /* @var $prov IStreamProvider */
            $result = array_merge($result, $prov->readStream());
        }
        
        usort($result, function (IStreamPost $a, IStreamPost $b) {
            if($a->getDate() < $b->getDate())
                return 1;
            if($a->getDate() > $b->getDate())
                return -1;
            return 0;
        });
        return $result;
    }
}
