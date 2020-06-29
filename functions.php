<?php

if ( !defined( 'VIBE_URL' ) )
define('VIBE_URL',get_template_directory_uri());



// BEGIN ENQUEUE PARENT ACTION
// AUTO GENERATED - Do not modify or remove comment markers above or below:

if ( !function_exists( 'chld_thm_cfg_locale_css' ) ):
    function chld_thm_cfg_locale_css( $uri ){
        if ( empty( $uri ) && is_rtl() && file_exists( get_template_directory() . '/rtl.css' ) )
            $uri = get_template_directory_uri() . '/rtl.css';
        return $uri;
    }
endif;
add_filter( 'locale_stylesheet_uri', 'chld_thm_cfg_locale_css' );

if ( !function_exists( 'chld_thm_cfg_parent_css' ) ):
    function chld_thm_cfg_parent_css() {
        wp_enqueue_style( 'chld_thm_cfg_parent', trailingslashit( get_template_directory_uri() ) . 'style.css', array( 'wplms-style','bbpress-css','font-awesome' ) );
    }
endif;
add_action( 'wp_enqueue_scripts', 'chld_thm_cfg_parent_css', 10 );

   //END ENQUEUE PARENT ACTION
   //Disable WordPress Admin Bar for all users but admins.
   if(current_user_can('student') ) {
   add_filter('show_admin_bar', '__return_false');
	}


// ADD style to Arabic side
add_action( 'wp_footer', 'add_style_arabic' );
 function add_style_arabic() {

    ?>

  <script type="text/javascript">
      document.getElementById('Layer_1').innerHTML = '<style>.opacity { opacity: 1; }</style> <g id="Layer_1-1" data-name="Layer 1" class="opacity"><path fill="url(#grad1)" stroke="transparent" d="M839.74,712.81C659.8,712.81,19.51,561.12.5,556.61V.5h1199l0,448.6c-2.21,3.28-46.13,68-111,131.84-38.91,38.29-77.63,68.8-115.1,90.68C926.54,699,881.59,712.81,839.74,712.81Z"></path></g>';
	  
	        document.getElementById('Layer_2').innerHTML = ' <style>.opacity { opacity: 1; }</style><g id="Layer_1-2" data-name="Layer 1" class="opacity"><path fill="url(#grad3)" stroke="transparent" d="M839.74,712.81C659.8,712.81,19.51,561.12.5,556.61V.5h1199l0,448.6c-2.21,3.28-46.13,68-111,131.84-38.91,38.29-77.63,68.8-115.1,90.68C926.54,699,881.59,712.81,839.74,712.81Z"></path></g>';
	  
 </script>

         <?php
 }







/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////


// Allow only Arabic keypress and  disable Paste
add_action( 'wp_footer', 'allow_only_arabic' );
 function allow_only_arabic() {

    ?>

  <script type="text/javascript">
        const $input1 = document.querySelector("#field_1");
        const $input2 = document.querySelector("#field_2");
        const allowed = /[أ-ي\/ ]+/;
        $input1.addEventListener("keypress", event => {
			
  if (!allowed.test(event.key)) {
    event.preventDefault();
  }
});

      $input2.addEventListener("keypress", event => {
	
  if (!allowed.test(event.key)) {
  
    event.preventDefault();
  }
		  
 
			
		
});

 $input1.onpaste = e => {
    e.preventDefault();
    return false;
  };
	
 $input2.onpaste = e => {
    e.preventDefault();
    return false;
  };  
 </script>

         <?php
 }


add_action( 'template_redirect', 'redirect_to_specific_page' );

function redirect_to_specific_page() {

if (( is_page("role") || is_page("enseignant-form") || is_page("etudiant-form") )&&  is_user_logged_in()) {

 wp_redirect( 'https://ifpmchlef.dz/'); 
  exit();
    }
}

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Testing to filter courses
// 
add_filter('wplms_grid_course_filters','wplms_exclude_course_category_student_department');
add_filter('vibe_editor_filterable_type','wplms_exclude_course_category_student_department');
add_filter('bp_course_wplms_filters','wplms_exclude_course_category_student_department');
 
