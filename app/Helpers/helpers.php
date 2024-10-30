<?php

if (!function_exists('academy_price')) {
    function academy_price()
    {
        return [
            'U8 and U9 - born 2016 and above'=> 30,
            'U10, U11 and U12 - born 2013 to 2015'=> 70,
            'U13, U14, U15 and U16 - born 2009 to 2012'=> 80,
            'U17 and U18 - born 2007 to 2008'=> 100,
            'Senior (adult teams)'=>200,
        ];
    }
}
?>
