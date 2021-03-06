<?php


/*
Template Name: Collection
*/
get_header();


?>


<div>


    <main role="main">
        <div class="container">
            <h3>Vyhledávání</h3>
            <div class="help-block">
                <div class="search">
                    <input class="search-field" type="search" name="search" id="search">
                    <button class="search-butt"></button>
                </div>
            </div>
            <h3>Filtrace</h3>
            <div class="flex-block select">
                <div class="help-block">
                    <?php $terms = get_terms("kategorie", array("hide_empty" => true)); ?>
                    <select class="categories" name="categories">
                        <option value="all">Všechny kategorie</option>
                        <?php foreach ($terms as $item) : ?>
                            <option value="<?php echo $item->term_id; ?>"><?php echo $item->name; ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="help-block">
                    <?php $terms = get_terms("rad", array("hide_empty" => true)); ?>
                    <select class="categories" name="rad">
                        <option value="all">Všechny Kontinenty</option>
                        <?php foreach ($terms as $item) : ?>
                            <option value="<?php echo $item->term_id; ?>"><?php echo $item->name; ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>
            <div class="flex-block collection search-collection">


                <?php

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
                endif;

                ?>
                <?php


                ?>
            </div>
        </div>
    </main>



</div>

<?php get_footer(); ?>