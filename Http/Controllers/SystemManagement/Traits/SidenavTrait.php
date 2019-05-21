<?php
/**
 * Created by PhpStorm.
 * User: Wahab
 * Date: 02/11/2017
 * Time: 10:24 PM
 */
namespace App\Http\Controllers\SystemManagement\Traits;
use App\Models\Dashboard\Sidenav;

trait SidenavTrait
{
    public function loadNavs()
    {
        return $this->manageNavs(Sidenav::Navs()->toArray(), 0, 1);
    }
    public function manageNavs($navs , $parent = 0 , $i = 0)
    {
        $branch = [];
           if(count($navs) > 0)
           {
               foreach($navs as $nav)
               {
                   if ($nav['parent_id'] == $parent)
                   {
                       $children = $this->manageNavs($navs  , $nav['id'] , 0);
                        if($children)
                        {
                               $nav['children'] = $children;
                        }
                        $branch[] = $nav;
                   }
                   else if (is_null($nav['parent_id']))
                   {

                       if($i > 0)
                       {
                        $i++;
                        $nav['children'] = $this->manageNavs($navs , $nav['id'] , $i);
                        $branch[] = $nav;
                       }
                   }
               }
           }
           return $branch;
    }
}