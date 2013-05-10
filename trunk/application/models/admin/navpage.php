<?php
class Admin_Navpage extends Eloquent
{
    public static $timestamps = true;
    public static $table = 'navigation_pages';
    public static $key = 'navpageid';

    public function modulpage()
    {
        return $this->has_one('Admin_ModulPage','modulpageid');
    }

}?>