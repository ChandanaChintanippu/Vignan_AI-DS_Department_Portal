<table cellpadding="0" cellspacing="0" border="0" class="table table-bordered table-hover table-striped">
    <thead>
        <tr>
            <th><?php echo ('Select Subject');?></th>
            <th><?php echo ('Select Date');?></th>
            <th><?php echo ('Select Hour');?></th>
            <th><?php echo ('Extended Hours');?></th>
        </tr>
    </thead>
    <tbody>
        <form method="post" action="<?php echo base_url();?>index.php?admin/attendance_selector" class="form">
            <tr class="gradeA">
                <td>
                    <select name="subject" class="form-control">
                        <option value="">Select a subject</option>
                        <?php $subjects = $this->db->get('subject')->result_array(); foreach($subjects as $row):?>
                            <option value="<?php echo $row['subject_id'];?>" <?php if(isset($subject_id) && $subject_id==$row['subject_id'])echo 'selected="selected"';?>> <?php echo $row['name'];?></option>
                        <?php endforeach;?>
                    </select>
                </td>
                <td>
                    <input type="text" id="datepicker" name="date" class="form-control" value="<?php echo isset($date) ? $date : ''; ?>">
                </td>
                <td>
                    <select name="hour" class="form-control">
                        <?php for($i=1;$i<=12;$i++):?>
                            <option value="<?php echo $i;?>" <?php if(isset($hour) && $hour==$i)echo 'selected="selected"';?>> <?php echo $i;?> </option>
                        <?php endfor;?>
                    </select>
                </td>
                <td>
                    <select name="extended_hours" class="form-control">
                        <option value="0">No</option>
                        <option value="1">Yes</option>
                    </select>
                </td>
                <td align="center"><input type="submit" value="<?php echo ('Manage Attendance');?>" class="btn btn-info"/></td>
            </tr>
        </form>
    </tbody>
</table>

<script>
    $(function() {
        $( "#datepicker" ).datepicker({
            dateFormat: "yy-mm-dd" // Format the date as YYYY-MM-DD
        });
    });
</script>

<?php if($subject_id!='' && $date!='' && $hour!=''):?>
    <center>
        <div class="row">
            <div class="col-sm-offset-4 col-sm-4">
                <div class="tile-stats tile-white-gray">
                    <div class="icon"><i class="entypo-suitcase"></i></div>
                    <?php $full_date = $date; $timestamp = strtotime($full_date); $day = strtolower(date('l', $timestamp)); ?>
                    <h2><?php echo ucwords($day);?></h2>
                    <h3>Attendance for the subject</h3>
                    <p><?php echo $date;?></p>
                </div>
                <a href="#" id="update_attendance_button" onclick="return update_attendance()" class="btn btn-info"> Update Attendance </a>
            </div>
        </div>
    </center>

    <hr />

    <div class="row" id="attendance_list">
        <div class="col-sm-offset-3 col-md-6">
            <table class="table table-bordered table-hover table-striped">
                <thead>
                    <tr>
                        <td><?php echo ('Roll');?></td>
                        <td><?php echo ('Name');?></td>
                        <td><?php echo ('Status');?></td>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    $students = $this->db->get_where('student' , array('subject_id'=>$subject_id))->result_array();
                    foreach($students as $row):?>
                        <tr class="gradeA">
                            <td><?php echo $row['roll'];?></td>
                            <td><?php echo $row['name'];?></td>
                            <?php 
                            //inserting blank data for students attendance if unavailable
                            $verify_data = array( 
                                'student_id' => $row['student_id'], 
                                'date' => $full_date
                            ); 
                            $query = $this->db->get_where('attendance' , $verify_data);
                            if($query->num_rows() < 1) 
                                $this->db->insert('attendance' , $verify_data);
                            
                            //showing the attendance status editing option
                            $attendance = $this->db->get_where('attendance' , $verify_data)->row();
                            $status = $attendance->status;
                            ?>

                            <?php if ($status == 1):?>
                                <td align="center"> 
                                    <span class="badge badge-success"><?php echo ('Present');?></span> 
                                    <a href="#" onclick="return mark_absent('<?php echo $row['student_id'];?>', '<?php echo $full_date;?>')" class="btn btn-danger btn-sm">Mark as Absent</a>
                                </td>
                            <?php elseif ($status == 2):?>
                                <td align="center"> 
                                    <span class="badge badge-danger"><?php echo ('Absent');?></span> 
                                    <a href="#" onclick="return mark_present('<?php echo $row['student_id'];?>', '<?php echo $full_date;?>')" class="btn btn-success btn-sm">Mark as Present</a>
                                </td>
                            <?php else:?>
                                <td></td>
                            <?php endif;?>
                        </tr>
                    <?php endforeach;?>
                </tbody>
            </table>
        </div>
    </div>

    <div class="row" id="update_attendance">
        <form method="post" action="<?php echo base_url();?>index.php?admin/manage_attendance/<?php echo $subject_id.'/'.$date.'/'.$hour;?>">
            <div class="col-sm-offset-3 col-md-6">
                <table class="table table-bordered table-hover table-striped">
                    <thead>
                        <tr class="gradeA">
                            <th><?php echo ('Roll');?></th>
                            <th><?php echo ('Name');?></th>
                            <th><?php echo ('Status');?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        $students = $this->db->get_where('student' , array('subject_id'=>$subject_id))->result_array();
                        foreach($students as $row) { ?>
                        <tr class="gradeA">
                            <td><?php echo $row['roll'];?></td>
                            <td><?php echo $row['name'];?></td>
                            <td align="center">
                                <?php 
                                //showing the attendance status editing option
                                $attendance = $this->db->get_where('attendance' , array('student_id'=>$row['student_id'], 'date'=>$full_date))->row();
                                $status = $attendance->status;
                                ?>
                                <input type="radio" name="status_<?php echo $row['student_id'];?>" value="1" <?php if($status == 1) echo 'checked';?>> <span>Present</span>
                                <input type="radio" name="status_<?php echo $row['student_id'];?>" value="2" <?php if($status == 2) echo 'checked';?>> <span>Absent</span>

                                <style> input[type="radio"] { margin: 0 10px; } </style>
                            </td>
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>
                <input type="hidden" name="date" value="<?php echo $full_date;?>" />
                <center> <input type="submit" class="btn btn-info" value="Save Changes"> </center>
            </div>
        </form>
    </div>
<?php endif;?>

<script type="text/javascript">
    $("#update_attendance").hide();
    function update_attendance() {
        $("#attendance_list").hide();
        $("#update_attendance_button").hide();
        $("#update_attendance").show();
    }

    function mark_absent(student_id, date) {
        $.ajax({
            url: '<?php echo base_url();?>index.php?admin/mark_attendance',
            type: 'post',
            data: {student_id: student_id, date: date, status: 2},
            success: function(response) {
                location.reload();
            }
        });
        return false;
    }

    function mark_present(student_id, date) {
        $.ajax({
            url: '<?php echo base_url();?>index.php?admin/mark_attendance',
            type: 'post',
            data: {student_id: student_id, date: date, status: 1},
            success: function(response) {
                location.reload();
            }
        });
        return false;
    }
</script>
