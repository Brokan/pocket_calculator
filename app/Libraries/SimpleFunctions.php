<?php
namespace App\Libraries;

/**
 * Class for simple functions.
 * 
 * @author Eduard Brokan <Eduard.Brokan@gmail.com>
 * @version 0.1.0
 */
class SimpleFunctions
{
    /**
     * Constant chars to convert from
     * @var array 
     */
    protected static $convertfrom = array(
        'Ā', 'Ē', 'Ī', 'Ū', 'Ķ', 'Ļ', 'Ņ', 'Č', 'Š', 'Ģ', 'Ž'
        , 'ā', 'ē', 'ī', 'ū', 'ķ', 'ļ', 'ņ', 'č', 'š', 'ģ', 'ž'
        , 'Й', 'Ц', 'У', 'К', 'Е', 'Н', 'Г', 'Ш', 'Щ', 'З', 'Х', 'Ф', 'Ы', 'В', 'А'
        , 'П', 'Р', 'О', 'Л', 'Д', 'Ж', 'Э', 'Я', 'Ч', 'С', 'М', 'И', 'Т', 'Б', 'Ю'
        , 'й', 'ц', 'у', 'к', 'е', 'н', 'г', 'ш', 'щ', 'з', 'х', 'ф', 'ы', 'в', 'а'
        , 'п', 'р', 'о', 'л', 'д', 'ж', 'э', 'я', 'ч', 'с', 'м', 'и', 'т', 'б', 'ю'
        , '.', ',', ':', ';', ' '
        ,'.', ',', ':', ';', ' ', '-', '_'
    );

    /**
     * Constant chars to convert to
     * @var array 
     */
    protected static $convertto = array(
        'A', 'E', 'I', 'U', 'K', 'L', 'N', 'C', 'S', 'G', 'Z'
        , 'a', 'e', 'i', 'u', 'k', 'l', 'n', 'c', 's', 'g', 'z'
        , 'I', 'C', 'U', 'K', 'E', 'N', 'G', 'SH', 'SH', 'Z', 'H', 'F', 'I', 'V', 'A'
        , 'P', 'R', 'O', 'L', 'D', 'Z', 'E', 'JA', 'CH', 'S', 'M', 'I', 'T', 'B', 'JU'
        , 'i', 'c', 'u', 'k', 'e', 'n', 'g', 'sh', 'sh', 'z', 'h', 'f', 'i', 'v', 'a'
        , 'p', 'r', 'o', 'l', 'd', 'z', 'e', 'ja', 'ch', 's', 'm', 'i', 't', 'b', 'ju'
        , ' ', ' ', ' ', ' ', ' '
        , ' ', ' ', ' ', ' ', ' ', ' ', ' '
    );

    /**
     * Chars to remove from title, replace with space.
     * @var array 
     */
    protected static $notallowed = array(
        ' ', '/', '\\', '?', '&', '@', '!', '$', '#', '%', '^', '*', '(', ')', '=', '[', ']', '"', "'", '<', '>', ',', '.', '`', '~'
    );
    
    /**
     * Create search word of node.
     * @param string $title
     * @return string
     */
    public static function createSearchWord($title) {
        $title = str_replace(self::$convertfrom, self::$convertto, $title);      
        $title = str_replace(self::$notallowed, " ", $title);
        //Leave only a-z, A-Z, 0-9 and space
        $title = preg_replace("/[^a-zA-Z0-9 \-]+/", "", $title);
        $title = str_replace(array("-"), " ", $title);
        return trim(strtolower($title));
    }
    
    /**
     * Create URL valid word.
     * @param string $title
     * @return string
     */
    public static function createURLValid($title) {
        $title = self::createSearchWord($title);
        $title = str_replace(" ", "_", $title);
        return trim(strtolower($title));
    }
    
    /**
     * Get Serialized fields of post.
     * @param array $postData
     * @param string $field
     * @return string Serialized field.
     */
    public static function getSerializedFields($postData, $field){
        $array = self::getFieldsValues($postData, $field);
        return serialize($array);
    }
    
    /**
     * Get post field trimmed and not empty values.
     * @param array $postData
     * @param string $field
     * @return array field.
     */
    public static function getFieldsValues($postData, $field){
        $array = [];
        if (!empty($postData[$field])) {
            foreach ($postData[$field] as $value) {
                $value = trim($value);
                if (empty($value)) {
                    continue;
                }
                $array[] = $value;
            }
        }
        return $array;
    }
    
    /**
     * simplify string for search.
     * @param string $string
     * @return string
     */
    public static function createSearchString($string) {
        //Leave only a-z A-Z and 0-9
        $string = preg_replace("/[^a-zA-Z0-9 \-]+/", "", $string);
        $string = str_replace(["-"], " ", $string);
        return trim(strtolower($string));
    }

    /**
     * Make sentence to first uppercase style Example: "Aaaa Bbbbb"
     * @param string $name
     * @return string
     */
    public static function modifyNameFirstUpper($name) {
        $nameParts = explode(" ", $name);
        foreach ($nameParts as &$part) {
            $part = ucfirst(strtolower($part));
        }
        return join(" ", $nameParts);
    }
    
    /**
     * 
     * @param float $price
     * @return float
     */
    public static function priceFormat($price){
        return number_format($price, 2, '.', '');
    }
    
    /**
     * Left in string only numbers.
     * @param string $number
     * @return string Only 0-9 string
     */
    public static function toNumber($number){
        //Leave only 0-9
        $number = preg_replace("/[^0-9]+/", "", $number);
        return $number;
    }
    
    /**
     * 
     * @param int $time
     * @return type
     */
    private static function timeCheck($time){
        if (!is_int($time)){
            $time = strtotime($time);
        }
        return $time;
    }
    
    /**
     * Return in date Format "d.m.Y H:i"
     * @param type $time
     * @return string
     */
    public static function dateFormat($time){
        $time = self::timeCheck($time);
        if ($time <= 0) {
            return "";
        }
        return date("d.m.Y", $time);
    }
    
    /**
     * Return in date Format "d.m.Y H:i"
     * @param type $time
     * @return string
     */
    public static function dateTimeFormat($time){
        $time = self::timeCheck($time);
        if ($time <= 0) {
            return "";
        }
        return date("d.m.Y H:i", $time);
    }
    
    /**
     * Get duration string (days, hours, minutes, seconds)
     * @param int $duration Seconds
     */
    public static function getDuration($duration){
        $return = [];
        $days = (int) ($duration / (24*60*60));
        if ($days > 0){
            $return[] = $days." days";
            $duration -= $days * (24*60*60);
        }
        $hours = (int) ($duration / (60*60));
        if ($hours > 0){
            $return[] = $hours." hours";
            $duration -= $hours * (60*60);
        }
        $min = (int) ($duration / (60));
        if ($min > 0){
            $return[] = $min." min";
            $duration -= $min * (60);
        }
        if ($duration > 0){
            $return[] = $duration." sec";
        }
        return join(" ", $return);
    }
    
    /**
     * Meters to distance km and m
     * @param int $meters
     * @return string
     */
    public static function toDistance(int $meters){
        if (empty($meters)){
            return "";
        }
        $km = (int) ($meters / 1000);
        $meters = (int) ($meters - $km*1000);
        $return = [];
        if (!empty($km)) {
            $return[] = $km." km";
        }
        if (!empty($meters)) {
            $return[] = $meters." m";
        }
        return join(" ", $return);
    }
}
