<?php
/**
 * Template for displaying front page
 */
get_header();
?>
<section class="page__intro">
    <div class="page__intro--menu">
        <div class="page__intro--menu_items">
            <?php
                render_menu_inline('primary', '', 'page__nav');
            ?>
        </div>
        <div class="page__intro--menu_langs">
            <?php
                render_langmenu( ['de', 'en'] );
            ?>
        </div>
    </div>

    <div class="page__intro--logo">
        <?php
            $home_url = is_front_page() ? 'javascript:void(0)' : get_home_url();
        ?>
        <a href="<?= $home_url; ?>" class="page__intro--logo_link">
                <img src="<?= get_field('page_logo'); ?>" alt="Gartenpark Korneuburg">
        </a>
    </div>

    <div class="page__intro--aside">
        <div class="line"></div>
        <div class="page__intro-socials">
            <?php
                while( have_rows('social_links', 'option') ) {
                    the_row();
                    echo '<a target="_blank" href="'. get_sub_field('social_link') .'" class="social-link"><img src="'. get_sub_field('social_icon') .'"></a>';
                }
            ?>
        </div>
    </div>
    <div class="page__intro--centr">
        <?php
            if( have_rows('page_slider') ) {
                $count = count(get_field('page_slider'));

                if( $count > 1 ) {
                    echo '<div class="page__intro--slider">';
                    while( have_rows('page_slider') ) {
                        the_row();

                        $video_link = '';
                        if(get_sub_field('slide_use_file')) { 
                            $video_link =  get_sub_field('slide_video_upload');
                        } else { 
                            $video_link =  get_sub_field('slide_video_link');
                        };

                        echo '<div class="page__intro--slider_slide">';

                            if( get_sub_field('slide_is_video') ) {
                                echo '
                                <div class="page__intro_poster" style="background-image:url('. get_sub_field('slide_poster') .');">
                                    <a href="'. $video_link .'" data-fancybox class="icon-play" rel="nofollow"></a>
                                </div>';
                            } else {
                                echo '<div class="page__intro_banner" style="background-image:url('. get_sub_field('slide_banner') .')"></div>';
                            }
                        echo '</div>';
                    }
                    echo '</div>';
                } else {
                    echo '<div class="page__intro--item">';
                        while( have_rows('page_slider') ) {
                            the_row();

                            $video_link = '';
                            if(get_sub_field('slide_use_file')) { 
                                $video_link =  get_sub_field('slide_video_upload');
                            } else { 
                                $video_link =  get_sub_field('slide_video_link');
                            };

                            if( get_sub_field('slide_is_video') ) {
                                echo '
                                <div class="page__intro_poster" style="background-image:url('. get_sub_field('slide_poster') .');">
                                    <a href="'. $video_link .'" data-fancybox class="icon-play" rel="nofollow"></a>
                                </div>';
                            } else {
                                echo '<div class="page__intro_banner" style="background-image:url('. get_sub_field('slide_banner') .')"></div>';
                            }
                        }
                    echo '</div';
                }
            }
        ?>
    </div>

    <?php
        if( have_rows('page_slider') ) {
            $count = count(get_field('page_slider'));
            if( $count > 1 ) {
                echo '
                <div class="page__intro--slider_nav">
                    <button class="arrow prev"></button>
                    <button class="arrow next"></button>
                </div>';
            }
        }
    ?>
</section>

<?php
if( have_rows('infos_items') ) {
?>
<section class="infos">
    <div class="infos__cont">
        <h2 class="infos__title">
            <?= get_field('infos_title'); ?>
        </h2>

        <div class="infos__items">
            <?php
                while( have_rows('infos_items') ) {
                    the_row();
                    $item_color = get_sub_field('infos_item_color');
        ?>
            <div class="infos__items--item" style="background-color:<?= $item_color; ?>">
                <?php
                    while( have_rows('infos_items_columns') ) {
                        the_row();
                ?>
                <div class="infos__items--item_column">
                    <?php
                       echo get_sub_field( 'infos_items_column_content' ); 
                    ?>
                </div>
                <?php
                    }
                ?>
            </div>
        <?php
                }
            ?>
        </div>
    </div>
</section>
<?php
}
?>

<?php
    if( have_rows('whom_items') ) {
?>
<section class="forWhom">
    <div class="forWhom__cont">
        <h2 class="forWhom__title">
            <?= get_field('whom_title'); ?>
        </h2>
        <div class="forWhom__items">
            <?php
                while(have_rows('whom_items')) {
                    the_row();
                    $item_logo = get_sub_field('item_logo');
                    $item_url = get_sub_field('item_link');
                    $item_thumb = get_sub_field('item_thumb');
                    $item_title = get_sub_field('item_title');
            ?>
                <a href="<?= $item_url; ?>" class="forWhom__items--item">
                    <div class="forWhom__items--item_hover"></div>
                    <div class="forWhom__items--item_thumb" style="background-image:url(<?= $item_thumb; ?>)"></div>
                    <div class="forWhom__items--item_logo">
                        <img src="<?= $item_logo; ?>" alt="<?= $item_title;?>">
                    </div>

                    <div class="forWhom__items--item_btn">
                        <?php
                            switch( qtrans_getLanguage() ) {
                                case 'en': 
                                    echo 'Learn more';
                                break;
            
                                case 'de':
                                    echo 'Mehr erfahren';
                                break;
                            }
                        ?>
                    </div>
                    <div class="forWhom__items--item_title">
                        <?= $item_title; ?>
                    </div>
                </a>
            <?php
                }
            ?>
        </div>
    </div>
</section>

<div class="customCtaForm">
    <div class="customCtaForm__info">
        <a href="" class="infLink infTel"></a>

        <a href="" class="infLink infMail"></a>
    </div>
    <div class="customCtaForm__instence">
        <form action="javascript:void(0);" class="customCtaForm__form" method="post">
            <div class="formGroup">
                <input name="" type="text" class="my-inpt" placeholder="">
            </div>
            <div class="formGroup">
                <input name="" type="text" class="my-inpt" placeholder="">
            </div>
            <div class="formGroup">
                <input name="" type="text" class="my-inpt" placeholder="">
            </div>
            <div class="formGroup">
                <input name="" type="text" class="my-inpt" placeholder="">
            </div>
            <div class="formGroup stretch">
                <textarea name="" class="my-txt" placeholder=""></textarea>
            </div>
            <div class="formGroup full">
                <button type="submit">

                </button>
            </div>
        </form>
    </div>
</div>

<?php
    }
?>

<?php
get_footer();
