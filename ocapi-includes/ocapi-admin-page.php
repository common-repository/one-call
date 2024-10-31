<?php
$ac_ocapi_options = get_option('ac_ocapi_options');
$ac_ocapi_prefix = $ac_ocapi_options['prefix']!='' ? $ac_ocapi_options['prefix'] : '';
$ac_ocapi_featured =$ac_ocapi_options['featured']!='' ? $ac_ocapi_options['featured'] : '';
$ac_ocapi_cats = $ac_ocapi_options['cats']!='' ? $ac_ocapi_options['cats'] : '';
$ac_ocapi_tags = $ac_ocapi_options['tags']!=''? $ac_ocapi_options['tags'] : '';
$ac_ocapi_taxo = $ac_ocapi_options['taxo']!='' ? $ac_ocapi_options['taxo'] : '';
$ac_ocapi_comments = $ac_ocapi_options['comments']!='' ? $ac_ocapi_options['comments'] : '';
$ac_ocapi_author = $ac_ocapi_options['author']!='' ? $ac_ocapi_options['author'] : '';
?>

<div class="wrap">
    <h2><?php _e('One Call - WP REST API Extension', 'one-call'); ?></h2>
    <hr>
    <?php if (isset($_GET['msg'])) : ?>
        <div id="message" class="updated below-h2">
            <?php if ($_GET['msg'] == 'update') : ?>
                <p><?php _e('One Call Settings Updated.','one-call'); ?></p>
            <?php endif; ?>
        </div>
    <?php endif; ?>
    <form method="post">
        <?php if (function_exists('wp_nonce_field')) wp_nonce_field('nonce_ac_ocapi'); ?>
        <div id="ac_ocapi_select_options">
            <table class="form-table">
                <tbody>
                    <tr valign="top">
                        <th scope="row"><?php _e('WP REST API Prefix ', 'one-call') ?></th>
                        <td>
                            <p><?php _e('To Secure and prevent anonymous WP REST API set your custom API <strong>Prefix</strong> where default one is wp-json.', 'one-call') ?></p>
                            <input type="text" name="ac_ocapi_api_prefix" id="ac_ocapi_api_prefix" value="<?php _e($ac_ocapi_prefix, 'one-call') ?>" ><br> <label> <?php _e('Default is wp-json', 'one-call') ?></label>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            <h3><?php _e('One Call Fields Filtering Settings', 'one-call'); ?></h3>
                            <p><?php _e('To enble request responses from <strong>Posts List</strong> check below options for ONE CALL fields.<strong> Note : </strong>by default, for Single Post all fields will be returned', 'one-call') ?></p>
                        </td>
                    </tr>

                    <tr valign="top">
                        <th scope="row"><?php _e('Check to Enable', 'one-call') ?></th>
                        <td>
                            <label><input type="checkbox" name="ac_ocapi_featured_media" id="ac_ocapi_featured_media"
                                  value="<?php _e('ac_ocapi_featured_media', 'one-call') ?>"
                                 <?php if ($ac_ocapi_featured=='ac_ocapi_featured_media') {echo 'checked="checked"'; } ?>
                                > <?php _e('Featured Media', 'one-call') ?></label><br>
                        </td>
                    </tr>
					<tr valign="top">
                        <th scope="row"><?php _e('Check to Enable ', 'one-call') ?></th>
                        <td>
                            <label><input type="checkbox" name="ac_ocapi_cats" id="ac_ocapi_cats"
                                          value="<?php _e('ac_ocapi_cats', 'one-call') ?>"
                                         <?php if ($ac_ocapi_cats=='ac_ocapi_cats') {echo 'checked="checked"'; } ?>   >
                                          <?php _e('Categories', 'one-call') ?></label><br>
                        </td>
                    </tr>
					<tr valign="top">
                        <th scope="row"><?php _e('Check to Enable', 'one-call') ?></th>
                        <td>
                            <label><input type="checkbox" name="ac_ocapi_tags" id="ac_ocapi_tags"
                                          value="<?php _e('ac_ocapi_tags', 'one-call') ?>"
                                    <?php if ($ac_ocapi_tags=='ac_ocapi_tags') {echo 'checked="checked"'; } ?> >
                                <?php _e('Tags', 'one-call') ?></label><br>
                        </td>
                    </tr>
					<tr valign="top">
                        <th scope="row"><?php _e('Check to Enable ', 'one-call') ?></th>
                        <td>
                            <label><input type="checkbox" name="ac_ocapi_taxo" id="ac_ocapi_taxo"
                                          value="<?php _e('ac_ocapi_taxo', 'one-call') ?>"
                                    <?php if ($ac_ocapi_taxo=='ac_ocapi_taxo') {echo 'checked="checked"'; } ?> >
                                <?php _e('Taxonomies', 'one-call') ?></label><br>
                        </td>
                    </tr>
					<tr valign="top">
                        <th scope="row"><?php _e('Check to Enable ', 'one-call') ?></th>
                        <td>
                            <label><input type="checkbox" name="ac_ocapi_comments" id="ac_ocapi_comments"
                                          value="<?php _e('ac_ocapi_comments', 'one-call') ?>"
                                    <?php if ($ac_ocapi_comments=='ac_ocapi_comments') {echo 'checked="checked"'; } ?> >
                                <?php _e('Comments list', 'one-call') ?></label><br>
                        </td>
                    </tr>
					<tr valign="top">
                        <th scope="row"><?php _e('Check to Enable ', 'one-call') ?></th>
                        <td>
                            <label><input type="checkbox" name="ac_ocapi_author" id="ac_ocapi_author"
                                          value="<?php _e('ac_ocapi_author', 'one-call') ?>"
                                    <?php if ($ac_ocapi_author=='ac_ocapi_author') {echo 'checked="checked"'; } ?> >
                                <?php _e('Author Details', 'one-call') ?></label><br>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            <h3><?php _e('WP REST API Default Posts Fields Filtering Settings', 'one-call'); ?></h3>
                            <p><?php _e('To enble request responses from <strong>Posts List</strong> check below options for WP REST API Default fields.<strong> Note : </strong>by default, for Single Post all fields will be returned', 'one-call') ?></p>
                        </td>
                    </tr>
                    <?php
                    $post_objs=array('id','date','date_gmt','guid','modified','modified_gmt','slug','status','type','link','title','content','excerpt','author','featured_media','comment_status','ping_status','sticky','template','format','meta','categories','tags');
                    foreach ($post_objs as $post_obj){
                        ?>
                        <tr valign="top">
                            <th scope="row"><?php _e('Check to Enable', 'one-call') ?></th>
                            <td>
                                <label><input type="checkbox" name="ac_ocapi_wp_defualt_filds[]"
                                              value="<?php _e($post_obj, 'one-call') ?>"
                                        <?php if (in_array($post_obj,get_option('ac_ocapi_wp_defualt_filds'))) {echo 'checked="checked"'; } ?>
                                    > <?php _e($post_obj, 'one-call') ?></label><br>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>

        </div> 
        <p class="submit">
            <input type="submit" class="button-primary" name="ac_ocapi_submit" value="<?php _e('Save One Call Settings', 'one-call'); ?>">
        </p>

    </form>


</div>