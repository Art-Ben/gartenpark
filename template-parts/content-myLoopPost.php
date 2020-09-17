<?php
/**
 * template for single post loop item for displaying in special Elementor add-on
 */

$post_id = get_the_id();
$post_title = get_the_title( $post_id );
$post_contentShort = get_field( 'short_content', $post_id );
$post_contentBig = get_field( 'full_content', $post_id );
$post_thumb = get_field( 'thumb', $post_id );
$post_date = get_the_time( 'j. F Y' );
$post_moreBtnText = '';
$post_lessBtnText = '';

switch( ICL_LANGUAGE_CODE ) {
    case 'de':
        $post_moreBtnText = 'Mehr erfahren';
        $post_lessBtnText = 'Ausblenden';
    break;

    case 'en':
        $post_moreBtnText = 'Read more';
        $post_lessBtnText = 'Less';
    break;
}
?>

<article class="mySpecialPostBlock" id="<?= $post_id; ?>">
    <div class="mySpecialPostBlock__aside">
        <div class="icon"></div>
    </div>
    <div class="mySpecialPostBlock__primary">
        <h2 class="title">
            <?= $post_title; ?>
        </h2>

        <div class="date">
            <?= $post_date; ?>
        </div> 

        <?php
            if( $post_thumb ) {
        ?>
        <div class="thumb">
            <img src="<?= $post_thumb; ?>" alt="<?= $post_title; ?>">
        </div>
        <?php
            }
        ?> 

        <div class="postContent">
            <div class="postContent__short">
                <?= $post_contentShort; ?>
            </div>

            <div class="postContent__full">
                <?= $post_contentBig; ?>
            </div>
        </div>

        <div class="postMoreLine">
            <button class="postMore">
                <span class="more">
                    <?= $post_moreBtnText; ?>
                </span>
                <span class="less">
                <?= $post_lessBtnText; ?>
                </span>
                
            </button>
        </div>
    </div>
</article>

