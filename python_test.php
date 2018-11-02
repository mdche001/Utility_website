<?php /* Template Name: python_test */ ?>
<?php get_header(); ?>

<?php 
    echo("Congratulations!\n");
    $cmd = system("python hello_wild.py 1 2 3 4 5 6 6",$ret);
    echo("ret is $ret  ");
?>

<?php
if( get_post_meta( get_the_id(), '_di_business_show_breadcrumb', true ) == 1 ) {
	di_business_breadcrumbs();
}
?>

<div class="col-md-12">
	<div class="left-content" >
	<?php
	while( have_posts() ) : the_post();

		get_template_part( 'template-parts/content', 'page' );
		
		comments_template(); 
	endwhile;
	?>

	</div>
		
</div>
<?php get_footer(); ?>

