<?php

class AppService
{
    public static function getLocaleDays ()
    {
        $days = [];
        $dayNames =  AppConfig::getConfig('locales', ['dayNames']);
        
        for ($i = 0; $i < 7; $i++) {
            $dayName = date("l", mktime(0, 0, 0, date('m'), date('d') + $i, date('Y')));
            $days[$dayName] = $dayNames[$dayName];
        }
        
        return $days;
    }

    public static function getLocaleWeek ()
    {
        $week = [];
        $startDate = ['d' => 22, 'm' => '04', 'y' => '2019'];
        $dayNames =  AppConfig::getConfig('locales', ['dayNames']);
        
        for ($i = 0; $i < 7; $i++) {
            $dayName = date("l", mktime(0, 0, 0, $startDate['m'], $startDate['d'] + $i, $startDate['y']));
            $dayDate = date("d.m.Y", mktime(0, 0, 0, $startDate['m'], $startDate['d'] + $i, $startDate['y']));
            $week[$dayDate] = $dayNames[$dayName];
        }
        
        return $week;
    }

    public static function getWeekDays ()
    {
        $days = [];
        $dayNr = date("N");

        if ($dayNr === 1) {
            for ($i = 0; $i < 7; $i++) {
                $dayName = date("l", mktime(0, 0, 0, date('m'), date('d') + $i, date('Y')));
                $days[$dayName] = date("d.m.Y", mktime(0, 0, 0, date('m'), date('d') + $i, date('Y')));
            }
        } else {

            $dayDiff = $dayNr -1;
            $dayPlus = 7 - $dayNr;

            for ($i = $dayDiff; $i >= 0; $i--) {
                $dayName = date("l", mktime(0, 0, 0, date('m'), date('d') - $i, date('Y')));
                $days[$dayName] = date("d.m.Y", mktime(0, 0, 0, date('m'), date('d') + (7-$i), date('Y')));
            }
            for ($i = 1; $i <= $dayPlus; $i++) {
                $dayName = date("l", mktime(0, 0, 0, date('m'), date('d') + $i, date('Y')));
                $days[$dayName] = date("d.m.Y", mktime(0, 0, 0, date('m'), date('d') + $i, date('Y')));
            }
        }

        return $days;
    }

    public static function getLocaleMonths ($date = '')
    {
        $monthNames = AppConfig::getConfig('locales', ['monthNames']);

        if ($date !== '') {
            $monthNr = (int) date("n", strtotime($date));
            $monthNames = $monthNames[$monthNr-1];
        }

        return $monthNames;
    }

    /**
     * @method generatePassword 
     * @author Tyler Hall / gist.github.com/tylerhall/521810
     * 
     * -----------------------------------------------------
     *
     * @param integer $length default 12
     * @param boolean $add_dashes default false
     * @param string $available_sets default luds
     * @return string
     * 
     * -----------------------------------------------------
     * 
     * # Description
     * 
     * Generates a strong password of N length containing at least one lower case letter,
     * one uppercase letter, one digit, and one special character. The remaining characters
     * in the password are chosen at random from those four sets.
    
     * The available characters in each set are user friendly - there are no ambiguous
     * characters such as i, l, 1, o, 0, etc. This, coupled with the $add_dashes option,
     * makes it much easier for users to manually type or speak their passwords.
    
     * Note: the $add_dashes option will increase the length of the password by
     * floor(sqrt(N)) characters.
    */

    public static function generatePassword ($length = 12, $add_dashes = false, $available_sets = 'luds')
    {
        $sets = array();
        if(strpos($available_sets, 'l') !== false)
            $sets[] = 'abcdefghjkmnpqrstuvwxyz';
        if(strpos($available_sets, 'u') !== false)
            $sets[] = 'ABCDEFGHJKMNPQRSTUVWXYZ';
        if(strpos($available_sets, 'd') !== false)
            $sets[] = '23456789';
        if(strpos($available_sets, 's') !== false)
            $sets[] = '!@#$%&*?';
    
        $all = '';
        $password = '';

        foreach($sets as $set) {
            $password .= $set[array_rand(str_split($set))];
            $all .= $set;
        }
    
        $all = str_split($all);

        for($i = 0; $i < $length - count($sets); $i++) {
            $password .= $all[array_rand($all)];
        }

        $password = str_shuffle($password);
    
        if(!$add_dashes) {return $password;}
    
        $dash_len = floor(sqrt($length));
        $dash_str = '';
        
        while(strlen($password) > $dash_len) {
            $dash_str .= substr($password, 0, $dash_len) . '-';
            $password = substr($password, $dash_len);
        }

        $dash_str .= $password;
        
        return $dash_str;
    }
}