<?php

    //setting up the time zone
    define('TIMEZONE','Asia/Kolkata');
    date_default_timezone_set(TIMEZONE);

    function last_seen($date_time)
    {

        /**
         * PHP Time Ago functionality is used to display time in a different format.
          *  Display the time format, which is easy to understand.
           * Display the time format similar to different time zone.
           * It is commonly used in messaging and feeds.
           * 
           * 
           * this function used for getting messanger Active or not and othe time related operations

         */
        
	   $timestamp = strtotime($date_time);	
	   
	   $strTime = array("second", "minute", "hour", "day", "month", "year");
	   $length = array("60","60","24","30","12","10");

	   $currentTime = time();
	   if($currentTime >= $timestamp)
        {
			$diff     = time()- $timestamp;
			for($i = 0; $diff >= $length[$i] && $i < count($length)-1; $i++)
             {
			$diff = $diff / $length[$i];
			}

			$diff = round($diff);
            if($diff < 59 && $strTime[$i] =="second"){
                return 'Active';

            }
            else{
			return $diff . " " . $strTime[$i] . "(s) ago ";
            }
	   }
	}
