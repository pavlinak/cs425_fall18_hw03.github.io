<?php
class nicknames
{
    static $savednicknames_file = "nicknames.txt";
    static function saveNickname($nickname, $score)
    {
        $nicknames = nicknames::getNicknames();
        if ($nicknames === false) {
            $myfile = fopen(nicknames::$savednicknames_file, "w") or die("Unable to open file!");
            $msg = $nickname . ": " . $score . "\n";
        } else {
            $nicknames_array = explode(PHP_EOL, $nicknames);
            array_push($nicknames_array, $nickname . ": " . $score);
            usort($nicknames_array, "strnatcmp");
            $myfile = fopen(nicknames::$savednicknames_file, "w") or die("Unable to open file!");
            $msg = "";
            for ($i = 0; $i < count($nicknames_array); $i++) {
                if (($nicknames_array[$i] != "") && ($nicknames_array[$i] != "\n"))
                    $msg .= $nicknames_array[$i] . "\n";
            }
        }
        $fwrite = fwrite($myfile, $msg);
        fclose($myfile);
        if ($fwrite === false)
            return false;
        else
            return true;
    }
    static function getNicknames()
    {
        $nicknames = file_get_contents(nicknames::$savednicknames_file);
        return $nicknames;
    }
}