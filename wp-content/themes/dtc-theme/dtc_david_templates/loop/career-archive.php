<?php
	/**
	 * Created by PhpStorm.
	 * User: x
	 * Date: 4/6/2015
	 * Time: 4:40 PM
	 */
	global $wp_query;
	if ( $wp_query->current_post == 0 ) {
		$class = 'box-open';
	} else {
		$class = 'box-close';
	}

	$class = 'box-open';
	if(SITE_LOCALE=="cn"){
		$class = 'box-close';
	}

?>
<!-- <div class="box-colspace <?php echo esc_attr( $class ); ?>"> -->
<div class="box-colspace <?php echo esc_attr( $class ); ?>">
	<h2 class="title <?php echo esc_attr( $class ); ?>"><a href="#"><?php the_title();?></a></h2>

	<div class="box-colspace-content">
		<div class="row">
<!--            <div class="visible-xs col-xs-12 job_department_mobile">--><?php //echo get_post_meta( get_the_ID(), 'job_department', TRUE ); ?><!--</strong></div>-->

            <div class="col-sm-8  left">
				<p><strong>Job Responsibilities</strong><br></p>
				<div><?php echo get_post_meta( get_the_ID(), 'job_accountabilities', TRUE ); ?></div>
                <br/>
				<p><strong>Job requirement</strong><br></p>
				<div><?php echo get_post_meta( get_the_ID(), 'job_requirement', TRUE ); ?></div>
                <div class="line visible-xs"></div>
			</div>
			<div class="col-sm-4  right">
				<table>
					<tbody>
					<tr>
						<td>Department</td>
						<td><strong><?php echo get_post_meta( get_the_ID(), 'job_department', TRUE ); ?></strong></td>
					</tr>
					<tr>
						<td>Location</td>
						<td><strong><?php echo get_post_meta( get_the_ID(), 'job_location', TRUE ); ?></strong></td>
					</tr>
					<tr>
						<td>Type of job</td>
						<td><strong><?php echo get_post_meta( get_the_ID(), 'job_type', TRUE ); ?></strong></td>
					</tr>
					<tr>
						<td>Education</td>
                        <td><strong><?php echo get_post_meta( get_the_ID(), 'job_education', TRUE ); ?></strong></td>
                    </tr>
					</tbody>
				</table>
				<p><strong>Experience</strong><br>

				<div>
					<?php echo get_post_meta( get_the_ID(), 'job_experience', TRUE ); ?>
				</div>
                <?php
                    if(get_post_meta(get_the_ID(),'job_how_to_apply_mail',true)):
                    ;?>
				<p class="apply-today"><a href="mailto:<?php echo get_post_meta(get_the_ID(),'job_how_to_apply_mail',true);?>"><?php _e('Apply Today',HATT_TEXTDOMAIN); ?></a></p>
                <?php endif;?>
			</div>
		</div>
	</div>
</div>
