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
            $result[$v["pname"]]["catagory"] = $v["catagory"];
        } else {
            $result[$v["pname"]]["quantity"] .= "," . $v["quantity"];
            $result[$v["pname"]]["uprice"] = $v["uprice"];
            $result[$v["pname"]]["catagory"] = $v["catagory"];
        }
    }

    $result = array_values($result);
    return $result;
}


function cat_array($arr) {
    $result = [];
    foreach($arr as $v) {
        if(!isset($result[$v["catagory"]])) {
            $result[$v["catagory"]]["catagory"] = $v["catagory"];
            $result[$v["catagory"]]["product"] = $v["product"];
            $result[$v["catagory"]]["uprice"] = $v["uprice"];
            $result[$v["catagory"]]["quantity"] = $v["quantity"];
            $result[$v["catagory"]]["discount"] = $v["discount"];
            $result[$v["catagory"]]["tprice"] = $v["tprice"];
        } else {
            $result[$v["catagory"]]["discount"] .= "," . $v["discount"];
            $result[$v["catagory"]]["product"] .= "," . $v["product"];
            $result[$v["catagory"]]["uprice"] .= "," . $v["uprice"];
            $result[$v["catagory"]]["quantity"] .= "," . $v["quantity"];
            
            $result[$v["catagory"]]["tprice"] .= "," . $v["tprice"];
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




function csvstring_to_array($string, $separatorChar = ',', $enclosureChar = '"', $newlineChar = "\n") {
    // @author: Klemen Nagode
    $array = array();
    $size = strlen($string);
    $columnIndex = 0;
    $rowIndex = 0;
    $fieldValue="";
    $isEnclosured = false;
    for($i=0; $i<$size;$i++) {

        $char = $string{$i};
        $addChar = "";

        if($isEnclosured) {
            if($char==$enclosureChar) {

                if($i+1<$size && $string{$i+1}==$enclosureChar){
                    // escaped char
                    $addChar=$char;
                    $i++; // dont check next char
                }else{
                    $isEnclosured = false;
                }
            }else {
                $addChar=$char;
            }
        }else {
            if($char==$enclosureChar) {
                $isEnclosured = true;
            }else {

                if($char==$separatorChar) {

                    $array[$rowIndex][$columnIndex] = $fieldValue;
                    $fieldValue="";

                    $columnIndex++;
                }elseif($char==$newlineChar) {
                    echo $char;
                    $array[$rowIndex][$columnIndex] = $fieldValue;
                    $fieldValue="";
                    $columnIndex=0;
                    $rowIndex++;
                }else {
                    $addChar=$char;
                }
            }
        }
        if($addChar!=""){
            $fieldValue.=$addChar;

        }
    }

    if($fieldValue) { // save last field
        $array[$rowIndex][$columnIndex] = $fieldValue;
    }
    return $array;
}




