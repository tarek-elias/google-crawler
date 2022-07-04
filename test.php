<?php

/*** Including Simple HTML DOM Library that will help us to parse the HTML elements from Google page, and to send the HTTP request to Google with a specific keyword */
include 'simple_html_dom.php';

$html = file_get_html('http://www.google.ae/search?q=amazon&lr=en');

$ranking = [];
$url = [];
$title = [];
$description = [];
$promoted = [];

$temp = [];
$x = 0;
$j = 0;

/**Below is a Foreach loop to iterate over the HTML results and eliminate the Styles elements */

foreach ($html->find('<style>') as $style_element) {
    $style_element->remove();
}

for ($i = 0; $i <= 50; $i++) {
    $item = $html->find('div[id=main]', 0)->childNodes($i);

    if (
        $item != null and
        $item->has_child('span') and
        $item->has_child('h3') and
        $item->has_child('a') and
        $item->has_child('div')
    ) {
        //echo 'Yes!' . $i . '<br>';
        $temp[$x] = $item;
        $x++;
    } else {
        //echo 'no' . $i . '<br>';
    }
    //echo 'Child Number: '. $i . '<b>' . $item . '<br>';
}

//echo '***************************************************************************' . '<br>';

$k2 = 0;
$clean_res = [];

array_walk($temp, function ($v, $k) use ($obj) {
    if (empty($v)) {
        unset($temp->$k);
    }
});

for ($k = 0; $k < sizeof($temp); $k++) {
    if (
        $temp[$k] != null and
        $temp[$k]->has_child('span') and
        $temp[$k]->has_child('h3') and
        $temp[$k]->has_child('a') and
        $temp[$k]->has_child('div') and
        $temp[$k]->firstChild() != null and
        $temp[$k]->firstChild()->firstChild() != null and
        $temp[$k]
            ->firstChild()
            ->firstChild()
            ->firstChild() !=
            null and
        $temp[$k]
            ->firstChild()
            ->firstChild()
            ->firstChild()
            ->nodeName() ==
            'a'
    ) {
        $clean_res[$k2] = $temp[$k];
        //echo 'Yessssssss!' . $k . $temp[$k] . '<br>' ;
        $k2++;
        //$temp[$k]->dump(true);
    }
}

//echo '***************************************************************************' . '<br>';

//echo '<br>size of clean array: '. sizeof($clean_res). '<br>';

for ($k3 = 0; $k3 < sizeof($clean_res); $k3++) {
    $ranking[$k3] = $k3;
    $url[$k3] = $clean_res[$k3]->find('a', 0)->href;
    $title[$k3] = $clean_res[$k3]->find('span', 0)->plaintext;
    $description[$k3] = $clean_res[$k3]->find('span[dir=ltr]', 2)->plaintext;
    if ($clean_res[$k3]->find('div[id=raw]', 0) != null) {
        $promoted[$k3] = true;
    } else {
        $promoted[$k3] = false;
    }
}

for ($k4 = 0; $k4 < sizeof($url); $k4++) {
    $url[$k4] = str_replace('/url?q=', '', $url[$k4]);
    //echo $url[$k4]. '<br>';
}

echo '***************************************************************************' .
    '<br>';



    echo "Object with order 0: <br>";
    echo $ranking[0] .
        '<br>' .
        $url[0] .
        '<br>' .
        $title[0] .
        '<br>' .
        $description[0] .
        '<br>' .
        $promoted[0];


?>
