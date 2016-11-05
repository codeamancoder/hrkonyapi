<?php

/**
* ER-Leaf shortcodes
*
* @since ER-Leaf 1.0
*/

/*-----------------------------------------------------------------------------------*/
/*  Columns
/*-----------------------------------------------------------------------------------*/
function er_leaf_cols( $atts, $content = null ) {
   return '<div class="cols">' . do_shortcode($content) . '</div>';
}
function er_leaf_col_1( $atts, $content = null ) {
   return '<div class="col-1">' . do_shortcode($content) . '</div>';
}
function er_leaf_col_2( $atts, $content = null ) {
   return '<div class="col-2">' . do_shortcode($content) . '</div>';
}
function er_leaf_col_3( $atts, $content = null ) {
   return '<div class="col-3">' . do_shortcode($content) . '</div>';
}
function er_leaf_col_4( $atts, $content = null ) {
   return '<div class="col-4">' . do_shortcode($content) . '</div>';
}
function er_leaf_col_5( $atts, $content = null ) {
   return '<div class="col-5">' . do_shortcode($content) . '</div>';
}
function er_leaf_col_6( $atts, $content = null ) {
   return '<div class="col-6">' . do_shortcode($content) . '</div>';
}
function er_leaf_col_7( $atts, $content = null ) {
   return '<div class="col-7">' . do_shortcode($content) . '</div>';
}
function er_leaf_col_8( $atts, $content = null ) {
   return '<div class="col-8">' . do_shortcode($content) . '</div>';
}
function er_leaf_col_9( $atts, $content = null ) {
   return '<div class="col-9">' . do_shortcode($content) . '</div>';
}
function er_leaf_col_10( $atts, $content = null ) {
   return '<div class="col-10">' . do_shortcode($content) . '</div>';
}
function er_leaf_col_11( $atts, $content = null ) {
   return '<div class="col-11">' . do_shortcode($content) . '</div>';
}
function er_leaf_col_12( $atts, $content = null ) {
   return '<div class="col-12">' . do_shortcode($content) . '</div>';
}

/*-----------------------------------------------------------------------------------*/
/*  Section
/*-----------------------------------------------------------------------------------*/
function er_leaf_section( $atts, $content = null ){
  extract(shortcode_atts(array(
    'class' => "",
    'bg_color' => "",
    'border_color' => "",
    'padding' => "",
    'margin'  => "",
    'visible' => "all",
    ), $atts));

    $out_1 = '';
    $out_2 = '';
    $out_3 = '';
    $out_4 = '';
    $class_out = '';

    if($bg_color){
      $out_1 = 'background-color:'.$bg_color.';';
    }

    if($border_color){
      $out_2 = 'border-top:1px solid '.$border_color.';border-bottom:1px solid '.$border_color.';';
    }

    if($padding){
      $out_3 = 'padding:'.$padding.';';
    }

    if($margin){
      $out_4 = 'margin:'.$margin.';';
    }

    if($class){
      $class_out = ' class="'.$class.'"';
    }

  return '<section '.$class_out.' visible-'.$visible.' style="'.$out_1.$out_2.$out_3.$out_4.'">'.do_shortcode( $content ).'</section>';
}

/*-----------------------------------------------------------------------------------*/
/*  Accordion
/*-----------------------------------------------------------------------------------*/
function er_leaf_accordion_wrap( $atts, $content = null ){
  extract(shortcode_atts(array(), $atts));

  $out = '';
  $out .= '<div class="accordion">';
  $out .= do_shortcode( $content );
  $out .= '</div>';

  return $out;
}

function er_leaf_accordion_item( $atts, $content = null ){
  extract(shortcode_atts(array(
      'id'         => '',
      'title'      => '',
  ), $atts));

  $id = er_leaf_rand_string(8);

  $out = '';
  $out .= '<h4 class="title"><a href="#'.$id.'" class="">'.$title.'</a></h4>';
  $out .= '<div id="'.$id.'" class="inner">';
  $out .= do_shortcode( $content );
  $out .= '</div>';

  return $out;
}

/*-----------------------------------------------------------------------------------*/
/*  Button
/*-----------------------------------------------------------------------------------*/
function er_leaf_buttons( $atts, $content = null ) {
    extract(shortcode_atts(array(
      'link'      => '#',
      'size'      => 'medium',
      'target'    => '_self',
      'color'     => 'color',
      'icon'    => ''
    ), $atts));
    
    if($icon == '') {
      $return2 = "";
    }
    else{
      $return2 = "<i class='icon-".$icon."'></i>";
    }
    $out = '<a href="'. $link.'" target="'.$target.'" class="button '.$size.' '.$color.'">'. do_shortcode($content). $return2 .'</a>';
  return $out;
}

/*-----------------------------------------------------------------------------------*/
/*  Useful HTML Tags
/*-----------------------------------------------------------------------------------*/

// Break Tag
function er_leaf_br() {
  return '<br />';
}

// Clear Tag
function er_leaf_clear() {
  return '<div class="clear"></div>';
}

/*-----------------------------------------------------------------------------------*/
/*  Divider
/*-----------------------------------------------------------------------------------*/
function er_leaf_divider( $atts, $content = null ){
    extract(shortcode_atts(array(
      'style'      => '1',
      'class'      => '',
    ), $atts));

    if($style == 1){
      $out_style  = '';
    } else {
      $out_style = 'strip';
    }

    $out = '<div class="'.$class.' divider clearfix '.$out_style.'"></div>';
    return $out;
}

