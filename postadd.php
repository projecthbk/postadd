<?php
$password='password';
/*
 * postadd.php
 * 
 * Copyright 2020 Krzysztof Hrybacz <krzysztof@zygtech.pl>
 * 
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 * 
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 * 
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston,
 * MA 02110-1301, USA.
 * 
 * 
 */

require_once('wp-load.php');
require_once('wp-admin/includes/image.php');
require_once('wp-admin/includes/file.php');
require_once('wp-admin/includes/media.php');
get_header();
?>
<style>
	input[type=file] { width: 0.1px; height: 0.1px; opacity: 0; overflow: hidden; position: absolute; z-index: -1; }
</style>
<?php
if ($_POST['pass']==$password && $_POST['title']!='') {
  // Create post object
  $my_post = array(
     'post_title' => $_POST['title'],
     'post_content' => str_replace("\n","<br />\n",$_POST['content']),
     'post_status' => 'publish',
     'post_author' => 1,
  );

  // Insert the post into the database
  $postId = wp_insert_post( $my_post );
  if ($_FILES['uploadFile']!='') {
	$id = media_handle_upload( 'uploadFile', $postId );
	set_post_thumbnail( $postId, $id );
  }
  echo '<center><h1>POST ADDED</h1><a href="postadd.php">(BACK)</a></center>'; 
} else {
?>
	<form method="POST" action="postadd.php" enctype="multipart/form-data">
		<center>
		<input type="password" name="pass" placeholder="PASSWORD" /><br /><br />
		<input type="file" id="upload" name="uploadFile" /><label for="upload"><i class="fa fa-upload"></i> ADD PHOTO</label><br /><br />
		<input type="text" name="title" placeholder="TITLE" /><br /><br />
		<textarea name="content" placeholder="CONTENT"></textarea><br /><br />
		<input type="submit" value="SEND POST" />
		</center>
	</form>
<?php } 
get_footer();
?>
