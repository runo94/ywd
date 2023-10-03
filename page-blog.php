<?php
/*
 Template Name: Blog Page
 *
 * This is your custom page template. You can create as many of these as you need.
 * Simply name is "page-whatever.php" and in add the "Template Name" title at the
 * top, the same way it is here.
 *
 * When you create your page, you can just select the template and viola, you have
 * a custom page template to call your very own. Your mother would be so proud.
 *
 * For more info: http://codex.wordpress.org/Page_Templates
*/

$args = array(
    'post_type' => array('post'),
    'category_nam' => 'blog',
    'post_status' => 'publish',
);
$new_post_loop = new WP_Query($args);
?>

<?php get_header(); ?>

<div id="content">

    <div id="inner-content" class="wrap cf">

        <main id="main" class="cf" role="main" itemscope itemprop="mainContentOfPage" itemtype="http://schema.org/Blog">

            <?php
            if ($new_post_loop->have_posts()):
                while ($new_post_loop->have_posts()):
                    $new_post_loop->the_post();
                    ?>
                    <article id="post-<?php the_ID(); ?>" <?php post_class('cf'); ?> role="article" itemscope
                        itemtype="http://schema.org/BlogPosting">

                        <header class="article-header">

                            <h3 class="page-title">
                                <a href="<?php the_permalink() ?>"><?php the_title(); ?></a>
                            </h3>

                            <p class="byline vcard">
                                <?php printf(__('Posted <time class="updated" datetime="%1$s" itemprop="datePublished">%2$s</time> by <span class="author">%3$s</span>', 'ywdtheme'), get_the_time('Y-m-j'), get_the_time(get_option('date_format')), get_the_author_link(get_the_author_meta('ID'))); ?>
                            </p>


                        </header>

                        <section class="entry-content cf" itemprop="articleBody">
                            <?php
                            
                            the_content();
                            
                            wp_link_pages(
                                array(
                                    'before' => '<div class="page-links"><span class="page-links-title">' . __('Pages:', 'ywdtheme') . '</span>',
                                    'after' => '</div>',
                                    'link_before' => '<span>',
                                    'link_after' => '</span>',
                                ));
                            ?>
                        </section>


                        <footer class="article-footer">

                            <?php the_tags('<p class="tags"><span class="tags-title">' . __('Tags:', 'ywdtheme') . '</span> ', ', ', '</p>'); ?>

                        </footer>

                    </article>

                <?php endwhile; else: ?>

                <article id="post-not-found" class="hentry cf">
                    <header class="article-header">
                        <h1>
                            <?php _e('Oops, Post Not Found!', 'ywdtheme'); ?>
                        </h1>
                    </header>
                    <section class="entry-content">
                        <p>
                            <?php _e('Uh Oh. Something is missing. Try double checking things.', 'ywdtheme'); ?>
                        </p>
                    </section>
                    <footer class="article-footer">
                        <p>
                            <?php _e('This is the error message in the page-custom.php template.', 'ywdtheme'); ?>
                        </p>
                    </footer>
                </article>

            <?php endif; ?>

        </main>

    </div>

</div>

<?php get_footer(); ?>