/*-----------------------------------------------------------------------------------*/
/*  Tooogle
/*-----------------------------------------------------------------------------------*/
function er_leaf_toggle( $atts, $content = null ){
  extract(shortcode_atts(array(
      'title'      => '',
    ), $atts));

  $out = '<div class="toggle"><h4 class="title">'.$title.'</h4><div class="panel"><p>'.do_shortcode( $content ).'</p></div></div>';

  return $out;
}
add_shortcode('toggle', 'er_leaf_toggle');
/*-----------------------------------------------------------------------------------*/
/*  Skillbar
/*-----------------------------------------------------------------------------------*/
function er_leaf_skill_bar( $atts, $content = null ){
  extract(shortcode_atts(array(
      'title'      => '',
      'percent'    => '',
    ), $atts));

  $out = '<span class="skill-title">'.$title.'</span><div class="skill-bar"><div style="width: '.$percent.'%;" class="skill-bar-content" data-percentage="'.$percent.'">'.$percent.'%</div></div>';

  return $out;
}
add_shortcode('skill', 'er_leaf_skill_bar');

/*-----------------------------------------------------------------------------------*/
/*  Progress Bar
/*-----------------------------------------------------------------------------------*/
function er_leaf_progress_bar( $atts, $content = null ){
   extract(shortcode_atts(array(
      'color'      => '',
      'percent'    => '',
    ), $atts));

   $out = '<div class="chart" data-percent="'.$percent.'" data-barcolor="#'.$color.'"><span class="percent"></span></div>';
   return $out;
}

/*-----------------------------------------------------------------------------------*/
/*  Services Box
/*-----------------------------------------------------------------------------------*/
function er_leaf_service_box( $atts, $content = null ){
  extract(shortcode_atts(array(
      'icon'          => '',
      'title'         => '',
      'button_title'  => '',
      'link'          => '',
      'target'        => '_self'
  ), $atts));

  $out = '<div class="service-box hover">
            <div class="icon-box">
              <i class="icon-'.$icon.'"></i>
            </div>
            <h4>'.$title.'</h4>
            <p>'.do_shortcode( $content ).'</p>
            <a class="button" target="'.$target.'" href="'.$link.'">'.$button_title.'</a>
          </div>';

  return  $out;
}
add_shortcode('service', 'er_leaf_service_box');

/*-----------------------------------------------------------------------------------*/
/*  User & Team
/*-----------------------------------------------------------------------------------*/
function er_leaf_team ( $atts, $content = null){
  extract(shortcode_atts(array(
      'avatar'          => '',
      'name'            => '',
      'position'        => '',
      'facebook'        => '',
      'twitter'         => '',
      'gooogleplus'     => '',
      'pinterest'       => '',
      'linkedin'         => '',
  ), $atts));

  $fb = '';

  if($facebook){
    $fb .= '<a href="'.$facebook.'"><i class="icon-facebook"></i></a>';
  }
  if($twitter){
    $fb .= '<a href="'.$twitter.'"><i class="icon-twitter"></i></a>';
  }
  if($gooogleplus){
    $fb .= '<a href="'.$gooogleplus.'"><i class="icon-google-plus"></i></a>';
  }
  if($pinterest){
    $fb .= '<a href="'.$pinterest.'"><i class="icon-pinterest"></i></a>';
  }
  if($linkedin){
    $fb .= '<a href="'.$linkedin.'"><i class="icon-likedin"></i></a>';
  }

  $out = '<div class="user">
            <div class="user-image">
              <img alt="'.$name.'" src="'.$avatar.'">
            </div>
            <div class="user-info">
              <h4>'.$name.'</h4>
              <span class="pos">'.$position.'</span>
              <div class="user-social-profile">
                '.$fb.'
              </div>
              <p>'.do_shortcode( $content ).'</p>
            </div>
          </div>';

  return $out;
}
add_shortcode('team', 'er_leaf_team');

/*-----------------------------------------------------------------------------------*/
/*  Infobox
/*-----------------------------------------------------------------------------------*/
function er_leaf_infobox( $atts, $content = null ){
  extract(shortcode_atts(array(
      'image'          => '',
      'title'          => '',
      'button_title'   => '',
      'button_size'    => 'normal',
      'button_color'   => 'color',
      'target'         => '',
      'link'           => '',
  ), $atts));

  $out = '<div class="infobox"><div class="infobox-images"><a href="'.$link.'"><img alt="'.$title.'" src="'.$image.'"></a></div><div class="infobox-content"><h4>'.$title.'</h4><p>'.do_shortcode( $content ).'</p><p class="no-margin"><a class="'.$button_color.' button '.$button_size.'" href="'.$link.'">'.$button_title.'</a></p></div></div>';

  return $out;
}

/*-----------------------------------------------------------------------------------*/
/*  Callout
/*-----------------------------------------------------------------------------------*/
function er_leaf_callout( $atts, $content = null ){
  extract(shortcode_atts(array(
      'title'          => '',
      'button_title'   => '',
      'link'           => '',
      'button_color'   => 'color',
      'color'          => '',
      'target'         => '',
      'style'          => 1,
      'class'          => '',
  ), $atts));

  if($style == 1){
    $return = '';
  } elseif ($style == 2){
    $return = 'strip';
  } else {
    $return = 'color';
  }

  if($link && $button_title){
    $button = '<div class="action"><a href="'.$link.'" target="'.$target.'" class="button '.$button_color.'">'.$button_title.'</a></div>';
  } else {
    $button = '';
  }

  $out = '<div class="callout '.$color.' '.$class.' clearfix '.$return.'"><div class="callout-content clearfix"><div class="info"><h4>'.$title.'</h4><p>'.do_shortcode( $content ).'</p></div>'.$button.'</div></div>';

  return $out;
}

