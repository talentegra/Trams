
        <div class="row" style="margin-bottom: 10px">
            <div class="col-md-4">
                <h2 style="margin-top:0px">Team List</h2>
            </div>
            <div class="col-md-4 text-center">
                 <?php if ($this->session->userdata('message') == TRUE): ?>
			<div class="alert alert-success" id="message"><?php echo $this->session->userdata('message'); ?></div>
				<?php endif; ?>
						
				  <?php if ($this->session->flashdata('error') == TRUE): ?>
			<div class="alert alert-danger"><?php echo $this->session->flashdata('error'); ?></div>
				<?php endif; ?>
				
            </div>
            <div class="col-md-4 text-right">
                <?php echo anchor(site_url('team/create'), 'Create', 'class="btn btn-primary"'); ?>
	    </div>
        </div>
        <table class="table table-bordered table-striped" id="mytable">
            <thead>
                <tr>
                    <th width="80px">No</th>
		    <th>Team Lead</th>
		    <th>Flags</th>
		    <th>Name</th>
		    <th>Notes</th>
		    <th>Created</th>
		    <th>Updated</th>
		    <th>Action</th>
                </tr>
            </thead>
	    <tbody>
            <?php
            $start = 0;
            foreach ($team_data as $team)
            {
                ?>
                <tr>
		    <td><?php echo ++$start ?></td>
		    <td><?php echo $team->lead_id ?></td>
		    <td><?php echo ($team->flags)? 'Active' : 'Disable'; ?></td>
		    <td><?php echo $team->name ?></td>
		    <td><?php echo $team->notes ?></td>
		    <td><?php echo $team->created ?></td>
		    <td><?php echo $team->updated ?></td>
		    <td style="text-align:center" width="200px">
			<?php 
			echo anchor(site_url('team/read/'.$team->team_id),'Read'); 
			echo ' | '; 
			echo anchor(site_url('team/update/'.$team->team_id),'Update'); 
			echo ' | '; 
			echo anchor(site_url('team/delete/'.$team->team_id),'Delete','onclick="javasciprt: return confirm(\'Are You Sure ?\')"'); 
			?>
		    </td>
	        </tr>
                <?php
            }
            ?>
            </tbody>
        </table>
        <script src="<?php echo base_url('assets/js/jquery-1.11.2.min.js') ?>"></script>
        <script src="<?php echo base_url('assets/datatables/jquery.dataTables.js') ?>"></script>
        <script src="<?php echo base_url('assets/datatables/dataTables.bootstrap.js') ?>"></script>
        <script type="text/javascript">
            $(document).ready(function () {
                $("#mytable").dataTable();
            });
        </script>
 