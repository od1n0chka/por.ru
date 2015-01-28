<?php get_header(); ?>
<div class="header">
  <div class="logo">
    <a href="">Портфолио</a>
  </div>
  <?php wp_nav_menu( array( 'theme_location' => 'header-menu') ); ?>
</div>
<div class="container">
    <?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
      <div class="box">
        <div class="box-container">
          <div class="image">
            <?php the_post_thumbnail(); ?>    
          </div>
        </div>
    </div> 
    <?php endwhile; else: ?>

    
    <p>Ничего не найдено</p>

    <?php endif; ?>
    <?php rewind_posts(); ?>
 
      <?php while (have_posts()) : the_post(); ?>
      <?php endwhile; ?>
</div>
<div class="footer">
  <p>copyright 2015</p>
</div>

<?php get_footer(); ?>