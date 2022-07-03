<?php

/*** Including Simple HTML DOM Library that will help us to parse the HTML elements from Google page, and to send the HTTP request to Google with a specific keyword */
include('simple_html_dom.php');



$html = file_get_html("http://www.google.ae/search?q=hello");


$ranking = array();
$url = array();
$title = array();
$description = array();
$promoted = array();

$temp = array();
$x = 0;
$j = 0 ;


/**Below is a Foreach loop to iterate over the HTML results and eliminate the Styles elements */

foreach($html->find('<style>') as $style_element){
  $style_element->remove();
}



for($i=0;$i<=50;$i++)
{
  $item = $html -> find('div[id=main]',0)->childNodes($i);
  
  if($item != null AND $item->has_child('span[dir="ltr"]') AND $item->has_child('h3') AND $item->has_child('a'))
  {

    echo 'Yes!' . $i . '<br>';  
    $temp[$x] = $item;
    $x++;
  }
  else
  {
    echo 'no' . $i . '<br>';
  }
  //echo 'Child Number: '. $i . '<b>' . $item . '<br>';
}

echo '***************************************************************************' . '<br>';

$k2 = 0;
$clean_res = array();

for($k = 0; $k<= sizeof($temp); $k++)
{

  if($temp[$k] != null AND $temp[$k]->has_child('span[dir=ltr]') AND $temp[$k]->has_child('h3') AND $temp[$k]->has_child('a') AND $k!=0 AND $k!=1 AND $k!=2 AND $k!=3 AND $temp[$k]->firstChild()->firstChild()->firstChild()->nodeName() == 'a')
  {
    $clean_res[$k2] = $temp[$k];
    echo 'Yessssssss!' . $k . $temp[$k] . '<br>' ;
    $k2++;
    //$temp[$k]->dump(true);
  }
}

array_walk($temp, function($v,$k) use ($obj) {
    if(empty($v)) unset($temp->$k);
});

echo '***************************************************************************' . '<br>';


for($k3=0;$k3<=sizeof($clean_res);$k3++)
{
  if($clean_res[0]->has_child('div'));
  
}


?>