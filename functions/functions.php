<?php

function has_only_spaces($string) {
  $array = str_split($string);
  $spaces = 0;

  for ($i = 0; $i < sizeof($array); $i++) {
    if ($array[$i] == ' ') {
      $spaces++;
    }
  }

  if ($spaces === sizeof($array)) {
    return true;
  }
  return false;
}

?>