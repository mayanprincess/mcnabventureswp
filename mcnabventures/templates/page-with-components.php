<?php
/**
 * Template Name: Page with Components
 * 
 * Template that automatically renders components based on ACF fields
 * Components are rendered automatically via the_content filter
 * No need to manually call components - they appear based on component location settings
 */

get_header(); ?>

<?php if (have_posts()) : ?>
  <?php while (have_posts()) : the_post(); ?>
    
    <?php
    // Components are automatically rendered via the_content filter in inc/acf-fields.php
    // They appear before the content based on component location settings
    // Components with 'location' => 'page' will render automatically
    the_content();
    ?>
    
  <?php endwhile; ?>
<?php endif; ?>

<?php get_footer(); ?>
