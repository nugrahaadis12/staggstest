<?php
if ( ! defined( 'ABSPATH' ) ) {
  die( '-1' );
}

if (!function_exists('mt_addons_swiper_attributes')) {
  function mt_addons_swiper_attributes($id = '', $autoplay = '', $delay = '', $items_desktop = '', $items_mobile = '', $items_tablet = '', $space_items = '', $touch_move = '', $effect = '', $grab_cursor = '', $infinite_loop = '', $centered_slides = '' , $navigation = '', $pagination = ''){
    ?>
        data-swiper-id="<?php echo esc_attr($id); ?>"  
        data-swiper-autoplay="<?php echo esc_attr($autoplay); ?>"
        data-swiper-delay="<?php echo esc_attr($delay); ?>" 
        data-swiper-desktop-items="<?php echo esc_attr($items_desktop); ?>" 
        data-swiper-mobile-items="<?php echo esc_attr($items_mobile); ?>" 
        data-swiper-tablet-items="<?php echo esc_attr($items_tablet); ?>" 
        data-swiper-space-between-items="<?php echo esc_attr($space_items); ?>" 
        data-swiper-allow-touch-move="<?php echo esc_attr($touch_move); ?>" 
        data-swiper-effect="<?php echo esc_attr($effect); ?>"
        data-swiper-grab-cursor ="<?php echo esc_attr($grab_cursor); ?>"
        data-swiper-infinite-loop ="<?php echo esc_attr($infinite_loop); ?>"
        data-swiper-centered-slides ="<?php echo esc_attr($centered_slides); ?>"
        data-swiper-navigation ="<?php echo esc_attr($navigation); ?>"
        data-swiper-pagination ="<?php echo esc_attr($pagination); ?>"

    <?php 
  }
}

/**
 * Get array of all pages from the site sort asc by name
 * Use for any CPT -> mt_addons_posts_array('page') mt_addons_posts_array('product') etc
 * @param $post_type string (CTP - page, post, cpt name...etc)
 * @return array of posts titles and ids
 */ 
function mt_addons_posts_array($post_type = ''){

  $items_array = array();

    $args = array(
      'numberposts' => -1,
      'sort_order' => 'asc',
      'post_status'   => 'publish',
      'post_type'   => $post_type
    );
     
    $all_posts = get_posts( $args );
    if ($all_posts) {
      foreach($all_posts as $post){
        $title = esc_html(get_the_title($post->ID));
        $items_array[$title] = $post->ID;
      }
    }

  // Sort alphabetically
  ksort($items_array);

  return $items_array;
}


/**
 * Get array of all pages from the site sort asc by name
 * Use for any CPT -> mt_addons_posts_array('page') mt_addons_posts_array('product') etc
 * @param $post_type string (CTP - page, post, cpt name...etc)
 * @return array of posts titles and ids
 */ 
function mt_addons_image_sizes_array(){

  $items_array = array();

    $all_image_sizes = get_intermediate_image_sizes();

    if ($all_image_sizes) {
      foreach($all_image_sizes as $image_size){
        $items_array[$image_size] = $image_size;
      }
    }

  // Sort alphabetically

  return $items_array;
}


if (!function_exists('mt_addons_build_link')) {
  function mt_addons_build_link($btn_url = ''){

    $url_link = array();

    if ($btn_url) {
      $url_atts = explode(',', $btn_url);
      if ($url_atts) {
        $target = '';
        if ($url_atts[1]) {
          $target = '_blank';
        }
        $nofollow = '';
        if ($url_atts[2] == 'on') {
          $nofollow = 'nofollow';
        }

        $url_link = array(
          'url' => $url_atts[0],
          'title' => $url_atts[3],
          'rel' => $nofollow,
          'target' => $target,
        );

      }
    }

    return $url_link;
  }
}
// pricing url
if (!function_exists('mt_addons_build_pricing_link')) {
  function mt_addons_build_pricing_link($button_url = ''){

    $url_link = array();

    if ($button_url) {
      $url_atts = explode(',', $button_url);
      if ($url_atts) {
        $target = '';
        if ($url_atts[1]) {
          $target = '_blank';
        }
        $nofollow = '';
        if ($url_atts[2] == 'on') {
          $nofollow = 'nofollow';
        }

        $url_link = array(
          'url' => $url_atts[0],
          'title' => $url_atts[3],
          'rel' => $nofollow,
          'target' => $target,
        );

      }
    }

    return $url_link;
  }
}
 // end pricing url
