<?php get_header(); ?>

			<!-- Header -->
				<header id="header">
					<div class="logo">
						<span class="icon"><img style="width: 70%;height: auto;margin-top: 15px;" src="wp-content/themes/git_project_cesi_2017/images/corne.png" alt="UNICORN"></span>	
					</div>
					
					<div class="content">
						<div class="inner">
							<h1>UNICORN DIMENSION</h1>
							
							<?php if ( get_bloginfo( 'description' )  !== '' ) { ?>
								<h2>GOUVERNEUR DES MONDES</h2>
							<?php } ?>
							
							<!-- begin front quote (if used) -->
							<?php dimension_quote_text()?>
							<!-- end front quote -->
						</div>
					</div>
					
					
					<?php 
					// custom query for posts listed by menu order
					// exclude Hello World
					
					$exclude_hello_world = array( 1 );
					
					$the_query = new WP_Query(array(
						'post_type' => 'post', 
						'post_status' => 'publish', 
						'post__not_in' => $exclude_hello_world, 
						'orderby' => 'menu_order', 
						'order' => 'ASC',
						'posts_per_page' => 8,
					) );

					// First Loop for the nav
					if ( $the_query->have_posts() ) {
					
						echo '<nav><ul>';
						while ( $the_query->have_posts() ) {
							$the_query->the_post();
							echo '<li><a href="#' . sanitize_title( get_the_title() ) . '">' . get_the_title() . '</a></li>';
						}
						
						echo '</ul></nav></header>';
						
						// rewind so we can do the content
						$the_query->rewind_posts();
						
						
						// Second Loop for the stuff 
						if ( $the_query->have_posts() ) {
							echo '<!-- Main --><div id="main">';
						
							while ( $the_query->have_posts() ) {
								$the_query->the_post();
								echo '<article id="' . sanitize_title( get_the_title() ) . '"><h2 class="major">' . get_the_title() . '</h2>';
							
								$the_link = get_post_meta( get_the_ID(), '_dimension_link', true );
								$fa_icon = get_post_meta( get_the_ID(), '_link_fa_icon', true );
								
								if ( has_post_thumbnail() ) {
							
									if ( !empty($the_link) ) {
										echo '<a href="' . $the_link . '"><span class="image main">';
										the_post_thumbnail();
										echo '</span></a>';
									 } else {
										echo '<span class="image main">';
										the_post_thumbnail();
										echo '</span>';
									 }
								} // has post thumbnail
							
								the_content();	
							
								if ( !empty( $the_link ) ) {
									echo '<p class="align-center"><a href="' . $the_link . '" class="button icon ' . $fa_icon . '">Go</a></p>';
								}
							
								echo '</article>';
							} // while
							
						} // second query loop
						
						echo '</div><!-- Main -->';

						/* Restore original Post Data */
						wp_reset_postdata();
					} else {
						echo '<!-- Main --><div id="main-none"><p>Inclinez-vous devant la suprematie des licornes. Les licornes pour les rassembler tous, les licrones pour les gouverner tous.<br> Vous ne pouvez pas y échapper.</p></div>';
					}
					?>
								
<?php get_footer(); ?>