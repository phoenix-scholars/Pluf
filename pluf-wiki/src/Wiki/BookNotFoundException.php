<?php

/**
 * خطای یافت نشدن یک کتاب
 * 
 * @author maso <mostafa.barmshory@dpq.co.ir>
 *
 */
class Wiki_BookNotFoundException extends Pluf_Exception
{

    /**
     * یک نمونه از این کلاس ایجاد می‌کند.
     *
     * @param string $message            
     * @param Pluf_Exception $previous            
     * @param string $link            
     * @param string $developerMessage            
     */
    public function __construct ($message = "requested wiki book not found.", $previous = null, $link = null, 
            $developerMessage = null)
    {
        parent::__construct($message, 4302, $previous, 404, $link, 
                $developerMessage);
    }
}