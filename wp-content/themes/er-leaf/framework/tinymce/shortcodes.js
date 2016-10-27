/* SET LOCALIZED VARIABLES */
var columns_title       = 'Columns';
var elements_title      = 'Elements';
var helpers_title       = 'Helper';

var cols_title          = 'Columns Wrap';
var col_1_title         = 'Col-1';
var col_2_title         = 'Col-2';
var col_3_title         = 'Col-3';
var col_4_title         = 'Col-4';
var col_5_title         = 'Col-5';
var col_6_title         = 'Col-6';
var col_7_title         = 'Col-7';
var col_8_title         = 'Col-8';
var col_9_title         = 'Col-9';
var col_10_title        = 'Col-10';
var col_11_title        = 'Col-11';
var col_12_title        = 'Col-12';

var accordion_title     = 'Accordion';
var notification_title  = 'Notification';
var button_title        = 'Button';
var toggle_title        = 'Toggle';
var skill_title         = 'Skill';
var progress_title      = 'Progress';
var service_title       = 'Service';
var team_title          = 'Team';
var infobox_title       = 'Infobox';
var callout_title       = 'Callout';
var mapbox_title        = 'Mapbox';
var vmenu_title         = 'Vmenu';
var googlefont_title    = 'Google Font';
var video_title         = 'Video';
var map_title           = 'Map';
var icon_title          = 'Icon';
var list_title          = 'List';
var block_title         = 'Block';
var blockquote_title    = 'Blockquote';
var pricing_title       = 'Pricing';
var tab_title           = 'Tab';
var posts_title         = 'Posts';
var postlist_title      = 'Postlist';
var portfolio_title     = 'Portfolio';
var slider_title		= 'Slider';
var imgslider_title		= 'Slider Images';
var dropcap_title		= 'Dropcap';
var highlight_title		= 'High light';
var heading_title		= 'Heading';

var section_title       = 'Section';
var clear_title         = 'Clear';
var divider_title       = 'Divider';
var raw_title           = 'Raw';
var br_title            = 'Break';

