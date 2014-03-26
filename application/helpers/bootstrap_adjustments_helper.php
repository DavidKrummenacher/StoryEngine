<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if ( !function_exists('create_list'))
{
    function create_list($pagination)
    {
		$string = '';
		for($i = 0;$i <= $pagination->total_rows/$pagination->per_page;$i++)
		{
			$class = '';
			if($pagination->cur_page == $i)
			{
				$class = 'class="active"';
			}
			
			$string .= '<li '. $class .'><a href="'.$pagination->base_url.'/'.$i.'">'.$i.'</a></li>';
		}
			
        return $string;
    }   
}