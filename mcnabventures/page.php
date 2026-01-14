<?php
/**
 * Default Page Template
 * 
 * Automatically renders components based on ACF fields
 * No need to select a template - components render automatically
 */
get_header(); ?>

<?php if (have_posts()) : ?>
  <?php while (have_posts()) : the_post(); ?>
    
    <?php
    // Components are automatically rendered via the_content filter in inc/acf-fields.php
    // They appear before the content based on component location settings
    // Just call the_content() and components will be prepended automatically
    the_content();
    ?>
    
    <?php
    // If you want to add additional content after components, you can do it here
    // But components are already rendered via the_content filter above
    ?>
    
  <?php endwhile; ?>
<?php endif; ?>

<?php get_footer(); ?>