(function() {
	tinymce.create('tinymce.plugins.shortcodes', {
    createControl : function(n, cm) {
			if(n=='columns'){
				
                var clb = cm.createListBox('columns', {
                     title : columns_title,
                     onselect : function(v) { 
					 
						         tinyMCE.execCommand('mceInsertContent',false,v); 
						                                       
                     }
                });
 
                clb.add(cols_title, '[cols][/cols]');
                clb.add(col_1_title, '[col-1][/col-1]');
                clb.add(col_2_title, '[col-2][/col-2]');
                clb.add(col_3_title, '[col-3][/col-3]');
                clb.add(col_4_title, '[col-4][/col-4]');
                clb.add(col_5_title, '[col-5][/col-5]');
                clb.add(col_6_title, '[col-6][/col-6]');
                clb.add(col_7_title, '[col-7][/col-7]');
                clb.add(col_8_title, '[col-8][/col-8]');
                clb.add(col_9_title, '[col-9][/col-9]');
                clb.add(col_10_title, '[col-10][/col-10]');
                clb.add(col_11_title, '[col-11][/col-11]');
                clb.add(col_12_title, '[col-12][/col-12]');
				
                return clb;
             }
 
			if(n=='elements'){
				
                var mlb = cm.createListBox('elements', {
                     title : elements_title,
                     onselect : function(v) { //Option value as parameter
					 
						         tinyMCE.execCommand('mceInsertContent',false,v);
						                                       
                     }
                });
 

				mlb.add(accordion_title, '[accordion]<br /> [accordion_item title="Accordion Title"]Your Content Here[/accordion_item]<br />[/accordion]');
				mlb.add(button_title, '[button link="#" size="normal" target="_self" color="color" icon=""]Button Title[/button]');
				mlb.add(block_title,'[block icon="ok" title="" button_title="" button_color="color" link="#" target="_self"]<br/>Block Content<br/>[/block]');
				mlb.add(blockquote_title,'[blockquote style="1"]<br/>Add your content here<br/>[/blockquote]');
				mlb.add(callout_title,'[callout class="" color="color/red/yellow/green/blue/black" style="1/2/3" title="" button_title="" button_color="color" link="#" target="_self"]<br/>Callout content<br/>[/callout]');
				mlb.add(dropcap_title,'[dropcap style="square/round"]content[/dropcap]');
				mlb.add(highlight_title,'[highlight color=""]content[/highlight]');
				mlb.add(notification_title, '[notification type="info/warning/notice/error" close="true/false"]Your content here ... [/notification]');
				mlb.add(heading_title,'[heading title="Heading Title"][/heading]');
				mlb.add(list_title,'[list]<br/>[list_item icon="ok"]List Item[/list_item]<br/>[/list]');
				mlb.add(tab_title,'[tabgroup]<br/>[tab title="Tab title" icon="ok"]Tab Content[/tab]<br/>[/tabgroup]');
				mlb.add(team_title,'[team avatar="" name="" position="" facebook="" twitter="" googleplus="" pinterest="" linkedin=""]<br/> Edit detail of person ... <br/>[/team]');
				mlb.add(toggle_title,'[toggle title="Toggle Title"]<br/>Edit toggle content here ... <br/>[/toggle]');
				mlb.add(mapbox_title,'[mapbox image="" title="" button_title="" button_color="" button_icon="" target="" desc=""]<br/>Add your map shortcode here or leave blank<br/>[/mapbox]');
				mlb.add(map_title,'[map lat="" lon="" id="map" z="1" w="400" h="300" maptype="ROADMAP" address="" kml="" marker="" markerimage="" traffic="no" bike="no" infowindown="" infowindowndefault="yes" directions="" hidecontrols="false" scale="false" scrollwheel="true" style=""][/map]');
				mlb.add(googlefont_title,'[googlefont font="Open Sans" size="12px" margin="0"]<br/>Add your content here<br/>[/googlefont]');
				mlb.add(infobox_title,'[infobox image="" title="" button_title="" button_size="normal" button_color="color" target="_self" link="#"]<br/>Edit your info here ... <br/>[/infobox]');
				mlb.add(icon_title,'[icon icon="ok"][/icon]');
				mlb.add(imgslider_title,'[imgslider]<br/>[slide image="" link="" target=""][/slide]<br/>[/imgslider]');
				mlb.add(progress_title,'[progress color="000000" percent=""]');
				mlb.add(pricing_title,'[pricing style="1" color="color" title="" desc="" price="" currency="" per="" price_desc="" link="#" target="_self" button_title=""]<br/>Pricing Detail<br/>[/pricing]');
				mlb.add(posts_title,'[posts cat="" number="4" column="4"][/posts]');
				mlb.add(postlist_title,'[postlist title="" cat="" number="" offset=""][/postlist]');
				mlb.add(portfolio_title,'[portfolio term="" number="4" carousel="1" column="4" title="Portfolio"][/portfolio]');
				mlb.add(skill_title,'[skill title="" percent=""][/skill]');
				mlb.add(service_title,'[service icon="" title="" button_title="" link="#" target="_self"]<br/>Edit serice content here ... <br/>[/service]');
				mlb.add(vmenu_title,'[vmenu]<br/>Edit menu listing here<br/>[/vmenu]');
				mlb.add(video_title,'[video type="youtube/vimeo" id="" width="" height="" autoplay=""][/video]');
				mlb.add(slider_title,'[slider]')

                return mlb;
             }
			 
			 if(n=='helpers'){
				
                var mlb = cm.createListBox('helpers', {
                     title : helpers_title,
                     onselect : function(v) { //Option value as parameter
					 
						         tinyMCE.execCommand('mceInsertContent',false,v);
						                                       
                     }
                });
				
				mlb.add(section_title, '[section bg_color="" visible="all/mobile/tablet/desktop" border_color="" padding="" margin="" class=""]<br/>Content here<br/>[/section]');
				mlb.add(clear_title, '[clear]');
                mlb.add(divider_title, '[divider style="1" class=""][/divider]');
				mlb.add(raw_title, '[raw][/raw]');
				mlb.add(br_title, '[br]');

                return mlb;
             }
			 
      return null;
		}
	});
 
	tinymce.PluginManager.add('shortcodes', tinymce.plugins.shortcodes);
	
})();
