<?php
/*
*    Admin works will be here.
*/

if (!class_exists('AC_OCAPI_Responses')) :
	class AC_OCAPI_Responses {
    private $test_param;
	 public function __construct() {
	  $post_types = get_post_types( array( 'public' => true ), 'objects' );
	  foreach ( $post_types as $post_type ) {
	   $post_type_name = $post_type->name;
	   register_rest_field( $post_type_name,
		   'one_call',
		   array(
			   'get_callback' => array($this, 'get_one_call_all'),
			   'schema' => null,
		   )
	   );
	  }
	 }

	 public function get_one_call_all($object,$field_name,$request) {
	  //Response handler for list page
     $request_from=$request->get_url_params();
     $ac_ocapi_options = get_option('ac_ocapi_options');
     $post_type=$object['type'];
     //Building the response based on the conditions.
	     $return = array();
         if(!empty($request_from)){ //for single post
             //Get featured media
             $return['featured_list']=$this->featured_images($object);
             // Get categories
             $return ['categories_list']=$this->get_post_categories($object['id']);
             // Get tags
             $return['tags_list']=$this->get_post_tags($object['id']);
             // Get taxonomies
             $return=array_merge($return,$this->get_post_taxonomies($object['id']));
             //Get comments
             $return['comments_list']=$this->get_post_comments($object['id']);
             //Get Post Author
             $return['post_author']=$this->get_post_author($object);
         }else if(empty($request_from)){
             //Wordpress Default post request modify.The api uses eg. 'rest_prepare_post' with 3 parameters.
             add_filter('rest_prepare_'.$post_type,array($this,'default_wp_rest_field_filter'),20,3);

             //for posts list one call request.
             if($ac_ocapi_options['featured']=="ac_ocapi_featured_media"){
                 //Get featured media
                 $return['featured_list']=$this->featured_images($object);
             }
             if($ac_ocapi_options['cats']=="ac_ocapi_cats"){
                 //Get categores list
                 $return ['categories_list']=$this->get_post_categories($object['id']);
             }
             if($ac_ocapi_options['tags']=="ac_ocapi_tags"){
                 // Get tags
                 $return['tags_list']=$this->get_post_tags($object['id']);
             }
             if($ac_ocapi_options['taxo']=="ac_ocapi_taxo"){
                 // Get taxonomies
                 $return=array_merge($return,$this->get_post_taxonomies($object['id']));
             }
             if($ac_ocapi_options['comments']=="ac_ocapi_comments"){
                 //Get comments
                 $return['comments_list']=$this->get_post_comments($object['id']);
             }
             if($ac_ocapi_options['author']=="ac_ocapi_author"){
                 //Get Post Author
                 $return['post_author']=$this->get_post_author($object);
             }

         }


	  return $return;
	 }
	 //Wordpress default post modify
    public function default_wp_rest_field_filter( $response, $post, $request ){
        // Get the parameter from the WP_REST_Request
        // This supports headers, GET/POST variables.
        // and returns 'null' when not exists
        $fields =  array('one_call'); ;
        if($fields){

            // Create a new array
            $filtered_data = array();

            // The original data is in $response object in the property data
            $data = $response->data;

            // If _embed is included in the GET also fetch the _embedded values.
            if(isset( $_GET['_embed'] )){
                // Found in: https://core.trac.wordpress.org/browser/trunk/src/wp-includes/rest-api/endpoints/class-wp-rest-controller.php#L217
                $rest_server = rest_get_server();
                // Code from https://core.trac.wordpress.org/browser/trunk/src/wp-includes/rest-api/class-wp-rest-server.php#L382
                // $result = $this->response_to_data( $result, isset( $_GET['_embed'] ) );
                $data = $rest_server->response_to_data($response,true);
            } else {
                // The links should be included in the first place, so they can be filtered if needed.
                $data['_links'] = $response->get_links();
            }

            // Explode the $fields parameter to an array.
            //$filters = explode(',',$fields);
            $filters = array_merge(get_option('ac_ocapi_wp_defualt_filds'),$fields);

            // If the filter is empty return the original.
            if(empty($filters) || count($filters) == 0)
                return $response;

           // $singleFilters = array_filter($filters,array($this,'singleValueFilterArray'));

            // Foreach property inside the data, check if the key is in the filter.
            foreach ($data as $key => $value) {
                // If the key is in the $filters array, add it to the $filtered_data
                if (in_array($key, $filters)) {
                    $filtered_data[$key] = $value;
                }
            }

           /* $childFilters = array_filter($filters,array($this,'childValueFilterArray'));

            // This part should be made better!!
            foreach ($childFilters as $childFilter) {
                $val = $this->array_path_value($data,$childFilter);
                if($val != null){
                    $this->set_array_path_value($filtered_data,$childFilter,$val);
                }
            }*/

        }

        // return the filtered_data if it is set and got fields.
        // return (isset($filtered_data) && count($filtered_data) > 0) ? rest_ensure_response($filtered_data) : $response;
        if (isset($filtered_data) && count($filtered_data) > 0) {
            //$filtered_data['_links'] = $response->get_links();
            $newResp = rest_ensure_response($filtered_data);
            return $newResp;
        }else{
            // return the response that we got in the first place.
            return $response;
        }


    }

	 //One Call request modify
	 public function get_post_categories($post_id){
		 $post_categories = wp_get_post_categories($post_id);
		 $categories_list=array();
		 foreach ($post_categories as $category) {
			 $categories_list[] = get_category($category);
		 }
		 return $categories_list;
	 }
	 
	 public function get_post_tags($post_id){
		 $post_tags = wp_get_post_tags($post_id);
		 $tags_list=array();
		 if (!empty($post_tags)){
			 $tags_list = $post_tags;
		 }
		 return $tags_list;
	 }
	 
	 public function get_post_taxonomies($post_id){
		 $args = array(
			 'public'   => true,
			 '_builtin' => false
		 );
		 $output = 'names'; // or objects
		 $operator = 'and'; // 'and' or 'or'
		 $taxonomies = get_taxonomies( $args, $output, $operator );
		 $taxonomies_list=array();
		 foreach ( $taxonomies as $key => $taxonomy_name ) {
			 $post_taxonomies = get_the_terms($post_id, $taxonomy_name);
			 if (is_array($post_taxonomies)) {
				 foreach ($post_taxonomies as $key2 => $post_taxonomy) {
					 $taxonomies_list[$taxonomy_name][] = get_term($post_taxonomy, $taxonomy_name);
				 }
			 }
		 }
		 return $taxonomies_list;
	 }
    
	
	 public function featured_images($object){
		// Only proceed if the post has a featured image.
		if ( ! empty( $object['featured_media'] ) ) {
			$image_id = (int)$object['featured_media'];
		} elseif ( ! empty( $object['featured_image'] ) ) {
			// This was added for backwards compatibility with < WP REST API v2 Beta 11.
			$image_id = (int)$object['featured_image'];
		} else {
			return null;
		}

		$image = get_post( $image_id );

		if ( ! $image ) {
			return null;
		}

		// This is taken from WP_REST_Attachments_Controller::prepare_item_for_response().
		$featured_image['id']            = $image_id;
		$featured_image['alt_text']      = get_post_meta( $image_id, '_wp_attachment_image_alt', true );
		$featured_image['caption']       = $image->post_excerpt;
		$featured_image['description']   = $image->post_content;
		$featured_image['media_type']    = wp_attachment_is_image( $image_id ) ? 'image' : 'file';
		$featured_image['media_details'] = wp_get_attachment_metadata( $image_id );
		$featured_image['post']          = ! empty( $image->post_parent ) ? (int) $image->post_parent : null;
		$featured_image['source_url']    = wp_get_attachment_url( $image_id );

		if ( empty( $featured_image['media_details'] ) ) {
			$featured_image['media_details'] = new stdClass;
		} elseif ( ! empty( $featured_image['media_details']['sizes'] ) ) {
			$img_url_basename = wp_basename( $featured_image['source_url'] );
			foreach ( $featured_image['media_details']['sizes'] as $size => &$size_data ) {
				$image_src = wp_get_attachment_image_src( $image_id, $size );
				if ( ! $image_src ) {
					continue;
				}
				$size_data['source_url'] = $image_src[0];
			}
		} elseif ( is_string( $featured_image['media_details'] ) ) {
			$featured_image['media_details'] = new stdClass();
			$featured_image['media_details']->sizes = new stdClass();
		} else {
			$featured_image['media_details']['sizes'] = new stdClass;
		}
	  return apply_filters( 'one_call_featured', $featured_image, $image_id );
	}
	
	public function get_post_comments($post_id){
		$comments = get_comments( array( 'post_id' => $post_id ) );
		return $comments;
	}
	
	public function get_post_author($object){
		$author_id=$object['author'];
		$author['author_id']=$author_id;
		$author['display_name']= get_the_author_meta( 'display_name', $author_id );
		$author['avatar_url']= get_avatar_url($author_id, array() );
		$author['email']= get_the_author_meta( 'user_email', $author_id );
		$author['description']= nl2br(get_the_author_meta('description',$author_id));
		return $author;
	}
}
endif;
