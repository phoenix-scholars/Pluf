<?php

/**
 * خطای پیدا نشدن یک دنبال‌کننده
 * 
 * @author hadi <mohammad.hadi.mansouri@dpq.co.ir>
 *
 */
class SaaSNewspaper_Exception_FollowerNotFound extends Pluf_Exception
{

    /**
     * یک نمونه از این کلاس ایجاد می‌کند.
     *
     * @param string $message            
     * @param Pluf_Exception $previous            
     * @param string $link            
     * @param string $developerMessage            
     */
    public function __construct ($message = "requested follower not found.", $previous = null, $link = null, 
            $developerMessage = null)
    {
        parent::__construct($message, 4301, $previous, 404, $link, 
                $developerMessage);
    }
}