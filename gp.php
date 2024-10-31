<?

/*
Plugin Name: New Google Plus One Button
Plugin URI: http://www.video2mp3.de/
Description: The Google Plus One Plugin adds to every post a Google Plus One Button.
Version: 1.0
Author: Michael Proft
Author URI: http://www.video2mp3.de/
License: GPL2
*/

/*  Copyright 2011 Michael Proft  (email : info@video2mp3.de)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License, version 2, as 
    published by the Free Software Foundation.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

class Social {
		
   public function __construct() {
   	if(is_admin()) {
         add_action('admin_menu', array(&$this, 'SetUp'));      	
         add_action('admin_init', array(&$this, 'Register'));
      } else {
      	add_filter('the_content', array(&$this, 'Add'));
      }
   }

   public function SetUp() {
      add_submenu_page('plugins.php',
                       'Google Plus One Settings',
                       'Google Plus One',
                       'administrator',
                       'gpo-settings',
                       array(&$this, 'GpoForm'));   	
   }   
   
   
   public function Register() {
      register_setting('gpo_settings', 'GPO Settings');   	
   }

   public function GpoForm() {
      if($_POST['gpo_size']) {
         $Size = array(1 => 'default', 
      	              2 => 'small', 
      	              3 => 'medium', 
      	              4 => 'tall');
         update_option('GPO Settings', array('size' => $Size[intval($_POST['gpo_size'])]));
      }
   	$Form = '<script type="text/javascript" src="../wp-content/plugins/google-plus-one/jquery.js"></script>
   	         <script type="text/javascript" src="../wp-content/plugins/google-plus-one/gpo.js"></script>
   	         <div style="font-size:16px;margin-top:11px;">
   	          <strong>Google Plus One Settings</strong>
   	         </div>
   	         <div style="margin:11px 0px 11px 0px;">Here you are able to edit the Google Plus One Settings.</div>
   	         <form action="plugins.php?page=gpo-settings" method="post">
   	          <div style="float:left;height:60px;margin-top:4px;">
   	           Button Size: 
   	          </div>
   	          <div style="float:left;height:60px;margin-left:4px;">
   	           <select id="gpo_size" name="gpo_size" style="width:85px;">
   	            <option value="1"[SIZE_D]>Default</a>
   	            <option value="2"[SIZE_S]>Small</a>
   	            <option value="3"[SIZE_M]>Medium</a>
   	            <option value="4"[SIZE_T]>Tall</a>
   	           </select>
   	          </div>
   	          <div style="float:left;height:60px;margin-left:24px;">
   	           <img id="gpo_image" src="../wp-content/plugins/google-plus-one/[IMAGE].png" alt="Default" />
   	          </div>
   	          <div style="clear:both;"></div>
   	          <div style="margin-top:11px;">
   	           <input type="submit" value="Save Settings" class="button-primary" />
   	          </div>
   	         </form>';
   	$Button = get_option('GPO Settings');
   	if($Button['size']) {
   	   switch($Button['size']){
   		   case 'default':
   		      $Form = str_replace('[SIZE_D]', 'selected="selected"', $Form);
   		      $Form = str_replace('[SIZE_S]', '', $Form);
   		      $Form = str_replace('[SIZE_M]', '', $Form);
   		      $Form = str_replace('[SIZE_T]', '', $Form);
   		      $Form = str_replace('[IMAGE]',  'default', $Form);
   		   break;
   		   case 'small':
   		      $Form = str_replace('[SIZE_D]', '', $Form);
   		      $Form = str_replace('[SIZE_S]', 'selected="selected"', $Form);
   		      $Form = str_replace('[SIZE_M]', '', $Form);
   		      $Form = str_replace('[SIZE_T]', '', $Form);
   		      $Form = str_replace('[IMAGE]',  'small', $Form);   		   	
   	      break;
   		   case 'medium':
   		      $Form = str_replace('[SIZE_D]', '', $Form);
   		      $Form = str_replace('[SIZE_S]', '', $Form);
   		      $Form = str_replace('[SIZE_M]', 'selected="selected"', $Form);
   		      $Form = str_replace('[SIZE_T]', '', $Form);
   		      $Form = str_replace('[IMAGE]',  'medium', $Form);   		   	
   		   break;
   		   case 'tall':
   		      $Form = str_replace('[SIZE_D]', '', $Form);
   		      $Form = str_replace('[SIZE_S]', '', $Form);
   		      $Form = str_replace('[SIZE_M]', '', $Form);
   		      $Form = str_replace('[SIZE_T]', 'selected="selected"', $Form);
   		      $Form = str_replace('[IMAGE]',  'tall', $Form);   		   	
   		   break;   		
   	   }
   	}
   	print $Form;
   }
   
   public function Add($wordpresscontent=false) {
   	$Container = '<div id="social">[BUTTON]</div>';
   	$GB        = '<script type="text/javascript" src="https://apis.google.com/js/plusone.js">{lang:\'en\'}</script>';
   	$Button    = get_option('GPO SETTINGS');
   	$GB       .= ($Button['size']!='default') ? '<g:plusone size="'.$Button['size'].'"></g:plusone>' : '<g:plusone></g:plusone>';
   	$wordpresscontent .= str_replace('[BUTTON]', $GB, $Container);
      return $wordpresscontent;	
   }
   
   public function __destruct() {	
   }
	
}

$Class = new Social();

?>