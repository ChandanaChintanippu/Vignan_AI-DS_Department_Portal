<hr />
<?php 
	$active_whatsapp_service = $this->db->get_where('settings', array(
		'type' => 'active_whatsapp_service'
	))->row()->description;
?>
<div class="row">
	<div class="col-md-12">

		<div class="tabs-vertical-env">
		
			<ul class="nav tabs-vertical">
			<li class="active"><a href="#b-profile" data-toggle="tab">Select A WhatsApp Service</a></li>
				<li>
					<a href="#v-home" data-toggle="tab">
						WhatsApp Settings
						<?php if ($active_whatsapp_service == 'whatsapp'):?>  
							<span class="badge badge-success"><?php echo ('Active');?></span>
						<?php endif;?>
					</a>
				</li>
			</ul>
			
			<div class="tab-content">

				<div class="tab-pane active" id="b-profile">

					<?php echo form_open(base_url(). 'index.php?admin/whatsapp_settings/active_service', 
						array('class' => 'form-horizontal form-groups-bordered validate','target'=>'_top'));?>

					<div class="form-group">
						<label class="col-sm-3 control-label"><?php echo ('Select a service');?></label>
                        <div class="col-sm-5">
							<select name="active_whatsapp_service" class="form-control">
                              <option value=""<?php if ($active_whatsapp_service == '') echo 'elected';?>>
                              		<?php echo ('Not Selected');?>
                              	</option>
                        		<option value="whatsapp"
                        			<?php if ($active_whatsapp_service == 'whatsapp') echo 'elected';?>>
                        				WhatsApp
                        		</option>
                        		<option value="disabled"<?php if ($active_whatsapp_service == 'disabled') echo 'elected';?>>
                        			<?php echo ('Disabled');?>
                        		</option>
                          </select>
						</div> 
					</div>
					<div class="form-group">
	                    <div class="col-sm-offset-3 col-sm-5">
	                        <button type="submit" class="btn btn-info"><?php echo ('Save');?></button>
	                    </div>
	                </div>
	            <?php echo form_close();?>
				</div>

				<div class="tab-pane" id="v-home">
					<?php echo form_open(base_url(). 'index.php?admin/whatsapp_settings/whatsapp', 
						array('class' => 'form-horizontal form-groups-bordered validate','target'=>'_top'));?>
						<div class="form-group">
	                      <label  class="col-sm-3 control-label"><?php echo ('WhatsApp phone number');?></label>
	                      	<div class="col-sm-5">
	                          	<input type="text" class="form-control" name="whatsapp_phone_number" 
	                            	value="<?php echo $this->db->get_where('settings', array('type' =>'whatsapp_phone_number'))->row()->description;?>">
	                      	</div>
	                  	</div>
	                    <div class="form-group">
		                    <div class="col-sm-offset-3 col-sm-5">
		                        <button type="submit" class="btn btn-info"><?php echo ('Save');?></button>
		                    </div>
		                </div>
	                <?php echo form_close();?>
				</div>
				
			</div>
			
		</div>	
	
	</div>
</div>

<!-- Add a new form to send messages to WhatsApp -->
<div class="row">
	<div class="col-md-12">
		<h3>Send Message to WhatsApp</h3>
		<?php echo form_open(base_url(). 'index.php?admin/whatsapp_settings/send_message', 
			array('class' => 'form-horizontal form-groups-bordered validate','target'=>'_top'));?>
			<div class="form-group">
				<label class="col-sm-3 control-label"><?php echo ('Recipient phone number');?></label>
				<div class="col-sm-5">
					<input type="text" class="form-control" name="recipient_phone_number">
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-3 control-label"><?php echo ('Message');?></label>
				<div class="col-sm-5">
					<textarea class="form-control" name="message"></textarea>
				</div>
			</div>
			<div class="form-group">
				<div class="col-sm-offset-3 col-sm-5">
					<button type="submit" class="btn btn-info"><?php echo ('Send');?></button>
				</div