/*-----------------------------------------------------------------------------------*/
/*  Images & Map Box
/*-----------------------------------------------------------------------------------*/
function er_leaf_mapbox ($atts, $content = null){
  extract(shortcode_atts(array(
      'image'          => '',
      'title'          => '',
      'button_title'   => '',
      'button_icon'    => '',
      'link'           => '',
      'button_color'   => 'color',
      'target'         => '_self',
      'desc'           => '',
      'class'          => '',
  ), $atts));

  if($button_icon){
    $out_button = '<i class="icon-'.$button_icon.'"></i>';
  }

  $out = '<div class="contact-block '.$class.' clearfix">
            <div class="google_map">
              <div class="responsive-image">
                '.do_shortcode( $content ).'
              </div>
            </div>
            <div class="contact-info">
              <div class="inner-content">
                <h5>'.$title.'</h5>
                <p>'.$desc.'</p>
                <a class="button '.$button_color.'" target="'.$target.'" href="'.$link.'">'.$button_title.' '.$out_button.'</a>
              </div>
            </div>
            <div class="images-background">
              <img alt="" src="'.$image.'">
            </div>
          </div>';
  return  $out;
}
add_shortcode('mapbox', 'er_leaf_mapbox');
/*-----------------------------------------------------------------------------------*/
/*  Notifications
/*-----------------------------------------------------------------------------------*/
function er_leaf_notifications ($atts, $content = null){
  extract(shortcode_atts(array(
      'type'          => '',
      'close'         => 'true',
      'class'         => '',
  ), $atts));

  $close_out = '';
  
  if($close == "true"){
    $close_out = '<a class="close" href="#"><i class="icon-remove"></i></a>';
  }


  $out = '<div class="notification '.$type.' '.$class.'"><p>'.do_shortcode( $content ).'</p>'.$close_out.'</div>';
  return $out;
}

/*-----------------------------------------------------------------------------------*/
/*  Blockquote
/*-----------------------------------------------------------------------------------*/
function er_leaf_blockquote ($atts, $content = null){
  extract(shortcode_atts(array(
      'style'          => 1,
  ), $atts));

  if($style == 2){
    $style_out = ' class="quote"';
  }

  $out = '<blockquote'.$style_out.'>'.do_shortcode( $content ).'</blockquote>';
  return $out;
}

/*-----------------------------------------------------------------------------------*/
/*  High Light
/*-----------------------------------------------------------------------------------*/
function er_leaf_high_light ($atts, $content = null){
  extract(shortcode_atts(array(
      'color'          => 'color',
  ), $atts));

  $out = '<span class="highlight '.$color.'">'.do_shortcode( $content ).'</span>';
  return $out;
}

/*-----------------------------------------------------------------------------------*/
/*  Vertical Menu
/*-----------------------------------------------------------------------------------*/
function er_leaf_vertical_menu($atts, $content = null){
  extract(shortcode_atts(array(), $atts));

  $out = '<div class="menu-vertical">'.do_shortcode( $content ).'</div>';

  return $out;
}

/*-----------------------------------------------------------------------------------*/
/*  Google Fonts
/*-----------------------------------------------------------------------------------*/
function er_leaf_googlefont( $atts, $content = null) {
  extract( shortcode_atts( array(
        'font' => 'Swanky and Moo Moo',
        'size' => '42px',
        'margin' => '0px'
      ), $atts ) );
      
      $google = preg_replace("/ /","+",$font);
      
      return '<link href="http://fonts.googleapis.com/css?family='.$google.'" rel="stylesheet" type="text/css">
            <div class="googlefont" style="font-family:\'' .$font. '\', serif !important; font-size:' .$size. ' !important; margin: ' .$margin. ' !important;">' . do_shortcode($content) . '</div>';
}

/*-----------------------------------------------------------------------------------*/
/*  Video
/*-----------------------------------------------------------------------------------*/
function er_leaf_video($atts) {
  extract(shortcode_atts(array(
    'type'  => '',
    'id'  => '',
    'width'   => false,
    'height'  => false,
    'autoplay'  => ''
  ), $atts));
  
  if ($height && !$width) $width = intval($height * 16 / 9);
  if (!$height && $width) $height = intval($width * 9 / 16);
  if (!$height && !$width){
    $height = 380;
    $width = 760;
  }
  
  $autoplay = ($autoplay == 'yes' ? '1' : false);
    
  if($type == "vimeo") $return = "<div class='video-embed'><iframe src='http://player.vimeo.com/video/$id?autoplay=$autoplay&amp;title=0&amp;byline=0&amp;portrait=0' width='$width' height='$height' class='iframe'></iframe></div>";
  
  else if($type == "youtube") $return = "<div class='video-embed'><iframe src='http://www.youtube.com/embed/$id?HD=1;rel=0;showinfo=0' width='$width' height='$height' class='iframe'></iframe></div>";
      
  if (!empty($id)){
    return $return;
  }
}

