<?php get_header(); ?>
<div class="header">
          <div class="title">
          	<?
	$parametri = array(
	  'post_type' => 'post', /* Отбираем только записи. */
	  'post_status' => 'publish', /* И только опубликованные. */
	  'posts_per_page' => -1, /* Снимаем ограничение на количество показываемых записей на одну страничку. */
	  'caller_get_posts' => 1 /* Игнорируем особенности записей-липучек. */
	);

    $moi_zapros = null;
	$moi_zapros = new WP_Query($parametri); /* Формируем новый "нестандартный" запрос. */
	if ($moi_zapros->have_posts()):
		echo "<select class=\"post\" onchange=\"location = this.options[this.selectedIndex].value;\">";
	  while ($moi_zapros->have_posts()) : $moi_zapros->the_post(); ?>
	                <option value="<?php the_permalink() ?>"><?php the_title(); ?></option>
	    <?php
	  endwhile;
	  echo "</select>";
	endif;
	wp_reset_query();  /* Сбрасываем нашу выборку. */
?>
          </div>
          <div class="navigation">
          	<a onclick="history.back()">назад</a>
          </div>
</div>
<div class="container-single">
		<?php the_post_thumbnail(); ?>
</div>
<?php get_footer(); ?>