<?php 
/**
 * Template Name: Grab
 */
if($_GET['language'] == 'english'){
  include ('grab/grab-english.php');
} else {
  include ('grab/grab-malay.php');

}
?>