function wplms_exclude_course_category_student_department($args){
 
   if($args['post_type'] != 'course') // Bail out if post type is not course
   return $args; 
 
   if(!is_user_logged_in() || current_user_can('edit_posts')) // Bail out if user not logged in. OR administrator & instructors
   return $args;
 
 
   // Bail out if viewing "My Courses" section 
   if(isset($args['meta_query']) && is_array($args['meta_query'])){
       foreach($args['meta_query'] as $query){
         if(isset($query) && is_array($query)){
            if($query['key'] == $user_id){ // If in my courses, do not apply this
              return $args;
            }
         }
       }
    }
 
 
    $user_id=get_current_user_id();
    $custom_profile_field_name = 'التخصص'; //Case sensitive , Custom profile field name
 
    $profile_field_value_category_map =array(  // Profile field value => Course Category slug , Generate this map based on your requirements
     'afdsp' => 'afdsp',
     'apsp' => 'apsp',
     'assp' => 'assp',
     
 );
    // Get profile field value 
    if(function_exists('bp_get_profile_field_data')){
     $value = bp_get_profile_field_data('field='.$custom_profile_field_name.'&user_id='.$user_id);
    }
 
    if(empty($value)) //No department value found for user
     return $args; 
   
   
   if(isset($profile_field_value_category_map[$value])){ // Value exists in profile field - category map
   if(empty($args['tax_query'])){
   $args['tax_query'] = array(array(
   'taxonomy' => 'course-cat',
   'field'    => 'slug',
   'terms'    =>$profile_field_value_category_map[$value],
   'operator' => 'IN'
 )); 
   }else{
   $args['tax_query'][] = array(
   'taxonomy' => 'course-cat',
   'field'    => 'slug',
   'terms'    =>$profile_field_value_category_map[$value],
   'operator' => 'IN'
 ); 
   }
   }
 
   return $args;    
}
/*********************************************/
/*REGISTER FORM*/
// ADD style to Arabic side
add_action( 'wp_footer', 'select_form' );
 function select_form() {

    ?>

  <script type="text/javascript">
	  
      document.getElementById('field_60').setAttribute("onchange","showDiv(this)");
      document.getElementById('field_371').setAttribute("onchange","showDiv(this)");
     	
	 
	  
 </script>

         <?php
 }



