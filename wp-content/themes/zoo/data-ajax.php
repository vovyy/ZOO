<?php

/*
Není potřeba, ale jedná se o zabezpečení search baru, proti tomu aby někdo mohl vložit nějaký kód a mohl taknapadnout stránku
jednoduchý zápis bez ošetření vstupu:$_GET["searchValue"]
*/
$searchValue = htmlspecialchars(strip_tags(filter_input(INPUT_GET, "searchValue"))) !== "" ? htmlspecialchars(strip_tags(filter_input(INPUT_GET, "searchValue"))) : null;
/* 
pokud se hodnota proměnné search value není rovná nule, tak se provede:
vytvoří se pole pro wp-query
*/
if ($searchValue !== null) :
    $arg = array(
        "post_type" => "zvire",
        "posts_per_page" => -1, //všechny
        "order" => "ASC",
        "orderby" => "title",
        "post_status" => "publish", //draft //private
        "s" => $searchValue, //"s" je parametr pro vyhledávání defaultní
        "meta_query" => array( //pomocné pole, pro vyhledávání pomocí metahodnot v příspěvcích
            "relation" => "OR",
            array(
                "key" => "kontinent", //pokud napíšu celé, nebo jen část názvu kontinentu, tak mi to již vypíše příspěvky, které jsou adekvátní
                "value" => $searchValue,
                "compare" => "LIKE"
            ),
            array(
                "key" => "vyhledavani",
                "value" => $searchValue,
                "compare" => "LIKE"
            )
        )
    );
    $query = new WP_Query($arg); //inicializace (vytvoření) wp-query (objektu podle pole) 
    if ($query->have_posts()) : // have_post je metoda pro zjištění, jestli našla query nějaké příspěvky
        while ($query->have_posts()) : $query->the_post(); //pokud ano, tak vyhledává dokud nějaké má
?>
            <a href="<?= get_the_permalink() ?>" class="card">
                <!--get_permalink metoda pro zjištění odkazu na daný příspěvek-->
                <div class="picture" style="background-image: url('<?php echo get_field("obrazek", $post->ID); ?>');">
                </div>
                <h2><?php echo get_the_title($post->ID); ?></h2>
            </a>
        <?php
        endwhile;
        wp_reset_query(); //resetuje nastavení query, kvůli správnému načítání stránky
    else :
        echo "<p style='color:white;font-size:8rem;width:1300px;text-align:center;position:absolute;left:50%;transform:translateX(-50%);'>
        Litujeme, ale váš text neodpovídá žádnému příspěvku. Zkuste to prosím ještě jednou a lépe... </p>";

    endif;
    die();
else :
    echo "";
endif;


$categoriesValue = htmlspecialchars(strip_tags(filter_input(INPUT_GET, "categoriesValue"))) !== "" ? htmlspecialchars(strip_tags(filter_input(INPUT_GET, "categoriesValue"))) : null;
//vyhledání příspěvku podle kategorie
if ($categoriesValue !== null) :
    $arg = array(
        "post_type" => "zvire",
        "posts_per_page" => -1,
        "order" => "ASC",
        "orderby" => "title",
        "post_status" => "publish",
    );
    if ($categoriesValue !== "all") :
        $arg["tax_query"] = array(
            "relation" => "OR",
            array(
                "taxonomy" => "kategorie",
                "field" => "term_id",
                "terms" => array((int)$categoriesValue)
            ),
        );
    endif;
    $query = new WP_Query($arg);
    if ($query->have_posts()) :
        while ($query->have_posts()) : $query->the_post();
        ?>
            <a href="<?= get_the_permalink() ?>" class="card">
                <div class="picture" style="background-image: url('<?php echo get_field("obrazek", $post->ID); ?>');">
                </div>
                <h2><?php echo get_the_title($post->ID); ?></h2>
            </a>
        <?php
        endwhile;
        wp_reset_query();
    else :
        echo "<p style='color:white;font-size:8rem;width:1300px;text-align:center;position:absolute;left:50%;transform:translateX(-50%);'>
        Litujeme, ale váš text neodpovídá žádnému příspěvku. Zkuste to prosím ještě jednou a lépe... </p>";

    endif;
    die();
else :
    echo "";
endif;


$radValue = htmlspecialchars(strip_tags(filter_input(INPUT_GET, "radValue"))) !== "" ? htmlspecialchars(strip_tags(filter_input(INPUT_GET, "radValue"))) : null;
//vyhledání řádu pomocí kategorie
if ($radValue !== null) :
    $arg = array(
        "post_type" => "zvire",
        "posts_per_page" => -1,
        "order" => "ASC",
        "orderby" => "title",
        "post_status" => "publish",
    );
    if ($radValue !== "all") :
        $arg["tax_query"] = array(
            "relation" => "OR",
            array(
                "taxonomy" => "rad",
                "field" => "term_id",
                "terms" => array((int)$radValue)
            ),
        );
    endif;
    $query = new WP_Query($arg);
    if ($query->have_posts()) :
        while ($query->have_posts()) : $query->the_post();
        ?>
            <a href="<?= get_the_permalink() ?>" class="card">
                <div class="picture" style="background-image: url('<?php echo get_field("obrazek", $post->ID); ?>');">
                </div>
                <h2><?php echo get_the_title($post->ID); ?></h2>
            </a>
        <?php
        endwhile;
        wp_reset_query();
    else :

        echo "<p style='color:white;font-size:8rem;width:1300px;text-align:center;position:absolute;left:50%;transform:translateX(-50%);'>
        Litujeme, ale váš text neodpovídá žádnému příspěvku. Zkuste to prosím ještě jednou a lépe... </p>";

    endif;
    die();
else :
    echo "";
endif;



$resetPosts = htmlspecialchars(strip_tags(filter_input(INPUT_GET, "resetPosts"))) !== "" ? htmlspecialchars(strip_tags(filter_input(INPUT_GET, "resetPosts"))) : null;
//vyresetuje všechny posty, pokud u nich není žádná hodnota
if ($resetPosts) :
    $arg = array(
        "post_type" => "zvire",
        "posts_per_page" => -1,
        "order" => "ASC",
        "orderby" => "title",
        "post_status" => "publish", //draft //private
    );
    $query = new WP_Query($arg);
    if ($query->have_posts()) :
        while ($query->have_posts()) : $query->the_post();
        ?>
            <a href="<?= get_the_permalink() ?>" class="card">
                <div class="picture" style="background-image: url('<?php echo get_field("obrazek", $post->ID); ?>');">
                </div>
                <h2><?php echo get_the_title($post->ID); ?></h2>
            </a>
<?php
        endwhile;
        wp_reset_query();
    else :
        echo "<p style='color:white;font-size:8rem;width:1300px;text-align:center;position:absolute;left:50%;transform:translateX(-50%);'>
        Litujeme, ale váš text neodpovídá žádnému příspěvku. Zkuste to prosím ještě jednou a lépe... </p>";

    endif;
    die();
else :
    echo "";
endif;
