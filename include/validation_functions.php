<?php

$error = array();

function fieldName_as_text($fieldName){
    $fieldName = str_replace("_"," ",$fieldName);
    $fieldName = ucfirst($fieldName);
    return $fieldName;
}

function has_presence($value) {
    return isset($value) && $value !== "";
}

function validate_presence($require_fields) {
    global $errors;
    foreach($require_fields as $field) {
        $value = trim($_POST[$field]);
        if(!has_presence($value)) {
            $errors[$field] = fieldName_as_text($field) . "Can't be blank";
        }
    }
}

// * string length
// max length
function has_max_length($value, $max) {
    return strlen($value) <= $max;
}

function validate_max_lengths($fields_with_max_lengths) {
    global $errors;
    // Expects an assoc. array
    foreach($fields_with_max_lengths as $field => $max) {
        $value = trim($_POST[$field]);
        if (!has_max_length($value, $max)) {
            $errors[$field] = fieldName_as_text($field) . " is too long";
        }
    }
}

// * inclusion in a set
function has_inclusion_in($value, $set) {
    return in_array($value, $set);
}

function form_errors($errors=array()) {
    $output = "";
    if (!empty($errors)) {
        $output .= "<div class=\"error\">";
        $output .= "Please fix the following errors:";
        $output .= "<ul>";
        foreach ($errors as $key => $error) {
            $output .= "<li>{$error}</li>";
        }
        $output .= "</ul>";
        $output .= "</div>";
    }
    return $output;
}

?>