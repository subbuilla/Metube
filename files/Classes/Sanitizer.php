<?php
class Sanitizer
{
   public static function stringSanitizer($input)
{
    $input = trim($input);
    $input = strip_tags($input);
    $input = strtolower($input);
    $input = ucfirst($input);

    return $input;
}

public static function emailSanitizer($input)
{
   
    $input = trim($input);
    $input = strip_tags($input);
    return $input;
}

public static function userNameSanitizer($input)
{
   
    $input = trim($input);
    $input = strip_tags($input);
    return $input;
}


}

?>