<?php
class Admin_View_Helper_Image extends Zend_View_Helper_Abstract
{
    public function image($src,$width='',$alt='',$class='')
    {
        return sprintf(
            '<img src="/upload%s" %s alt="%s" class="%s"/>',
            $src,
            $width ? sprintf('width=%d', $width) : '',
            $alt,
            $class
        );
    }
}