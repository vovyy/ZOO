<?php
// funkce, která má za úkol custom-post-type (nahrává data do customfields aby se mohli zobrazit na single zvíře)
// pole, kde se dávají titulky pro custom-post-type
function cpt_animal()
{
    $labels = array(
        'name' => _x('Zvířata', 'post type general name', 'your-plugin-textdomain'),
        'singular_name' => _x('Zvířata', 'post type singular name', 'your-plugin-textdomain'),
        'edit_item' => __('Upravit zvíře', 'your-plugin-textdomain'),
        'view_item' => __('Zobrazit zvíře', 'your-plugin-textdomain'),
        'all_items' => __('Všechny produkty', 'your-plugin-textdomain'),
        'search_items' => __('Vyhledat produkty', 'your-plugin-textdomain'),
        'parent_item_colon' => __('Superior:', 'your-plugin-textdomain'),
        'not_found' => __('Produkt nebyl nalezen.', 'your-plugin-textdomain'),
        'not_found_in_trash' => __('Produkt byl nazelezen v koši.', 'your-plugin-textdomain')
    );

    $args = array(
        'labels' => $labels,
        'public' => true, //příspěvky veřejné
        'publicly_queryable' => true,
        'show_ui' => true, //zobrazí se v menu
        'show_in_menu' => true,
        'query_var' => true,
        'rewrite' => array('slug' => 'zvire'), //url slug cutom příspěvků
        'capability_type' => 'post',
        'has_archive' => true,
        'hierarchical' => false, //možnost řadit podsebe
        'menu_position' => null,
        'supports' => array('title', "page-attributes", "post-formats", "thumbnail", "excerpt"),
        "show_in_rest" => true
    );
    register_post_type('zvire', $args);
}

add_action('init', 'cpt_animal', 0);

//taxonomie, něco jako kategorie 
function codex_taxonomy_product()
{
    $labels = array(
        'name'              => _x('Kategorie', 'taxonomy general name', 'textdomain'),
        'singular_name'     => _x('Kategorie', 'taxonomy singular name', 'textdomain'),
        'search_items'      => __('Vyhledat kategorie', 'textdomain'),
        'all_items'         => __('Všechny kategorie', 'textdomain'),
        'parent_item'       => __('Kategorie', 'textdomain'),
        'parent_item_colon' => __('Kategorie:', 'textdomain'),
        'edit_item'         => __('Upravit kategorii', 'textdomain'),
        'update_item'       => __('Aktualizovat kategorii', 'textdomain'),
        'add_new_item'      => __('Přidat kategorii', 'textdomain'),
        'new_item_name'     => __('Nová kategorie', 'textdomain'),
        'menu_name'         => __('Kategorie', 'textdomain'),
    );

    $args = array(
        'hierarchical'      => true,
        'labels'            => $labels,
        'show_ui'           => true,
        'show_admin_column' => true,
        'query_var'         => true,
        'rewrite'           => array('slug' => 'kategorie'),
    );

    register_taxonomy('kategorie', array('zvire'), $args);
}
add_action('init', 'codex_taxonomy_product', 0);

function codex_taxonomy_continent()
{
    $labels = array(
        'name'              => _x('Řád', 'taxonomy general name', 'textdomain'),
        'singular_name'     => _x('Řád', 'taxonomy singular name', 'textdomain'),
        'search_items'      => __('Vyhledat Řád', 'textdomain'),
        'all_items'         => __('Všechny Řád', 'textdomain'),
        'parent_item'       => __('Řád', 'textdomain'),
        'parent_item_colon' => __('Řád:', 'textdomain'),
        'edit_item'         => __('Upravit Řád', 'textdomain'),
        'update_item'       => __('Aktualizovat Řád', 'textdomain'),
        'add_new_item'      => __('Přidat Řád', 'textdomain'),
        'new_item_name'     => __('Nová Řád', 'textdomain'),
        'menu_name'         => __('Řád', 'textdomain'),
    );

    $args = array(
        'hierarchical'      => true,
        'labels'            => $labels,
        'show_ui'           => true,
        'show_admin_column' => true,
        'query_var'         => true,
        'rewrite'           => array('slug' => 'rad'),
    );

    register_taxonomy('rad', array('zvire'), $args);
}
add_action('init', 'codex_taxonomy_continent', 0);

//metoda pro zkontrolování, jestli kategorie existuje ve wordpressu
function getCategoryByName($nameCategory, $name)
{
    if ($nameCategory != "") :
        $term = get_term_by("name", $nameCategory, $name);
        return $term;
    else :
        return false;
    endif;
}

//získání get/post parametru
function getFilter($type, $name)
{
    return htmlspecialchars(strip_tags(filter_input($type, $name)));
}
