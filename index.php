<?php
include('simple_html_dom.php');
ini_set('memory_limit','200M');

$html = file_get_html("http://www.google.ae/search?q=hello");


//echo $html->find('title',0)->plaintext;


$count = 0;
$positions = array();
$value= array();
$data = array();
$title = array();
$description = array();
$j = 0 ;
$temp = array();
$x = 0;


/*
$item = $html -> find('div[id=main]',0)->childNodes(0);
echo sizeof($item);
*/

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

for($k = 0; $k<= sizeof($temp); $k++)
{

  if($temp[$k] != null AND $temp[$k]->has_child('span[dir=ltr]') AND $temp[$k]->has_child('h3') AND $temp[$k]->has_child('a') AND $k!=0 AND $k!=1 AND $k!=2 AND $k!=3 AND $temp[$k]->firstChild()->firstChild()->firstChild()->nodeName() == 'a')
  {

    echo 'Yessssssss!' . $k . $temp[$k] . '<br>' ;
    //$temp[$k]->dump(true);
  }
}



/*
for ($i = 14; $i <= 1000; $i++ ){
    // echo "".$i. 'count'.$count;
        $item = $html->find('div div div div div' , $i);
       // $value[$i] = $item->plaintext;
        
}  

*/




/*

$list = $html->find('div div div div div' , 14);

echo $list;

*/

/*
$a_list = $list->find('a');

for($i=0;$i<sizeof($a_list);$i++)
{
    echo $a_list[$i];
    echo "<br>";
}
*/
?>