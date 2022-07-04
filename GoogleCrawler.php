<?php

namespace GoogleCrawler;

/*** Including Simple HTML DOM Library that will help us to parse the HTML elements from Google page, and to send the HTTP request to Google with a specific keyword */
include 'simple_html_dom.php';

class GoogleCrawler
{

    /*** Defining the needed variables and arrays */
    public $html = null;
    public $keyword = 'amazon';

    public $ranking = [];
    public $url = [];
    public $title = [];
    public $description = [];
    public $promoted = [];

    public $temp = [];
    public $x = 0;
    public $j = 0;

    public $k2 = 0;
    public $clean_res = [];

    /*** A simple function to make the HTTP request to Google.ae with the disered keyword */
    function call_page($keyword)
    {
        $html = file_get_html("http://www.google.ae/search?q=$keyword&lr=en");
    }


    /**Below is a function with a foreach loop to iterate over the HTML results and eliminate the Styles elements */
    function remove_styles($html)
    {
        foreach ($html->find('<style>') as $style_element) {
            $style_element->remove();
        }
    }

    /** The first phase of filtering, getting the needed HTML componenets and saving them in a temporary array */
    function phase_one_filtering($html)
    {
        for ($i = 0; $i <= 50; $i++) {
            $item = $html->find('div[id=main]', 0)->childNodes($i);

            if (
                $item != null and
                $item->has_child('span') and
                $item->has_child('h3') and
                $item->has_child('a') and
                $item->has_child('div')
            ) {
                echo 'Yes!' . $i . '<br>';
                $temp[$x] = $item;
                $x++;
            } else {
                echo 'no' . $i . '<br>';
            }
            //echo 'Child Number: '. $i . '<b>' . $item . '<br>';
        }

        echo '***************************************************************************' .
            '<br>';
    }

    /** A function to iterate over our temporary array and removing the null objects */
    function remove_nulls($temp)
    {
        array_walk($temp, function ($v, $k) use ($obj) {
            if (empty($v)) {
                unset($temp->$k);
            }
        });
    }

    /** Phase two of filtering, a complex condition needed to get only the needed elements and saving them in the clean results array */
    function phase_two_filtering($temp)
    {
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
                echo 'Yessssssss!' . $k . $temp[$k] . '<br>';
                $k2++;
                //$temp[$k]->dump(true);
            }
        }

        echo '***************************************************************************' .
            '<br>';

        //echo '<br>size of clean array: ' . sizeof($clean_res) . '<br>';
    }


    /** This function will iterate over our clean results array and puts the results in the suitable arrays */
    function assign_results($clean_res)
    {
        for ($k3 = 0; $k3 < sizeof($clean_res); $k3++) {
            $ranking[$k3] = $k3;
            $url[$k3] = $clean_res[$k3]->find('a', 0)->href;
            $title[$k3] = $clean_res[$k3]->find('span', 0)->plaintext;
            $description[$k3] = $clean_res[$k3]->find(
                'span[dir=ltr]',
                2
            )->plaintext;
        }
    }

    /**A simple function to iterate over the URLs array and remove the unnecessary parts from the links */
    function clean_urls($url)
    {
        for ($k4 = 0; $k4 < sizeof($url); $k4++) {
            $url[$k4] = str_replace('/url?q=', '', $url[$k4]);
            echo $url[$k4] . '<br>';
        }

        echo '***************************************************************************' .
            '<br>';
    }


    /**This function will print the first result */
    function print_first_object()
    {
        echo 'First Object: <br>';
        for ($k5 = 0; $k5 < 1; $k5++) {
            echo $ranking[$k5] .
                '<br>' .
                $url[$k5] .
                '<br>' .
                $title[$k5] .
                '<br>' .
                $description[$k5];
        }
    }
}
?>
