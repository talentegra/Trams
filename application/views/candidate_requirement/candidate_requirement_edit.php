<div role="main" class="right_col" style="min-height: 3687px;">
    <div class="">
        <div class="page-title">
            <div class="title_left">
                <h3>Edit Candidate_requirement</h3>
            </div>

        </div>

	<div class="clearfix"></div>
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">

                    <div class="x_content">
                        <br>
<form class="form-horizontal form-label-left" data-parsley-validate="" action="<?php echo $action; ?>" method="post">
	    <div class=" form-group">
			 <label class="control-label col-md-3 col-sm-3 col-xs-12" for="varchar">Candidate Req Details</label>
            <div class="col-md-6 col-sm-6 col-xs-12">
			<input type="text" class="form-control col-md-7 col-xs-12" name="candidate_req_details" id="candidate_req_details" placeholder="Candidate Req Details" value="<?php echo $candidate_req_details; ?>" />
			<?php echo form_error('candidate_req_details') ?>
		</div>
		</div>
	    <div class=" form-group">
			 <label class="control-label col-md-3 col-sm-3 col-xs-12" for="tinyint">Active</label>
            <div class="col-md-6 col-sm-6 col-xs-12">
			<input type="text" class="form-control col-md-7 col-xs-12" name="active" id="active" placeholder="Active" value="<?php echo $active; ?>" />
			<?php echo form_error('active') ?>
		</div>
		</div>
	
	 <div class="ln_solid"></div>
                            <div class="form-group">
                                <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                                    <button class="btn btn-success" type="submit">Submit</button>  
                                    <button class="btn btn-primary" type="button" onclick="window.location.href = '<?php echo base_url('candidate_requirement/'); ?>';">Cancel</button>

                                </div>
                            </div>
			</form>
					</div>
				</div> 
			</div>
		</div> 
	</div>
</div>