// Select options
add_action( 'wp_footer', 'select_option' );
 function select_option() {
	

    ?>

  <script type="text/javascript">
	     $oldId = 0 ;
	  	 $oldValue = 0 ;
		
	  function showDiv(element) {
	 document.getElementsByClassName("submit_registration_form button")[0].setAttribute("style", "display:inline-block !important");


		
		if(document.getElementById("field_67")){
		document.getElementById('field_436').options[1].selected = 'selected';
		} else {
			document.getElementById('field_436').options[2].selected = 'selected';

		}
			  
			  
		  for($i =0 ; $i <=51 ; $i++) {
			 
			 document.getElementById("field_91").options[$i].setAttribute("style", "display:none !important");
			 
		 }
			document.getElementsByClassName("bp-profile-field field_91")[0].setAttribute("style", "display:block !important"); 
	
				$e1 = document.getElementById("field_371");
				$type = $e1.options[$e1.selectedIndex].value;

				  $e2 = document.getElementById("field_60");
				$ville = $e2.options[$e2.selectedIndex].value;
		  
		  if($e1.selectedIndex == 0){
			  document.getElementsByClassName("field_91")[0].setAttribute("style", "display:none !important");
 			document.getElementsByClassName("submit_registration_form button")[0].setAttribute("style", "display:none !important");
			  
		  }
	
		
      switch($ville) {
			 
///////////////////////////////////////////////////////////////////////////////////////////////////////////
//
 case "الشلف":
		if($type =="عامة")
			 {
				 for($i =1 ; $i <=4 ; $i++) {
	 				document.getElementById("field_91").options[$i].setAttribute("style", "display:block !important");
					 document.getElementById('field_91').options[1].selected = 'selected';
 				}
			 } 
			  
			  else if($type =="خاصة") {
					 for($i =5 ; $i <=8 ; $i++) {
	 				document.getElementById("field_91").options[$i].setAttribute("style", "display:block !important");
						 document.getElementById('field_91').options[5].selected = 'selected';
 				}
					
				}

	
    break;

////////////////////////////////////////////////////////////////////////////////////////////////////////	
  case "البيض":
   if($type =="عامة")
 {	
	 for($i =9 ; $i <=11 ; $i++) {
	 				document.getElementById("field_91").options[$i].setAttribute("style", "display:block !important");
		 document.getElementById('field_91').options[9].selected = 'selected';
 				}
 
 }
			  else if($type =="خاصة")  {
	 				document.getElementById("field_91").options[12].setAttribute("style", "display:block !important");
				  document.getElementById('field_91').options[12].selected = 'selected';
 				}
			  
    break;
////////////////////////////////////////////////////////////////////////////////////////////////////////			  
 
		case "النعامة":
	if($type =="عامة") {
		for($i =13 ; $i <=15 ; $i++) {
	 				document.getElementById("field_91").options[$i].setAttribute("style", "display:block !important");
			document.getElementById('field_91').options[13].selected = 'selected';
 				}
					   }
			  else if ($type =="خاصة")  {
	 				document.getElementsByClassName("bp-profile-field field_91")[0].setAttribute("style", "display:none !important"); 
				   document.getElementsByClassName("submit_registration_form button")[0].setAttribute("style", "display:none !important");
				  
 				}
    break;
		  		  		  
////////////////////////////////////////////////////////////////////////////////////////////////////////			  
case "تلمسان":
		if($type =="عامة") {
			for($i =16 ; $i <=23 ; $i++) {
	 				document.getElementById("field_91").options[$i].setAttribute("style", "display:block !important");
				document.getElementById('field_91').options[16].selected = 'selected';
 				}
		}
	else if ($type =="خاصة") {
		
		document.getElementById("field_91").options[24].setAttribute("style", "display:block !important");
		document.getElementById('field_91').options[24].selected = 'selected';
	}
    break;
////////////////////////////////////////////////////////////////////////////////////////////////////////			  
			  
////////////////////////////////////////////////////////////////////////////////////////////////////////			  
		case "سعيدة":
			  if($type =="عامة")
			{
	for($i =25 ; $i <=29 ; $i++) {
	 				document.getElementById("field_91").options[$i].setAttribute("style", "display:block !important");
		document.getElementById('field_91').options[25].selected = 'selected';
 				}
			}
			  
			    else if ($type =="خاصة")  {
					
	 				document.getElementsByClassName("bp-profile-field field_91")[0].setAttribute("style", "display:none !important"); 
					
				   document.getElementsByClassName("submit_registration_form button")[0].setAttribute("style", "display:none !important");
 				}
    break;
////////////////////////////////////////////////////////////////////////////////////////////////////////		
//	  
			  		case "سيدي بلعباس":
			   if($type =="عامة") 
	{for($i =30 ; $i <=35 ; $i++) {
	 				document.getElementById("field_91").options[$i].setAttribute("style", "display:block !important");
		document.getElementById('field_91').options[30].selected = 'selected';
 				}
	}
      else if ($type =="خاصة")  { 
	  for($i =36 ; $i <=38 ; $i++) {
	 				document.getElementById("field_91").options[$i].setAttribute("style", "display:block !important");
		  document.getElementById('field_91').options[36].selected = 'selected';
 				}
	  }
			  
			  break;
////////////////////////////////////////////////////////////////////////////////////////////////////////			  
			  		case "عين تموشنت":
		 if($type =="عامة") 
	 				{document.getElementById("field_91").options[39].setAttribute("style", "display:block !important");
					document.getElementById('field_91').options[39].selected = 'selected';
					}
			  
			      else if ($type =="خاصة")  {
					
	 				document.getElementsByClassName("bp-profile-field field_91")[0].setAttribute("style", "display:none !important"); 
					
				   document.getElementsByClassName("submit_registration_form button")[0].setAttribute("style", "display:none !important");
 				}
 				
    break;
////////////////////////////////////////////////////////////////////////////////////////////////////////			  
			  		case "معسكر":
			  
			   if($type =="عامة") {
				   
			  for($i =40 ; $i <=45 ; $i++) {
	 				document.getElementById("field_91").options[$i].setAttribute("style", "display:block !important");
				  document.getElementById('field_91').options[40].selected = 'selected';
 				}
			   
			   }
			  
			   else if ($type =="خاصة")  {document.getElementById("field_91").options[46].setAttribute("style", "display:block !important");
										  document.getElementById('field_91').options[46].selected = 'selected';
										 
										 }
		
    break;
////////////////////////////////////////////////////////////////////////////////////////////////////////	
		case "وهران":
			  
			    if($type =="عامة"){
					
					
			for($i =47 ; $i <=48 ; $i++) {
			
	 				document.getElementById("field_91").options[$i].setAttribute("style", "display:block !important");
					document.getElementById('field_91').options[47].selected = 'selected';
 				}
				
				}
			   else if ($type =="خاصة") 
			{  
				
				for($i =49 ; $i <=51 ; $i++) {
	 				document.getElementById("field_91").options[$i].setAttribute("style", "display:block !important");
					document.getElementById('field_91').options[49].selected = 'selected';
 				}
			
			}
    break;	
////////////////////////////////////////////////////////////////////////////////////////////////////////

  default:
   alert("Choisissez un établisement !");
	document.getElementsByClassName("field_91")[0].setAttribute("style", "display:none !important");
 	document.getElementsByClassName("submit_registration_form button")[0].setAttribute("style", "display:none !important");
			  

	  }

	 
}

	  
	  
 </script>

         <?php
 }



