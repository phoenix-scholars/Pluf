<?php
namespace Pluf\Template;

abstract class Tag
{

    /**
     *
     * @var array
     */
    protected $context;

    /**
     * Constructor.
     *
     * @param
     *            Context Context object (null)
     */
    function __construct($context = null)
    {
        $this->context = $context;
    }
}