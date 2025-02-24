<div class="row">
	<div class="col-md-12">
		<div class="panel panel-primary" data-collapsed="0">
        	<div class="panel-heading">
            	<div class="panel-title" >
            		<i class="entypo-plus-circled"></i>
					<?php echo ('Student Bulk Add Form');?>
            	</div>
            </div>
			<div class="panel-body">
				
                <?php echo form_open(base_url() . 'index.php?admin/student_bulk_add/import_excel/' , array('class' => 'form-horizontal form-groups-bordered validate', 'enctype' => 'multipart/form-data'));?>
	
					<div class="form-group">
						<label for="field-1" class="col-sm-3 control-label"><?php echo ('Select excel file');?></label>
                        
						<div class="col-sm-5">
                        	<input type="file" name="userfile" class="form-control" data-validate="required" data-message-required="<?php echo ('Value Required');?>">
                            <br>
                         <a href="<?php echo base_url();?>uploads\blank_excel_file.xlsx" target="_blank" 
                         		class="btn btn-info btn-sm"><i class="entypo-download"></i> Download blank excel file</a>
						</div>
					</div>
					
					<div class="form-group">
						<label for="field-2" class="col-sm-3 control-label"><?php echo ('Class');?></label>
                        
						<div class="col-sm-5">
							<select name="class_id" class="form-control" data-validate="required" data-message-required="<?php echo ('Value Required');?>">
                              <option value=""><?php echo ('select');?></option>
                              <?php 
										$classes = $this->db->get('class')->result_array();
										foreach($classes as $row):
											?>
                                    		<option value="<?php echo $row['class_id'];?>">
													<?php echo $row['name'];?>
                                                    </option>
                                        <?php
										endforeach;
								  ?>
                          </select>
						</div> 
					</div>
					
                    <div class="form-group">
						<div class="col-sm-offset-3 col-sm-5">
							<button type="submit" class="btn btn-info"><?php echo ('Upload and import');?></button>
						</div>
					</div>
                <?php echo form_close();?>
            </div>
        </div>
    </div>
</div>