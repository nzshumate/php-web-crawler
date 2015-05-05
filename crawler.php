<?php
/**
 *
 * AUTHOR - NATHAN SHUMATE
 * DATE - May 5, 2015
 * VERSION - 1.2
 * PURPOSE - CHECK URL TO SEE IF USING GOOGLE ANALYTICS OR DYN
 * Issues - Pulling in data for DYN **FIXED IN V1.3
 *
 **/

   echo "==================================================\r\n";
   echo " HELLO THERE!\r\n";
   echo "==================================================\r\n";
   echo " This page is using the following software        \r\n";
   echo "==================================================\r\n";


class track {


  function __construct($arg1, $arg2, $arg3) {
    if(!$this->isCli()) die("Please use php-cli!");
  	if (!function_exists('curl_init')) die("Please install cURL!");
        $this->hp = $arg1;
        $this->rlevel = $arg2;
        $this->rmax = $arg3;
    }


  function isCli() {
        return php_sapi_name()==="cli";
    }


  function getContent() {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $this->hp);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $content = curl_exec($ch);
        curl_close($ch);
	      return $content;
    }



  function checkGA($content) {

      $flag_ga      = false;

      $script_regex = "/<script\b[^>]*>([\s\S]*?)<\/script>/i";

      preg_match_all($script_regex, $content, $inside_script);

      for ($i = 0; $i < count($inside_script[0]); $i++)
      {
          if (stristr($inside_script[0][$i], "ga.js"))
            $flag_ga = TRUE;
          else
            return (NULL);

      }

    }


  function checkDyn($content) {

        $flag_dyn     = false;

        $script_regex = "/<script\b[^>]*>([\s\S]*?)<\/script>/i";

        preg_match_all($script_regex, $content, $inside_script);

        for ($i = 0; $i < count($inside_script[0]); $i++)
        {
            if (stristr($inside_script[0][$i], "dynect.net"))
              $flag_dyn = TRUE;
            else
              return (NULL);

        }

    }

}

    /*
     *
     * Echo Output
     *
     */

    $track_obj = new track();

    $ga = $track_obj->checkGA($content);

      if ($ga == NULL) {
        echo "USING GA: NO\r\n";
      }
      else {
        echo "USING GA: YES\r\n";
      }

    $dyn = $track_obj->checkDyn($content);

      if ($ga == NULL) {
        echo "USING DYN: NO\r\n";
      }
      else {
        echo "USING DYN: YES\r\n";
      }


      echo "  _       _ \r\n";
      echo " |_) \_/ |_ \r\n";
      echo " |_)  |  |_ \r\n";
      echo "            \r\n";



?>
