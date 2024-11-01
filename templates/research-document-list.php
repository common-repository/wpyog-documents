<div id="grid">	
	<ul>
	<?php if ( $query->have_posts() ) : while ( $query->have_posts() ) : $query->the_post();
		$post_id = get_the_ID();
		$document_link = get_post_meta( $post_id, 'document_link', true );
		$ext = pathinfo($document_link, PATHINFO_EXTENSION);
		$iconClass = wpyog_fileExtention($ext);
		?>
		<li class="doc-material fa <?php echo $iconClass;?>">
			<span class="fileIA"><a class="read-more-link" href="<?php echo $document_link;?>" target="_blank"><?php echo get_the_title(); ?></a> <?php if($download == 1 ) { $downloadLink = add_query_arg(array('download_url'=>urlencode( base64_encode($post_id))));?> <a href="<?php echo $downloadLink;?>"> <i class="fa fa-download"></i></a> <?php } ?>
				<?php if($date == 1) { ?>
					<span class="entry-date"><?php echo get_the_date(); ?></span>
				<?php } ?>
				<?php if ($desc == 1) { ?>
					<div class="wpyog-doc-box-content">	
						<?php the_content(); ?>
					</div>
				<?php } ?>
			</span>
		</li>							
	<?php endwhile; endif; ?>
	</ul>
</div>