<?php
  /* 
   * Capsule Web2Lead
   * Wordpress widget plugin for Capsule Web2Lead allowing users to add 
   * a web to lead form for Capsule CRM to their Wordpress site.
   * 
   * Copyright (C) 2010 Martin Eley
   * 
   * This program is free software: you can redistribute it and/or modify
   * it under the terms of the GNU General Public License as published by
   * the Free Software Foundation, either version 3 of the License, or
   * any later version.
   * 
   * This program is distributed in the hope that it will be useful,
   * but WITHOUT ANY WARRANTY; without even the implied warranty of
   * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
   * GNU General Public License for more details.
   * 
   * You should have received a copy of the GNU General Public License
   * along with this program.  If not, see <http://www.gnu.org/licenses/>.
   */

  /*  
   * Plugin Name: Capsule Web2Lead
   * Plugin URI: http://code.google.com/p/capsuleweb2lead/
   * Description: Wordpress widget plugin for Capsule Web2Lead allowing users to add a web to lead form for Capsule CRM to their Wordpress site.
   * Version: 1.0
   * Author: Martin Eley
   * Author URI: http://code.google.com/p/capsuleweb2lead/
   */
   
  error_reporting(E_ALL);
  add_action("widgets_init", array('CapsuleWeb2Lead', 'register'));
  class CapsuleWeb2Lead {
    function control(){
      $data = get_option('CapsuleWeb2Lead');
?>
<p><label>Form title</label><input name="capsuleWeb2LeadFormTitle" type="text" value="<?php echo $data['capsuleWeb2LeadFormTitle']; ?>" /></p>
<p><label>Web Form Key</label><input name="capsuleWeb2LeadWebFormKey" type="text" value="<?php echo $data['capsuleWeb2LeadWebFormKey']; ?>" /></p>
<p><label>Complete URL</label><input name="capsuleWeb2LeadCompleteURL" type="text" value="<?php echo $data['capsuleWeb2LeadCompleteURL']; ?>" /></p>
<?php
  if (isset($_POST['capsuleWeb2LeadFormTitle'])){
    $data['capsuleWeb2LeadFormTitle'] = attribute_escape($_POST['capsuleWeb2LeadFormTitle']);
    update_option('CapsuleWeb2Lead', $data);
  }
  if (isset($_POST['capsuleWeb2LeadWebFormKey'])){
    $data['capsuleWeb2LeadWebFormKey'] = attribute_escape($_POST['capsuleWeb2LeadWebFormKey']);
    update_option('CapsuleWeb2Lead', $data);
  }
  if (isset($_POST['capsuleWeb2LeadCompleteURL'])){
    $data['capsuleWeb2LeadCompleteURL'] = attribute_escape($_POST['capsuleWeb2LeadCompleteURL']);
    update_option('CapsuleWeb2Lead', $data);
  }
    }
    function widget($args){
      $data = get_option('CapsuleWeb2Lead');
      echo $args['before_widget'];
      echo $args['before_title'] . $data['capsuleWeb2LeadFormTitle'] . $args['after_title'];
?>
<script type="text/javascript" src="http://ajax.microsoft.com/ajax/jQuery/jquery-1.4.2.min.js"></script>
<script type="text/javascript" src="http://ajax.microsoft.com/ajax/jquery.validate/1.5.5/jquery.validate.min.js"></script>
<script type="text/javascript">
  $(document).ready(function(){
    $("#web2LeadForm").validate({
     messages: {
       FIRST_NAME: "*",
       LAST_NAME: "*",
       EMAIL: {
         required: "*",
         email: "Not a valid address"
       }
     }    
    });
  });
</script>
<style>
  label.error{
    color: red;
  }
</style>
<form id="web2LeadForm" action="https://service.capsulecrm.com/service/newlead" method="post">
  <input type="hidden" name="FORM_ID" value="<?php echo $data['capsuleWeb2LeadWebFormKey'] ?>">
  <input type="hidden" name="COMPLETE_URL" value="<?php echo $data['capsuleWeb2LeadCompleteURL'] ?>">
  <table border="0">
    <tr>
      <td><label for="FIRST_NAME" style="width:10em;">First name:</label></td>
      <td><input type="text" class="required" name="FIRST_NAME"></td>
    </tr>
    <tr>
      <td><label for="LAST_NAME" style="width:10em;">Last name:</label></td>
      <td><input type="text" class="required" name="LAST_NAME"></td>
    </tr>
    <tr>
      <td><label for="EMAIL" style="width:10em;">Email:</label></td>
      <td><input type="text" class="required email" name="EMAIL"></td>
    </tr>
  </table>
  <input type="submit" value="Submit"/>
</form>
<?php
      echo $args['after_widget'];
    }
    function register(){
      register_sidebar_widget('Capsule Web2Lead', array('CapsuleWeb2Lead', 'widget'));
      register_widget_control('Capsule Web2Lead', array('CapsuleWeb2Lead', 'control'));
    }
  }
?>