/*-----------------------------------------------------------------------------------*/
/*  Google Maps
/*-----------------------------------------------------------------------------------*/
add_action('wp_head', 'gmaps_header');
 
function gmaps_header() {
  ?>
  <script type="text/javascript" src="https://maps.google.com/maps/api/js?sensor=false"></script>
  <?php
}
function er_leaf_map($atts) {

  // default atts
  $atts = shortcode_atts(array( 
    'lat'   => '0', 
    'lon'    => '0',
    'id' => 'map',
    'z' => '1',
    'w' => '400',
    'h' => '300',
    'maptype' => 'ROADMAP',
    'address' => '',
    'kml' => '',
    'kmlautofit' => 'yes',
    'marker' => '',
    'markerimage' => '',
    'traffic' => 'no',
    'bike' => 'no',
    'fusion' => '',
    'start' => '',
    'end' => '',
    'infowindow' => '',
    'infowindowdefault' => 'yes',
    'directions' => '',
    'hidecontrols' => 'false',
    'scale' => 'false',
    'scrollwheel' => 'true',
    'style' => ''   
  ), $atts);
                  
  $returnme = '<div id="' .$atts['id'] . '" style="width:' . $atts['w'] . 'px;height:' . $atts['h'] . 'px;" class="google_map ' . $atts['style'] . '"></div>';
  
  //directions panel
  if($atts['start'] != '' && $atts['end'] != '') 
  {
    $panelwidth = $atts['w']-20;
    $returnme .= '<div id="directionsPanel" style="width:' . $panelwidth . 'px;height:' . $atts['h'] . 'px;border:1px solid gray;padding:10px;overflow:auto;"></div><br>';
  }

  $returnme .= '
  <script type="text/javascript">
    var latlng = new google.maps.LatLng(' . $atts['lat'] . ', ' . $atts['lon'] . ');
    var myOptions = {
      zoom: ' . $atts['z'] . ',
      center: latlng,
      scrollwheel: false,
      navigationControl: false,
      mapTypeControl: false,
      scaleControl: false,
      draggable: false,
      scrollwheel: ' . $atts['scrollwheel'] .',
      scaleControl: ' . $atts['scale'] .',
      disableDefaultUI: ' . $atts['hidecontrols'] .',
      mapTypeId: google.maps.MapTypeId.' . $atts['maptype'] . '
    };
    var ' . $atts['id'] . ' = new google.maps.Map(document.getElementById("' . $atts['id'] . '"),
    myOptions);
    ';
        
    //kml
    if($atts['kml'] != '') 
    {
      if($atts['kmlautofit'] == 'no') 
      {
        $returnme .= '
        var kmlLayerOptions = {preserveViewport:true};
        ';
      }
      else
      {
        $returnme .= '
        var kmlLayerOptions = {preserveViewport:false};
        ';
      }
      $returnme .= '
      var kmllayer = new google.maps.KmlLayer(\'' . html_entity_decode($atts['kml']) . '\',kmlLayerOptions);
      kmllayer.setMap(' . $atts['id'] . ');
      ';
    }

    //directions
    if($atts['start'] != '' && $atts['end'] != '') 
    {
      $returnme .= '
      var directionDisplay;
      var directionsService = new google.maps.DirectionsService();
        directionsDisplay = new google.maps.DirectionsRenderer();
        directionsDisplay.setMap(' . $atts['id'] . ');
        directionsDisplay.setPanel(document.getElementById("directionsPanel"));

        var start = \'' . $atts['start'] . '\';
        var end = \'' . $atts['end'] . '\';
        var request = {
          origin:start, 
          destination:end,
          travelMode: google.maps.DirectionsTravelMode.DRIVING
        };
        directionsService.route(request, function(response, status) {
          if (status == google.maps.DirectionsStatus.OK) {
            directionsDisplay.setDirections(response);
          }
        });


      ';
    }
    
    //traffic
    if($atts['traffic'] == 'yes')
    {
      $returnme .= '
      var trafficLayer = new google.maps.TrafficLayer();
      trafficLayer.setMap(' . $atts['id'] . ');
      ';
    }
  
    //bike
    if($atts['bike'] == 'yes')
    {
      $returnme .= '      
      var bikeLayer = new google.maps.BicyclingLayer();
      bikeLayer.setMap(' . $atts['id'] . ');
      ';
    }
    
    //fusion tables
    if($atts['fusion'] != '')
    {
      $returnme .= '      
      var fusionLayer = new google.maps.FusionTablesLayer(' . $atts['fusion'] . ');
      fusionLayer.setMap(' . $atts['id'] . ');
      ';
    }
  
    //address
    if($atts['address'] != '')
    {
      $returnme .= '
        var geocoder_' . $atts['id'] . ' = new google.maps.Geocoder();
      var address = \'' . $atts['address'] . '\';
      geocoder_' . $atts['id'] . '.geocode( { \'address\': address}, function(results, status) {
        if (status == google.maps.GeocoderStatus.OK) {
          ' . $atts['id'] . '.setCenter(results[0].geometry.location);
          ';
          
          if ($atts['marker'] !='')
          {
            //add custom image
            if ($atts['markerimage'] !='')
            {
              $returnme .= 'var image = "'. $atts['markerimage'] .'";';
            }
            $returnme .= '
            var marker = new google.maps.Marker({
              map: ' . $atts['id'] . ', 
              ';
              if ($atts['markerimage'] !='')
              {
                $returnme .= 'icon: image,';
              }
            $returnme .= '
              position: ' . $atts['id'] . '.getCenter()
            });
            ';

            //infowindow
            if($atts['infowindow'] != '') 
            {
              //first convert and decode html chars
              $thiscontent = htmlspecialchars_decode($atts['infowindow']);
              $returnme .= '
              var contentString = \'' . $thiscontent . '\';
              var infowindow = new google.maps.InfoWindow({
                content: contentString
              });
                    
              google.maps.event.addListener(marker, \'click\', function() {
                infowindow.open(' . $atts['id'] . ',marker);
              });
              ';

              //infowindow default
              if ($atts['infowindowdefault'] == 'yes')
              {
                $returnme .= '
                  infowindow.open(' . $atts['id'] . ',marker);
                ';
              }
            }
          }
      $returnme .= '
        } else {
        alert("Geocode was not successful for the following reason: " + status);
      }
      });
      ';
    }

    //marker: show if address is not specified
    if ($atts['marker'] != '' && $atts['address'] == '')
    {
      //add custom image
      if ($atts['markerimage'] !='')
      {
        $returnme .= 'var image = "'. $atts['markerimage'] .'";';
      }

      $returnme .= '
        var marker = new google.maps.Marker({
        map: ' . $atts['id'] . ', 
        ';
        if ($atts['markerimage'] !='')
        {
          $returnme .= 'icon: image,';
        }
      $returnme .= '
        position: ' . $atts['id'] . '.getCenter()
      });
      ';

      //infowindow
      if($atts['infowindow'] != '') 
      {
        $returnme .= '
        var contentString = \'' . $atts['infowindow'] . '\';
        var infowindow = new google.maps.InfoWindow({
          content: contentString
        });
              
        google.maps.event.addListener(marker, \'click\', function() {
          infowindow.open(' . $atts['id'] . ',marker);
        });
        ';
        //infowindow default
        if ($atts['infowindowdefault'] == 'yes')
        {
          $returnme .= '
            infowindow.open(' . $atts['id'] . ',marker);
          ';
        }       
      }
    }
    
    $returnme .= '</script>';
    
    
    return $returnme;
}
add_shortcode('map', 'er_leaf_map');


