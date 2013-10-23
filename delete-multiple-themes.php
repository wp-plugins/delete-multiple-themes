<?php
/*
Plugin Name: Delete Multiple Themes
Plugin URI: http://happyplugins.com
Description: Add a registration widget for Wishlist Member.
Author: HappyPlugins
Version: 1.0.0
Author URI: http://happyplugins.com
Text Domain: delete-multiple-themes
*/


class DeleteMultipleThemes {

function __construct()
{


    add_action('admin_menu', array($this, 'add_menu'));
    add_action('admin_init', array($this, 'delete_themes'));

}


function add_menu()
{

    add_theme_page( "Delete Multiple Themes", "Delete Themes", 'manage_options', 'delete-themes', array ($this, 'display_themes'));
}


function display_themes (){
/* Display Theme Table */
$themes = wp_get_themes();
$current_theme = wp_get_theme();




?>
    <div class="wrap">
        <div id="icon-options-general" class="icon32"><br></div>
    <h2>Delete Multiple Themes</h2>
        <br>
<div style="width:65%">
    <p>Choose the themes you want to delete and click on the button to delete them. After your delete the themes you can not restore them so choose your steps carefully.</p>
<form method="post">
<table class="wp-list-table widefat fixed posts" >
	<thead >
		<tr >
            <th class="check-column"><?php _e('&nbsp;', 'pippinw'); ?></th>
			<th ><?php _e('Name', 'pippinw'); ?></th>
            <th ><?php _e('Parent', 'pippinw'); ?></th>
            <th ><?php _e('Author', 'pippinw'); ?></th>
            <th><?php _e('Version', 'pippinw'); ?></th>
            <th><?php _e('Path', 'pippinw'); ?></th>
</tr>
</thead>
<tfoot>
<tr>
    <th class="check-column"><?php _e('&nbsp;', 'pippinw'); ?></th>
    <th ><?php _e('Name', 'pippinw'); ?></th>
    <th ><?php _e('Parent', 'pippinw'); ?></th>
    <th ><?php _e('Author', 'pippinw'); ?></th>

    <th><?php _e('Version', 'pippinw'); ?></th>
    <th><?php _e('Path', 'pippinw'); ?></th>
</tr>
</tfoot>
<tbody class="the-list">
<?php

    foreach ($themes as $row) : ?>
        <tr>

            <th scope="row" class="check-column">
                <?php  if ($current_theme->stylesheet!=$row->stylesheet) { ?>

                    <input type="checkbox" name="theme[]" value='<?php echo $row->stylesheet;?>' />

            <?php } ?>


            </th>
            <td><?php echo $row->name; ?> <?php  if ($current_theme->stylesheet==$row->stylesheet) { echo "(Current Theme)";} ?></td>
            <td><?php echo $row->parent_theme; ?></td>
            <td><?php echo $row->author; ?></td>
            <td><?php echo $row->version; ?></td>
            <td><?php echo $row->template; ?></td>
        </tr>
    <?php
    endforeach; ?>

</tbody>
</table>
    <br/>

    <?php wp_nonce_field('delete_multiple_themes','themes_delete'); ?>
<input type="submit" class="primary" value="Delete Themes" onclick="return confirm( 'You are about to delete all of the selected themes \'Cancel\' to stop, \'OK\' to delete.' );">



</form>
    </div>

        <div style="border: 1px solid #cdcdcd; padding: 20px; width: 30%; float:right;">
        <a href="http://happyplugins.com" target="_blank"><img src="<?php echo plugins_url ("/images/happyplugins-logo.png" ,__FILE__); ?>" width="160"/></a>

        <p>For more plugin visit our plugin store at:<a href="http://store.happyplugins.com"/>http://store.happyplugins.com</a></p>
        <p>if you are interested in out work you can read more our blog</p>

         </div>
        <div>

            <?php // echo  file_get_contents("http://google.com"); ?>


        </div>

    </div>

<?php

 }


function delete_themes (){
/* Precess and Delete Themes */

    /* Check Security */

    if ( isset($_POST['themes_delete']) && wp_verify_nonce($_POST['themes_delete'],'delete_multiple_themes') )
    {

    $themes_delete = $_POST['theme'];


    if (!function_exists('delete_theme')) {


        require_once( ABSPATH . WPINC .  '/pluggable.php' );
        require_once( ABSPATH . 'wp-admin/includes/file.php' );
        require_once( ABSPATH . 'wp-admin/includes/theme.php' );

    }

    foreach ($themes_delete as $theme) {

            delete_theme ($theme);

    }


}

} // End Check
}

$deleteMultiple = new DeleteMultipleThemes();
?>
