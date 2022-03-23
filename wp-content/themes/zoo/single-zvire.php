<?php


/*
Template Name: Zvire
*/
get_header();

$id = get_queried_object_id();
$IDpost = $id;
?>

<main role="main">
    <div class="flex-block single">

        <section class="title">
            <div class="container">
                <div class="flex-block">

                    <h1 class="animal_title"><?php echo get_the_title($post->ID); ?> (<i><?php echo get_field("latin_title", $post->ID); ?></i>)</h1>
                </div>
            </div>
        </section>
        <section class="under_title">
            <div class="container">
                <div class="flex-block">
                    <div class="left">
                        <?php $popis = get_field("popisek", $post->ID); ?>
                        <?php $text = ""; ?>
                        <?php strlen($popis) > 221 ? $text = substr($popis, 0, 221) . "..." : $text = $popis; ?>
                        <p>
                            <?php
                            $textZ = iconv("ASCII", "UTF-8", $text);
                            echo $text; ?>
                            <?php if (strlen($popis) > 221) : ?>
                                <br>
                                <a href="" data-target="#openmodal-popis<?php echo $post->ID; ?>" class="more open-modal" style="text-decoration:underline;">Více zde</a>
                            <?php endif; ?>
                        </p>
                    </div>
                    <div class="right">
                        <div class="image">
                            <img src="<?php echo get_field("obrazek", $post->ID); ?>" alt="">
                        </div>
                    </div>
                </div>
            </div>

        </section>
        <div class="modal" id="openmodal-popis<?php echo $post->ID; ?>">
            <div class="exit">
                <div class="cross"></div>
            </div>
            <div class="modal-container">
                <p><?php echo $popis; ?></p>
            </div>
        </div>
        <div class="filter-back"></div>

        <section class="table_section">
            <div class="container">
                <div class="flex-block">
                    <table class="table_animal">
                        <tr>
                            <th>Třída</th>
                            <td><?php echo get_field("trida", $post->ID); ?></td>
                        </tr>
                        <tr>
                            <th>Řád</th>
                            <td><?php echo get_field("skupina", $post->ID); ?></td>
                        </tr>
                        <tr>
                            <th>Rozšíření</th>
                            <td><?php echo get_field("kontinent", $post->ID); ?>(<?php echo get_field("kontinent-detail", $post->ID); ?>)</td>
                        </tr>
                        <tr>
                            <th>Biotop</th>
                            <td><?php echo get_field("biotop", $post->ID); ?></td>
                        </tr>
                        <tr>
                            <th>Potrava</th>
                            <td><?php echo get_field("potrava", $post->ID); ?>(<?php echo get_field("potrava-detail", $post->ID); ?>)</td>
                        </tr>
                        <tr>
                            <th>Rozměry</th>
                            <td><?php echo get_field("miry", $post->ID); ?></td>
                        </tr>
                        <tr>
                            <th>Rozmnožování</th>
                            <td><?php echo get_field("rozmnozovani", $post->ID); ?></td>
                        </tr>
                    </table>
                </div>
            </div>
        </section>
        <section class="under_cards_section">
            <div class="container">
                <div class="flex-block">
                    <div class="card">
                        <h2>Zajímavosti</h2>
                        <p><?php echo get_field("zajimavosti", $post->ID); ?></p>
                    </div>
                    <div class="together">
                        <div class="card">
                            <h2>Chov</h2>
                            <?php $chov = get_field("chov", $post->ID); ?>
                            <?php $text = ""; ?>
                            <?php strlen($chov) > 220 ? $text = substr($chov, 0, 220) . "..." : $text = $popis; ?>
                            <p>
                                <?php
                                $textZ = iconv("ASCII", "UTF-8", $text);
                                echo $text; ?>
                                <?php if (strlen($chov) > 220) : ?>
                                    <br>
                                    <a href="" data-target="#openmodal-chov<?php echo $post->ID; ?>" class="more open-modal" style="text-decoration:underline;">Více zde</a>
                                <?php endif; ?>
                            </p>
                        </div>
                        <div class="modal" id="openmodal-chov<?php echo $post->ID; ?>">
                            <div class="exit">
                                <div class="cross"></div>
                            </div>
                            <div class="modal-container">
                                <p><?php echo $chov; ?></p>
                            </div>
                        </div>
                        <div class="card">
                            <h2>Expozice</h2>
                            <p><?php echo get_field("expozice", $post->ID); ?></p>
                        </div>
                    </div>
                </div>
            </div>

        </section>





    </div>

</main>

<?php get_footer(); ?>