/*-----------------------------------------------------------------------------------*/
/*  Icons & Lists
/*-----------------------------------------------------------------------------------*/

// Icons
function er_leaf_miniicon( $atts, $content = null ) {
  extract(shortcode_atts(array(
        'icon'      => 'ok'
    ), $atts));
    
  $out = '<i class="icon-'. $icon .'"></i>';
    return $out;
}

// List Wrap
function er_leaf_list( $atts, $content = null ) {
    extract(shortcode_atts(array(), $atts));
  $out = '<ul class="styled-list">'. do_shortcode($content) . '</ul>';
    return $out;
}

// List Items
function er_leaf_list_item( $atts, $content = null ) {
  extract(shortcode_atts(array(
        'icon'      => 'ok'
    ), $atts));

  if($icon){
    $icon_out = '<i class="icon-'.$icon.'"></i>';
  }

  $out = '<li>'.$icon_out. do_shortcode($content) . '</li>';
    return $out;
}

/*-----------------------------------------------------------------------------------*/
/*  Icon Block
/*-----------------------------------------------------------------------------------*/
function er_leaf_block_icon( $atts, $content = null ) {
  extract(shortcode_atts(array(
        'icon'          => 'ok',
        'title'         => '',
        'button_title'  => '',
        'button_color'  => '',
        'link'          => '',
        'target'        => '_self',
    ), $atts));
    
    $out = '<div class="block block-service"><div class="block-icon"><i class="icon-'.$icon.'"></i></div><div class="block-content"><h3>'.$title.'</h3><p>'.do_shortcode( $content ).'</p><a target="'.$target.'" class="button '.$button_color.'" href="'.$link.'">'.$button_title.'</a></div></div>';

    return $out;
}
add_shortcode('block', 'er_leaf_block_icon');

