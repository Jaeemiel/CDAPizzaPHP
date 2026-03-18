<?php


function escape(?string $value){
    return htmlspecialchars($value, ENT_QUOTES, "UTF-8");
}

