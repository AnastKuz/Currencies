<?php

  $today = date("d/m/Y"); // today's date
  $linkToday = "http://www.cbr.ru/scripts/XML_daily.asp?date_req=$today"; // link to XML file with currencies
  $content = file_get_contents($linkToday); // content to string
  $dom = new domDocument("1.0", "cp1251"); // making DOM
  $dom->loadXML($content); // downloading XML file into DOM
  $root = $dom->documentElement; // root element
  $childs = $root->childNodes; // list of child's elements
  $dataToday = array();
  // searching for currencies and addig them into an array
  for ($i = 0; $i < $childs->length; $i++) {
    $childs_new = $childs->item($i)->childNodes;
    for ($j = 0; $j < $childs_new->length; $j++) {
      $el = $childs_new->item($j);
      $code = $el->nodeValue;
      if (($code == "USD") || ($code == "EUR")) $dataToday[] = $childs_new;
    }
  }
  // looking through an array and showing currencies
  for ($i = 0; $i < count($dataToday); $i++) {
    $list = $dataToday[$i];
    for ($j = 0; $j < $list->length; $j++) {
      $el = $list->item($j);
      if ($el->nodeName == "Name") echo $el->nodeValue." - ";
      elseif ($el->nodeName == "Value") echo $el->nodeValue." рублей<br />";
    }
  }
  
?>