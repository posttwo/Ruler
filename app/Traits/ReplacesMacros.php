<?php 
namespace App\Traits;
use Illuminate\Support\Arr;

trait ReplacesMacros {
    public function replaceMacro($title, $vars)
    {
        $title = preg_replace_callback('/{{([^}]+)}}/', function ($needle) use ($vars) {
            $value = Arr::get($vars, $needle[1]);
            //if array set to first element
            if(is_array($value))
                $value = $value[0];
            return $value;
            
        }, $title);
        return $title;
    }
}