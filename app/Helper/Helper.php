<?php


function unique_multidim_array($array, $key) {
    $temp_array = array();
    $i = 0;
    $key_array = array();
   
    foreach($array as $val) {
        if (in_array($val[$key], $key_array)) {
            $key_array[$i] = $val[$key];
            $temp_array[$i] = $val;
        }
        $i++;
    }
    return $temp_array;
}
function unique_array($arr) {
    $result = [];
    foreach($arr as $v) {
        if(!isset($result[$v["pname"]])) {
            $result[$v["pname"]]["pname"] = $v["pname"];
            $result[$v["pname"]]["quantity"] = $v["quantity"];
            $result[$v["pname"]]["uprice"] = $v["uprice"];
        } else {
            $result[$v["pname"]]["quantity"] .= "," . $v["quantity"];
            $result[$v["pname"]]["uprice"] = $v["uprice"];
        }
    }

    $result = array_values($result);
    return $result;
}
function revenue_array($arr) {
    $result = [];
    foreach($arr as $v) {
        if(!isset($result[$v["branch"]])) {
            $result[$v["branch"]]["branch"] = $v["branch"];
            $result[$v["branch"]]["tprice"] = $v["tprice"];
        } else {
            $result[$v["branch"]]["tprice"] .= "," . $v["tprice"];
        }
    }

    $result = array_values($result);
    return $result;
}




