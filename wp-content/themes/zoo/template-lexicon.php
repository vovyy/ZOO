<?php


/*
Template Name: Lexicon
*/
get_header();

//pro postupný import dat
$iteration = (int) getFilter(INPUT_GET, "iteration");
?>

<?php
//metoda, která zkontroluje na základě id z API, jestli post se stejným id existuje ve wordpressu
function checkPost($id)
{
    global $post;
    $arg = array(
        "post_type" => "zvire",
        "post_status" => "publish",
        "posts_per_page" => -1
    );
    $id_check = (int) $id;
    $check = 0;
    $query = new WP_Query($arg); //vytvoření query
    if ($query->have_posts()) :
        while ($query->have_posts()) : $query->the_post();
            $id_post = (int) get_field("id", $post->ID);
            if ($id_post === $id_check) :
                $check = $post->ID;
            endif;
        endwhile;
        wp_reset_query();
        return $check;
    else :
        return false;
    endif;
}
$curl = curl_init(); //pošle request s požadavkem na API
$headers = array(
    'Accept: application/json',
    'Content-Type: application/json',
);

curl_setopt($curl, CURLOPT_URL, "https://opendata.praha.eu/api/3/action/datastore_search?sort=title&resource_id=90f7250f-ead7-49c5-90de-92d3109c3d02&limit=100000000");

curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
curl_setopt($curl, CURLOPT_HEADER, 0);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
$response = curl_exec($curl);
$code = curl_getinfo($curl, CURLINFO_RESPONSE_CODE);
curl_close($curl);
$devices = json_decode($response);
$record = [];

foreach ($devices as $item) :
    if (is_array($item->records) && !is_bool($item->records) && $item->records !== "") : //podmínka, jestli se jedná o array
        $record = $item->records;
    endif;
endforeach;
echo "</br>";
echo "</br>";
echo "</br>";


//if ($iteration) :
$iteration = (int) $iteration; //pro postupný import dat
$permalink = get_the_permalink();
if (strpos($permalink, "?") !== false) :
    $symbol = "&";
else :
    $symbol = "?";
endif;
echo "<a class='next-step' href='" . $permalink . $symbol . "iteration=" . ($iteration + 1) . "'></a>"; //vezme url z itteration a přičte jedničku

