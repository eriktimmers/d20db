<?php

class Application_Model_Util
{

    public static function PlusMin($content, $element, array $options=array()) {
        return '<img class="' . $options['minclass'] . '" alt="-" src="/img/icon/minus.png">' .
               '<img class="' . $options['plusclass'] . '" alt="+" src="/img/icon/plus.png">';
    }
    
    public static function SqlForCopy($table, $idField, $aColumns)
    {
        $sSql = "INSERT INTO `" . $table . "` ".
                "SELECT " . implode(', ', $aColumns) . " " .
                  "FROM `" . $table . "` " .
                 "WHERE `" . $idField . "` = ?";
        return $sSql;       
    }
    
}