/*-----------------------------------------------------------------------------------*/
/*  Portfolio Listing
/*-----------------------------------------------------------------------------------*/
function er_leaf_portfolio_list($atts, $content = null){
  extract(shortcode_atts(array(
        'term'        => '',
        'number'      => '4',
        'carousel'    => '1',
        'column'      => '4',
        'title'       => 'Portfolio'
    ), $atts));

  $tit = '';
  $before = '';
  $after = '';
  $script = '';

  $portfolio_id = er_leaf_rand_string(8);

  $tit .= '<div class="heading-block">
            <h4>'.$title.'</h4>
            <div class="button-area">
              <a id="rp_prev_'.$portfolio_id.'" class="prev" href="#" style="display: inline-block;"><i class="icon-angle-left"></i></a>
              <a id="rp_next_'.$portfolio_id.'" class="next" href="#" style="display: inline-block;"><i class="icon-angle-right"></i></a>
            </div>
          </div>';

  $before .= '<div class="cols portfolio-archive" id="portfolio'.$portfolio_id.'">';
  $after .= '</div>';
  $script .= '<script type="text/javascript">
              jQuery(document).ready(function($){
              function po_'.$portfolio_id.'() {
                var carousel'.$portfolio_id.' = jQuery("#portfolio'.$portfolio_id.'");
                var width = jQuery(window).width();
                if(width <=220) {
                     carousel'.$portfolio_id.'.trigger("destroy");
                } else {
                  carousel'.$portfolio_id.'.carouFredSel({
                    auto: false,
                    responsive: false,
                    height : "auto",
                    prev  : {
                      button  : "#rp_prev_'.$portfolio_id.'",
                      key   : "left",
                      items   : 1
                    },
                    next  : {
                      button  : "#rp_next_'.$portfolio_id.'",
                      key   : "right",
                      items   : 1
                    },
                    auto    : {
                      play    : false,
                    },
                    items : {
                        visible     : 4,
                        width       : "100%"
                    },
                    onCreate : function () {
                      carousel'.$portfolio_id.'.parent().add(carousel'.$portfolio_id.').css("height", carousel'.$portfolio_id.'.children().first().height() + "px");
                    }
                  });
                }
              }
              
              var resizeTimer;
              jQuery(window).resize(function() {
                  clearTimeout(resizeTimer);
                  resizeTimer = setTimeout(po_'.$portfolio_id.', 0);
              }).resize();
            });
          </script>';

  $my_args=array(
    'showposts' => $number,
    'orderby' => 'date',
    'order' => 'DESC',
    'post_type' => 'portfolio',
  );

  $out = '';

  $er_portfolio_shortcode_query = new WP_Query($my_args);
  if ( $er_portfolio_shortcode_query->have_posts() ) :
    if($carousel == 1) {
    $out .= $tit;
  }
  $out .= $before;
  while ( $er_portfolio_shortcode_query->have_posts() ) : $er_portfolio_shortcode_query->the_post();
    $out .= '<div class="col-'.$column.'">';
    $out .= '<div id="portfolio-'.$portfolio_id.'-'.get_the_ID().'" class="portfolio-item">
              <div class="portfolio-content">

                <div class="portfolio-link" >
                  <a href="'.er_leaf_get_firt_meta_image('er_leaf_project_images').'" class="image-link"><i class="icon-zoom-in"></i></a>
                  <a href="'.get_permalink().'" class="detail-link"><i class="icon-link"></i></a>
                </div><!--// portfolio-link -->

                <div class="portfolio-title">
                  <h5>'.get_the_title().'</h5>
                  <span>'.er_leaf_custom_taxonomies_terms_links('portfolio_category').'</span>
                </div><!--// portfolio-title -->

              </div><!--// portfolio-content -->

              <div class="portfolio-image">
                '.get_the_post_thumbnail(get_the_ID(),'portfolio').'
              </div>
            </div>';
    $out .= '</div>';
  endwhile; wp_reset_query();
    $out .= $after;
    if($carousel == 1){
    $out .= $script;
    }
  endif;

  return $out;

}
add_shortcode('portfolio', 'er_leaf_portfolio_list');

/*-----------------------------------------------------------------------------------*/
/*  Post Listing
/*-----------------------------------------------------------------------------------*/
function er_leaf_post_list($atts, $content = null){
  extract(shortcode_atts(array(
        'cat'         => '',
        'number'      => '4',
        'column'      => '4',
        'content'     => '0'
    ), $atts));

  $my_args=array(
    'posts_per_page' => $number,
    'orderby' => 'date',
    'order' => 'DESC',
    'cat' => $cat,
    'ignore_sticky_posts' => 1
  );
    $out_r = '';
  $er_post = new WP_Query($my_args);
  if($er_post -> have_posts() ) : 
    $out_r .= '<div class="cols list-blog shortcode_post">';
    while ($er_post->have_posts()) : $er_post->the_post();
    $out_r .= '<div class="col-'.$column.'">';
    if(has_post_thumbnail())
    $out_r .= '<div class="blog-item-image">
                <div class="blog-item-image-cover">
                  <div class="blog-item-image-cover-link">
                    <a rel="bookmark" href="'.get_permalink().'" class=""><i class="icon-plus"></i></a>
                  </div>
                </div>
                '.get_the_post_thumbnail(get_the_ID(),'post').'
              </div>';
    $out_r .= '<div class="blog-item-content">
                <h4 class="entry-title">
                  <a rel="bookmark" title="'.get_the_title().'" href="'.get_permalink().'">'.get_the_title().'</a>
                </h4>
              </div>';
    $out_r .= '<div class="entry-meta separate alternative">
                <time class="published updated" datetime="'.get_the_date( 'c' ).'">
                  <i class="icon-time"></i>'.human_time_diff( get_the_time('U'), current_time('timestamp') ) . ' ago 
                </time>
                <span class="author vcard"><i class="icon-pencil"></i><a class="url fn n" href="'.esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ).'" title="'.esc_attr( sprintf( __( 'View all posts by %s', 'er_leaf' ), get_the_author() ) ).'" rel="author">'.get_the_author().'</a></span>
              </div>';
    if($content == 1)
    $out_r .= '<div class="entry-summary">'.er_leaf_custom_excerpt(20).'</div>';
    $out_r .= '</div>';
  endwhile;
    $out_r .= '</div>';
  endif;wp_reset_query();
  return $out_r;
}
add_shortcode('posts', 'er_leaf_post_list');

