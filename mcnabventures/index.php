<?php get_header(); ?>

<div class="container" style="padding: 3rem 1rem;">
  <?php if (have_posts()) : ?>
    <?php while (have_posts()) : the_post(); ?>
      <article <?php post_class(); ?>>
        <h1><?php the_title(); ?></h1>
        <div class="entry-content">
          <?php the_content(); ?>
        </div>
      </article>
    <?php endwhile; ?>
  <?php else : ?>
    <div class="no-content">
      <h1>Welcome to Genetics Learning Hub</h1>
      <p>Your site is ready. Start creating content in the WordPress admin.</p>
    </div>
  <?php endif; ?>
</div>

<?php get_footer(); ?>