$firstCase = array();
$categories = array();
$continent = array();
//$id = array();
$it = 0;
foreach ($record as $mainkey => $item) : //main key, klíč pole z foreach
    var_dump($mainkey);
    if ($mainkey >= $iteration && $mainkey < ($iteration + 1)) :
        $title = "";
        $class = $item->classes;
        $cont = $item->continents;
        //select
        /* Kontinent pro WP */
        if (empty($continent)) :
            array_push($continent, $cont);
        else :
            if (!in_array($cont, $continent)) :
                array_push($continent, $cont);
            endif;
        endif;

        /* Kategorie pro WP */
        if (empty($categories)) :
            array_push($categories, $class);
        else :
            if (!in_array($class, $categories)) :
                array_push($categories, $class);
            endif;
        endif;

        //převede kódování znaků z ASCII na UTF-8
        if (mb_detect_encoding($item->title) == "ASCII") :
            $title = iconv("ASCII", "UTF-8", $item->title);
        else :
            $title = $item->title;
        endif;
        if ($item->image_src == "''") :
            $item->image_src = "https://g.denik.cz/104/66/rtx2xoox.jpg";
        else :
        endif;
        $titleChar = strtoupper(mb_str_split($title)[0]);
        if (empty($firstCase)) :
            array_push($firstCase, $titleChar);
        else :
            if (!in_array($titleChar, $firstCase)) :
                array_push($firstCase, $titleChar);
            endif;
        endif;

        $id = $item->_id;

        //echo "</br>";
        //echo "</br>";
        //echo "</br>";

        //zkontroluje, jestli již daný záznam existuje a pokud ano, tak jej updatuje
        $checkPost = checkPost($id);

        if ($checkPost != 0 || $checkPost != false) :
            if ($item->classes) :
                wp_set_post_terms($checkPost, array(getCategoryByName($item->classes, "kategorie")->term_id), "kategorie");
            endif;
            if ($item->continents) :
                wp_set_post_terms($checkPost, array(getCategoryByName($item->continents, "rad")->term_id), "rad");
            endif;
            update_post_meta($checkPost, "id", $item->_id);
            update_post_meta($checkPost, "latin_title", $item->latin_title);
            update_post_meta($checkPost, "trida", $item->classes);
            update_post_meta($checkPost, "vyhledavani", $item->title);
            update_post_meta($checkPost, "skupina", $item->order);
            update_post_meta($checkPost, "popisek", $item->description);
            update_post_meta($checkPost, "obrazek", $item->image_src);
            update_post_meta($checkPost, "obrazek_popis", $item->image_alt);
            update_post_meta($checkPost, "kontinent", $item->continents);
            update_post_meta($checkPost, "kontinent-detail", $item->spread_note);
            update_post_meta($checkPost, "biotop", $item->biotop);
            update_post_meta($checkPost, "biotop-detail", $item->biotopes_note);
            update_post_meta($checkPost, "potrava", $item->food);
            update_post_meta($checkPost, "potrava-detail", $item->food_note);
            update_post_meta($checkPost, "miry", $item->proportions);
            update_post_meta($checkPost, "rozmnozovani", $item->reproduction);
            update_post_meta($checkPost, "zajimavosti", $item->attractions);
            update_post_meta($checkPost, "chov", $item->breeding);
            update_post_meta($checkPost, "expozice", $item->localities_title);
            update_post_meta($checkPost, "expozice-odkaz", $item->localities_url);
        else :
            // pokud ne, tak jej vytvoří
            $postArray = array(
                "post_type" => "zvire",
                "post_status" => "publish",
                "post_title" => $title
            );
            $new_post = wp_insert_post($postArray);

            if ($new_post) :
                if ($item->classes) :
                    wp_set_post_terms($new_post, array(getCategoryByName($item->classes, "kategorie")->term_id), "kategorie");
                endif;
                if ($item->continents) :
                    wp_set_post_terms($new_post, array(getCategoryByName($item->continents, "rad")->term_id), "rad");
                endif;
                update_post_meta($new_post, "id", $item->_id);
                update_post_meta($new_post, "latin_title", $item->latin_title);
                update_post_meta($new_post, "trida", $item->classes);
                update_post_meta($new_post, "vyhledavani", $item->title);
                update_post_meta($new_post, "skupina", $item->order);
                update_post_meta($new_post, "popisek", $item->description);
                update_post_meta($new_post, "obrazek", $item->image_src);
                update_post_meta($new_post, "obrazek_popis", $item->image_alt);
                update_post_meta($new_post, "kontinent", $item->continents);
                update_post_meta($new_post, "kontinent-detail", $item->spread_note);
                update_post_meta($new_post, "biotop", $item->biotop);
                update_post_meta($new_post, "biotop-detail", $item->biotopes_note);
                update_post_meta($new_post, "potrava", $item->food);
                update_post_meta($new_post, "potrava-detail", $item->food_note);
                update_post_meta($new_post, "miry", $item->proportions);
                update_post_meta($new_post, "rozmnozovani", $item->reproduction);
                update_post_meta($new_post, "zajimavosti", $item->attractions);
                update_post_meta($new_post, "chov", $item->breeding);
                update_post_meta($new_post, "expozice", $item->localities_title);
                update_post_meta($new_post, "expozice-odkaz", $item->localities_url);
            endif;
        endif;
?>
        //sekundu po načtení vezmen novou url s itteration +1 dokud nejsou všechny příspěvky načteny
        <script>
            jQuery(document).ready(function($) {
                setTimeout(function() {
                    var href = jQuery(".next-step").attr("href");
                    window.location.href = href;
                }, 1000);
            });
        </script>

<?php
    endif;
endforeach;


?>



<?php get_footer(); ?>