if (!function_exists('mt_addons_build_box_icon_link')) {
  function mt_addons_build_box_icon_link($icon_url = ''){

    $url_link = array();

    if ($icon_url) {
      $url_atts = explode(',', $icon_url);
      if ($url_atts) {
         $target = '';
        if ($url_atts[1]) {
          $target = '_blank';
        }
        $nofollow = '';
        if ($url_atts[2] == 'on') {
          $nofollow = 'nofollow';
        }

        $url_link = array(
          'url' => $url_atts[0],
          'rel' => $nofollow,
          'target' => $target,
          'title' => $url_atts[3],
        );

      }
    }

    return $url_link;
  }
}
 
if (!function_exists('mt_addons_build_img_link')) {
  function mt_addons_build_img_link($button_image = ''){

    $img = array();

    if ($button_image) {
      $url_atts = explode(',', $button_image);
      if ($url_atts) {

        $img = array(
          'id' => $url_atts[0],
        );
      }
    }

    return $img;
  }
}
// banner link
if (!function_exists('mt_addons_build_banner_link')) {
  function mt_addons_build_banner_link($banner_url = ''){

    $url_link = array();

    if ($banner_url) {
      $url_atts = explode(',', $banner_url);
      if ($url_atts) {
        $target = '';
        if ($url_atts[1]) {
          $target = '_blank';
        }
        $nofollow = '';
        if ($url_atts[2] == 'on') {
          $nofollow = 'nofollow';
        }

        $url_link = array(
          'url' => $url_atts[0],
          'title' => $url_atts[3],
          'rel' => $nofollow,
          'target' => $target,
        );

      }
    }

    return $url_link;
  }
}
/**
 * Get array of all pages from the site sort asc by name
 * Use for any CPT -> mt_addons_posts_array('page') mt_addons_posts_array('product') etc
 * @param $string string (category1,category2) - where category1 is the slug of a product category
 * @return array of arrays with key and value
 */ 
if (!function_exists('mt_addons_param_group_parse_atts')) {
  function mt_addons_param_group_parse_atts($string = ''){

    $collectors_groups = array();

    if ($string) {
      $collectors_groups_exploded = explode(',', $string);
      if ($collectors_groups_exploded) {
        foreach ($collectors_groups_exploded as $collectors_groups_item) {
          $item =  array('category' => $collectors_groups_item);
          array_push($collectors_groups, $item);
        }
      }
    }
    return $collectors_groups;
  }
}


if (!function_exists('mt_addons_param_group_img_parse_atts')) {
  function mt_addons_param_group_img_parse_atts($items = ''){

    $member_groups = array();
     if ($items) {

      $member_groups_exploded = explode(',', $items);
      if ($member_groups_exploded) {
          $item = array(
            'list_image'         => $member_groups_exploded[0],
            'member_name'        => $member_groups_exploded[1],
            'name_size'          => $member_groups_exploded[2],
            'member_position'    => $member_groups_exploded[3],
            'member_description' => $member_groups_exploded[4],
            'member_url'         => $member_groups_exploded[5],
            'email'              => $member_groups_exploded[6],
            'facebook'           => $member_groups_exploded[7],
            'twitter'            => $member_groups_exploded[8],
            'pinterest'          => $member_groups_exploded[9],
            'instagram'          => $member_groups_exploded[10],
            'youtube'            => $member_groups_exploded[11],
            'dribbble'           => $member_groups_exploded[12],
            'linkedin'           => $member_groups_exploded[13],
            'deviantart'         => $member_groups_exploded[14],
            'digg'               => $member_groups_exploded[15],
            'flickr'             => $member_groups_exploded[16],
            'stumbleupon'        => $member_groups_exploded[17],
            'tumblr'             => $member_groups_exploded[18],
          );
          array_push($member_groups, $item);
      }
    }
    // member_name
    return $member_groups;
  }
}