// add the custom column header
function philopress_modify_user_columns($column_headers) {
//   $column_headers['all'] = 'all';
  $column_headers['nom'] = 'Nom';
   unset($column_headers['name']);
	unset($column_headers['count_sent']);
	unset($column_headers['date_sent']);
  $column_headers['prenom'] = 'Prénom';
	$column_headers['phone'] = 'Téléphone';
//   $column_headers['sexe'] = 'Sexe';

  $column_headers['ville'] = 'Ville';
  $column_headers['etablisement'] = 'Etablisment';
  $column_headers['spec'] = 'Spécialité';
  $column_headers['an'] = 'Année';
  $column_headers['role'] = 'Role';
	
  
  return $column_headers;
}
add_action('manage_users_page_bp-signups_columns','philopress_modify_user_columns');
add_action('manage_users_columns', 'philopress_modify_user_columns');



// dump all the pending user's meta data in the custom column
function philopress_signup_custom_column( $str, $column_name, $signup_object ) {



// 	if ( $column_name == 'all' ) 
//  		return print_r( $signup_object, true );

	
	if ( $column_name == 'role' ) 
         return $signup_object->meta['field_436'][value];
	
     if ( $column_name == 'nom' ) 
         return $signup_object->meta['field_2'][value];
	
	
	
	if ( $column_name == 'prenom' ) 
           return $signup_object->meta['field_1'][value];

     if ( $column_name == 'ville' ) 
         return $signup_object->meta['field_60'][value];
	
	if ( $column_name == 'etablisement' ) 
           return $signup_object->meta['field_91'][value];
	
	if ( $column_name == 'spec' ) 
           return $signup_object->meta['field_67'][value];
	
	if ( $column_name == 'an' ) 
           return $signup_object->meta['field_12'][value];
	
	if ( $column_name == 'phone' ) 
           return $signup_object->meta['field_384'][value];
	
// 	if ( $column_name == 'sexe' ) 
//            return $signup_object->meta['field_25'][value];

    //If you only want to show specific meta fields, you need to know the field id(s). Then you could do this:
    //return $signup_object->meta['field_4472'];
    
  return $str;
}
add_filter( 'bp_members_signup_custom_column', 'philopress_signup_custom_column', 1, 3 );


// dump all the pending user's meta data in the custom column
function ter( $value, $column_name, $user_id) {
// $user_info = get_userdata( $user_id );

// 		
$user_info  =bp_get_profile_field_data( array(
	'user_id'	=> 84,
	'field_id'	=> 91
	
) );



	
	if ( $column_name == 'role' ) 
         return print_r( $signup_object->user_login, true );
	
     if ( $column_name == 'nom' ) 
               return xprofile_get_field_data( 2, $user_id );

	
	if ( $column_name == 'prenom' ) 
           return xprofile_get_field_data( 1, $user_id );

     if ( $column_name == 'ville' ) 
        return xprofile_get_field_data( 60, $user_id );

	
	if ( $column_name == 'etablisement' ) 
           return xprofile_get_field_data( 91, $user_id );
	
	if ( $column_name == 'spec' ) 
           return xprofile_get_field_data( 67, $user_id );
	
	if ( $column_name == 'an' ) 
           return xprofile_get_field_data( 12, $user_id );
	
	if ( $column_name == 'phone' ) 
          return xprofile_get_field_data( 384, $user_id );
	
// 	if ( $column_name == 'sexe' ) 
//            return $signup_object->meta['field_25'][value];

    //If you only want to show specific meta fields, you need to know the field id(s). Then you could do this:
    //return $signup_object->meta['field_4472'];
    
  return $str;
}
add_filter( 'manage_users_custom_column', 'ter', 15, 3 );


// function add_sortable( $columns ) {
// $columns['prenom'] = 'prénom';
// return $columns;
// }
// add_filter( 'manage_users_sortable_columns','add_sortable' );

//change search placeHolder 

add_action( 'wp_footer', 'search' );
 function search() {

    ?>

  <script type="text/javascript">
	  
     document.getElementsByName('s')[0].placeholder='Rechercher un cours ...';

	  
 </script>

         <?php
 }