/*-----------------------------------------------------------------------------------*/
/*  Small Post Listing
/*-----------------------------------------------------------------------------------*/
function er_leaf_small_post_list($atts, $content = null){
  extract(shortcode_atts(array(
        'cat'         => '',
        'number'      => '4',
        'offset'         => '0',
        'ignore_sticky_posts' => 1,
        'title'     => '',
        'class'     => ''
    ), $atts));

  if($title){
    $out_title = '<h6>'.$title.'</h6>';
  }

  $my_args=array(
    'posts_per_page' => $number,
    'orderby' => 'date',
    'order' => 'DESC',
    'cat' => $cat,
    'offset' => $offset
  );

  $out = '';

  $er_post = new WP_Query($my_args);
  if($er_post -> have_posts() ) : 
    $out .= '<div class="related-blog-item '.$class.'">';
    $out .= $out_title;
    $out .= '<ul>';
    while ($er_post->have_posts()) : $er_post->the_post();
    $out .= '<li>';
    $out .= '<time datetime="'.get_the_date('c').'" class="updated">'.human_time_diff( get_the_time('U'), current_time('timestamp') ).' ago</time>';
    $out .= '<a href="'.get_permalink().'">'.the_title( '','', false ).'</a>';
    $out .= '</li>';
    endwhile;
    $out .= '</ul>';
    $out .= '</div>';
  endif;wp_reset_query();

  return $out;
}
add_shortcode('postlist', 'er_leaf_small_post_list');

/*-----------------------------------------------------------------------------------*/
/*  Prcing Table
/*-----------------------------------------------------------------------------------*/
function er_leaf_pricing_table($atts, $content = null){
    extract(shortcode_atts(array(
        'style'        => 1,
        'color'        => 'color',
        'title'        => '',
        'desc'         => '',
        'price'        => '',
        'currency'     => '',
        'per'          => '',
        'price_desc'   => '',
        'link'         => '',
        'target'       => '',
        'button_title' => '',
    ), $atts));

    if ($style == 1) {
    $out = '<div class="pricing '.$color.'">
              <h4 class="pricing-title">'.$title.'</h4>
              <div class="price">
                <h3>
                    <span class="prices">'.$price.'</span>
                    <span class="currency">'.$currency.'</span>
                </h3>
                <span class="clearfix">'.$price_desc.'</span>
              </div>
              <div class="features">
                '.do_shortcode( $content ).'
              </div>
              <div class="action">
                <a href="'.$link.'" target="'.$target.'" class="button">'.$button_title.'</a>
              </div>
            </div>';
    } else {
      $out = '<div class="pricing-alternative '.$color.'">
                <div class="title">
                  <h4>'.$title.'</h4>
                  <span>'.$desc.'</span>
                </div>
                <h3 class="price-title">
                  <span class="currency">'.$currency.'</span>
                  <span class="price">'.$price.'</span>
                  <span class="per">/'.$per.'</span>
                </h3>
                <div class="details">
                  <a class="button yellow block" target="'.$target.'" href="'.$link.'">'.$button_title.'</a>
                    '.do_shortcode( $content ).'
                </div>
              </div>';
    }

    return $out;
}
add_shortcode('pricing', 'er_leaf_pricing_table');
/*-----------------------------------------------------------------------------------*/
/*  Tabs
/*-----------------------------------------------------------------------------------*/

function er_leaf_tabgroup( $atts, $content = null ) {
  extract(shortcode_atts(array(
      'style' => 1,
  ), $atts));

  if($style ==1 ) {
    $class1 = 'tabs main';
    $class2 = '';
    $class3 = '';
  } elseif ($style == 2){
    $class1 = 'tabs alternative clearfix';
    $class2 = '<div class="tabs-content">';
    $class3 = '</div>';
  } else {
    $class1 = 'tabs center';
    $class2 = '';
    $class3 = '';
  }

  $GLOBALS['tab_count'] = 0;
  $i = 1;
  $randomid = rand();

  do_shortcode( $content );

  if( is_array( $GLOBALS['tabs'] ) ){
  
    foreach( $GLOBALS['tabs'] as $tab ){  
      if( $tab['icon'] != '' ){
        $icon = '<i class="icon-'.$tab['icon'].'"></i>';
      }
      else{
        $icon = '';
      }
      $tabs[] = '<li class="tab"><a href="#panel'.$randomid.$i.'">'.$icon . $tab['title'].'</a></li>';
      $panes[] = '<div class="tabs-container" id="panel'.$randomid.$i.'"><p>'.$tab['content'].'</p></div>';
      $i++;
      $icon = '';
    }
    $return = '<div class="tabset '.$class1.'"><ul class="tabNavigation clearfix">'.implode( "\n", $tabs ).'</ul>'.$class2.implode( "\n", $panes ).$class3.'</div>';
  }
  return $return;
}

function er_leaf_tab( $atts, $content = null) {
  extract(shortcode_atts(array(
      'title' => '',
      'icon'  => ''
  ), $atts));
  
  $x = $GLOBALS['tab_count'];
  $GLOBALS['tabs'][$x] = array( 'title' => sprintf( $title, $GLOBALS['tab_count'] ), 'icon' => $icon, 'content' =>  $content );
  $GLOBALS['tab_count']++;
}

/*-----------------------------------------------------------------------------------*/
/*  Slider
/*-----------------------------------------------------------------------------------*/

function er_leaf_custom_slider(){
  er_leaf_show_slide();
}

/*-----------------------------------------------------------------------------------*/
/*  Portfolio Infomation Fields
/*-----------------------------------------------------------------------------------*/
function er_leaf_portfolio_field( $atts, $content = null ){
  extract(shortcode_atts(array(
      'title' => '',
  ), $atts));

  $out = '<li><span class="title">'.$title.'</span><span class="info">'.do_shortcode( $content ).'</span></li>';

  return $out;
}

