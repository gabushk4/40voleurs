<?php 
    function ValeurCorrecte($val, $borneMin, $borneMax){
        if($val !== null && ($val >= $borneMin && $val <= $borneMax))
            return true;
        return false;
    }