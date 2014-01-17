<?php
/*
Plugin Name: Admin username changer
Plugin URI: http://www.kupimito.com
Description: Change your admin username to whatever you like. Improve your site security and fend off the hackers.
Version: 1.1
Author: Ivan Ciric
Author URI: http://www.emcode.net
License: GPL2
*/

/*  Copyright 2012  Ivan Ciric  (email : office@emcode.net)

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


register_activation_hook( __FILE__, array('adminuser', 'register_custom_menu_page'));

add_action('wp_ajax_usernameForm', array( 'adminuser',  'usernameForm_callback'));
add_action('wp_ajax_nopriv_usernameForm', array( 'adminuser', 'usernameFormNo_callback'));

add_action('admin_menu', array('adminuser', 'register_custom_menu_page'));

add_action( 'admin_init', array( 'adminuser', 'add_stylesheet'));


class adminuser {

        public static function add_stylesheet() {
        
        // Respects SSL, Style.css is relative to the current file
        wp_register_style( 'admuc-style', plugins_url('style.css', __FILE__) );
        wp_enqueue_style( 'admuc-style' );
            
    
        }
        
        function register_custom_menu_page() {
            
            add_menu_page('Change admin username', 'Admin username', 'add_users', 'usernameForm', array('adminuser', 'usernameForm'),   plugins_url('admin-username-changer/icon.png'), 6);
            

        }
        
        
        public static function usernameForm(){
            global $wpdb;
                
                $table_name = $wpdb->prefix . "users";
            
                
                global $user_ID;
                        get_currentuserinfo();

                //we get all rows from our table 
                $result = $wpdb->get_results( "SELECT * FROM $table_name WHERE ID=$user_ID");

                $nonce = wp_create_nonce( 'admin-username-changer' );
                
                echo '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
                        <html xmlns="http://www.w3.org/1999/xhtml">
                        <head>
                        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

                        <title>Simple to-do dashboard widget</title>            
                                             
                        </head>

                        <body>';
                
                echo '<div id="form"><span id="current">Current admin username is <b>'.$result[0]->user_login.'</b></span><br/><p></p>';
                
                        echo '<form id="changeUsername" name="changeUsername" method="post" action="">
                                <input type="text" name="username" id="username" placeholder="new username"/>
                                '.wp_nonce_field('auc-noscript').'
                                <input type="submit" name="changeUsernameButton" id="changeUsernameButton" value="Change" />
                            </form></div>
                            <div id="status" style="display: none;"></div>';
                        
            
           /////////////////////////////////////////////////////////////////////
           //a form submit action that will run if JS is disabled
                if(isset($_POST['changeUsernameButton'])){

                    if($_POST['username'] != ''){
                    
                        if (! check_admin_referer('auc-noscript') ) die("Security check failure");

                        $username = $_POST['username'];

                        $data = array('user_login'=>$username, 'user_nicename'=>$username, 'display_name'=>$username);                
                        $where = array('ID'=>$user_ID);
                        $format = array('%s', '%s', '%s');
                        $wformat = array('%d');
                        $update = $wpdb->update( $table_name, $data, $where, $format, $wformat);

                        echo '<div id="statusns">Your admin username has been changed to: <b>'.$username.'</b></div>';
                    
                    } else {
                        
                        echo '<div id="statusns">Username can not be empty!</div>';
                    }
                    
                    
                }
           /////////////////////////////////////////////////////////////////////
            
                echo "<script type='text/javascript'>
                        
                        jQuery(document).ready(function($){
                           
                                $('#changeUsernameButton').click(function(event) {
                                
                                    event.preventDefault();
                                
                                    if($('#username').val() != '' && $('#username').val() != 'new username'){
 
                                        $.post(ajaxurl,{_ajax_nonce: '".$nonce."', action: 'usernameForm', username: $('#username').val()}, function(data) { $('#form').hide(), $('#status').html(data).show(); });
                                    } else {
                                        alert('One does not simply enter a blank admin username!');
                                    }
                                });
     
                         });
                                </script></body></html>";
        }
        
        public static function usernameForm_callback() {
            
            if (!check_ajax_referer( "admin-username-changer" ) ) die("Security check failure");

                global $wpdb;
                
                $table_name = $wpdb->prefix . "users";
                
                $username = $_POST['username'];
                
                global $user_ID;
                        get_currentuserinfo();

                $data = array('user_login'=>$username, 'user_nicename'=>$username, 'display_name'=>$username);                
                $where = array('ID'=>$user_ID);
                $format = array('%s', '%s', '%s');
                $wformat = array('%d');
                
                $update = $wpdb->update( $table_name, $data, $where, $format, $wformat);
                
                echo 'New admin username <b>'.$username.'</b> has been set. Logout and log back in with your shiny brand new username.';


                die();
        }
        
        public static function usernameFormNo_callback() {
 
                echo 'You shall not pass! Only admin can use this function.';

                die();
        }

}

?>