/*-----------------------------------------------------------------------------------*/
/*  Images Slider
/*-----------------------------------------------------------------------------------*/
function er_leaf_imgslider($atts, $content = null){
    extract(shortcode_atts(array(), $atts));

    $out = '<div class="slider flexslider"><ul class="slides">'.do_shortcode( $content ).'</ul></div>';
    
    return $out;
}

function er_leaf_imgslider_img($atts, $content = null){
    extract(shortcode_atts(array(
      'image' => '',
      'link'   => '',
      'target' => '_self'
    ), $atts));

    $before = '';
    $after = '';

    if($link){
      $before = '<a target="'.$target.'" href="'.$link.'">';
      $after = '</a>';
    }

    $slide = '<li>'.$before.'<img src="'.$image.'" alt=""/>'.$after.'</li>';

    return $slide;
}

/*-----------------------------------------------------------------------------------*/
/*  Dropcap
/*-----------------------------------------------------------------------------------*/
function er_leaf_dropcap($atts, $content = null){
  extract(shortcode_atts(array(
    'style' => ''
  ), $atts));

  return '<span class="dropcap '.$style.'">'.do_shortcode( $content ).'</span>';
}

/*-----------------------------------------------------------------------------------*/
/*  High Light
/*-----------------------------------------------------------------------------------*/
function er_leaf_highlight($atts, $content = null){
  extract(shortcode_atts(array(
    'color' => ''
  ), $atts));

  return '<span class="highlight '.$color.'">'.do_shortcode( $content ).'</span>';
}

/*-----------------------------------------------------------------------------------*/
/*  Heading
/*-----------------------------------------------------------------------------------*/
function er_leaf_heading($atts, $content = null){
  extract(shortcode_atts(array(
    'title' => '',
    'class' => '',
  ), $atts));

  return '<div class="heading-block '.$class.'"><h4>'.$title.'</h4></div>';
}

function shortcode_the_site_url( $atts ){
    return site_url();
}
add_shortcode( 'site_url', 'shortcode_the_site_url' );

function pre_process_shortcode($content) {
    global $shortcode_tags;
 
    // Backup current registered shortcodes and clear them all out
    $orig_shortcode_tags = $shortcode_tags;
    
    remove_all_shortcodes();
    
    add_shortcode('accordion', 'er_leaf_accordion_wrap');
    add_shortcode('accordion_item', 'er_leaf_accordion_item');
    add_shortcode('br', 'er_leaf_br');
    add_shortcode('clear', 'er_leaf_clear');
    add_shortcode('divider', 'er_leaf_divider');
    add_shortcode('dropcap', 'er_leaf_dropcap');
    add_shortcode('highlight', 'er_leaf_highlight');
    add_shortcode('button', 'er_leaf_buttons');

    add_shortcode('progress', 'er_leaf_progress_bar');

    add_shortcode('infobox', 'er_leaf_infobox');
    add_shortcode('callout', 'er_leaf_callout');

    add_shortcode('notification', 'er_leaf_notifications');
    add_shortcode('vmenu', 'er_leaf_vertical_menu');
    add_shortcode('googlefont', 'er_leaf_googlefont');
    add_shortcode('video', 'er_leaf_video');

    add_shortcode('icon', 'er_leaf_miniicon');
    add_shortcode('list', 'er_leaf_list');
    add_shortcode('list_item', 'er_leaf_list_item');

    add_shortcode('blockquote', 'er_leaf_blockquote');
    add_shortcode('hl', 'er_leaf_high_light');

    add_shortcode('tab', 'er_leaf_tab');
    add_shortcode('tabgroup', 'er_leaf_tabgroup');

    add_shortcode('slider', 'er_leaf_custom_slider');
    add_shortcode('field', 'er_leaf_portfolio_field');
    add_shortcode('section', 'er_leaf_section');

    add_shortcode('imgslider', 'er_leaf_imgslider');
    add_shortcode('slide', 'er_leaf_imgslider_img');
    add_shortcode('heading', 'er_leaf_heading');

    add_shortcode( 'cols', 'er_leaf_cols' );
    add_shortcode( 'col-1', 'er_leaf_col_1' );
    add_shortcode( 'col-2', 'er_leaf_col_2' );
    add_shortcode( 'col-3', 'er_leaf_col_3' );
    add_shortcode( 'col-4', 'er_leaf_col_4' );
    add_shortcode( 'col-5', 'er_leaf_col_5' );
    add_shortcode( 'col-6', 'er_leaf_col_6' );
    add_shortcode( 'col-7', 'er_leaf_col_7' );
    add_shortcode( 'col-8', 'er_leaf_col_8' );
    add_shortcode( 'col-9', 'er_leaf_col_9' );
    add_shortcode( 'col-10', 'er_leaf_col_10' );
    add_shortcode( 'col-11', 'er_leaf_col_11' );
    add_shortcode( 'col-12', 'er_leaf_col_12' );

 
    // Do the shortcode (only the one above is registered)
    $content = do_shortcode($content);
 
    // Put the original shortcodes back
    $shortcode_tags = $orig_shortcode_tags;
 
    return $content;
}
add_filter('the_content', 'pre_process_shortcode', 7);
add_filter('widget_text', 'pre_process_shortcode', 7);

?>