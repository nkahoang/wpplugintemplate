<?php /* ADMIN OPTION PAGE */ ?>
<h1><span class="strong">WME</span> plugin settings</h1>
<br/>
<div id="WME-wrapper" class="innerR">
	<div class="form-group">
		<label class="col-sm-2 control-label">
			Sample option 1
		</label>
		<div class="col-sm-10 input-group">
			<span class="input-group-addon"><i class="fa fa-fw fa-align-left"></i></span>
			<input class="f-width form-control"
			       data-bind="value: Options.SampleText"
			       placeholder="Enter option for text 1"/>
		</div>
	</div>
	<div class="form-group">
		<label class="col-sm-2 control-label">
			Sample phone 2
		</label>
		<div class="col-sm-10 input-group">
			<span class="input-group-addon"><i class="fa fa-fw fa-phone"></i></span>
			<input class="f-width form-control"
			       data-role="maskedtextbox"
			       data-mask="(00) 0000-0000"
			       data-bind="value: Options.SamplePhone"
			       placeholder="Enter phone"/>
		</div>
	</div>
	<hr/>
	<div class="form-group">
		<label class="col-sm-2 control-label">
			Sample page
		</label>
		<div class="col-sm-10 input-group">
			<span class="input-group-addon"><i class="fa fa-fw fa-file"></i></span>
			<select class="f-width form-control"
			       data-role="dropdownlist"
			       data-text-field="title"
			       data-value-field="id"
			       data-template="page-post-template"
			       data-value-template="page-post-template"
			       data-value-primitive="true"
			       data-bind="source: Pages, value: Options.SamplePage"
			       data-option-label="Select a page"></select>
		</div>
	</div>
	<div class="form-group">
		<label class="col-sm-2 control-label">
			Sample post
		</label>
		<div class="col-sm-10 input-group">
			<span class="input-group-addon"><i class="fa fa-fw fa-file-text"></i></span>
			<select class="f-width form-control"
			       data-role="dropdownlist"
			       data-text-field="title"
			       data-value-field="id"
			       data-template="page-post-template"
			       data-value-template="page-post-template"
			       data-value-primitive="true"
			       data-bind="source: Posts, value: Options.SamplePost"
			       data-option-label="Select a post"></select>
		</div>
	</div>
	<hr/>
	<div class="form-group">
		<label class="col-sm-2 control-label">
			Sample color
		</label>
		<div class="col-sm-10 input-group">
			<span class="input-group-addon"><i class="fa fa-fw fa-magic"></i></span>
			<input class="f-width form-control"
			        data-role="colorpicker"
			        data-bind="value: Options.SampleColor"/>
		</div>
	</div>
	<div class="form-group">
		<label class="col-sm-2 control-label">
			Sample date time
		</label>
		<div class="col-sm-10 input-group">
			<span class="input-group-addon"><i class="fa fa-fw fa-clock-o"></i></span>
			<input class="f-width form-control"
			       data-role="datetimepicker"
			       data-format="yyyy-MM-dd HH:mm:ss"
			       data-bind="source: Posts, value: Options.SampleDateTime"/>
		</div>
	</div>
	<hr/>
	<div class="form-group">
		<div class="col-sm-offset-2">
			<button id="btn-save"
			        class="btn btn-primary"
			        data-bind="events: {click: events.save_clicked}">
				<i class="fa fa-fw fa-save"></i>&emsp;
				<span class="strong">Save changes</span>
			</button>
		</div>
	</div>
	<hr/>
	<i class="light text-muted small">Copyright &copy; <?php echo date_format(new \DateTime(), 'Y') ?></i>
</div>

<?php /* INITIATING JAVASCRIPT */ ?>
<script id="page-post-template" type="text/x-kendo-template">
	# if (data.id) { #
	<span class="strong">#: data.title #</span> <i><span class="light">(#: data.name #)</span></i>
	# } else { #
	#: data.title #
	# } #
</script>
<script lang="javascript">
    jQuery(document).ready(function(){
        WME.Admin.init(jQuery("#WME-wrapper"), <?php echo json_encode($model); ?>);
    })
</script>