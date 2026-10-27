<?php
/**
 * Template Name: Maps
 * Created by PhpStorm.
 * User: me664
 * Date: 1/5/15
 * Time: 11:45 PM
 */
get_header();
?>
    <?php
    if (have_posts()):while (have_posts()):
        the_post();
        the_content();?>
       <div class="col-sm-12">
           <div id="maps" style="width:100%;height: 500px;display: block;"></div>
       </div>
 <?php
    endwhile;endif?>
<script type="text/javascript">
    var mapRadius = ;
    var mapType = <?php echo json_encode(); ?>
</script>
<?php get_footer();