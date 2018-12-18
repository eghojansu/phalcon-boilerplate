<div class="box">
	<div class="box-body">
		{% if errors is not empty %}
			<div class="alert alert-danger">
				<ul>
				{% for error in errors %}
					<li>{{ error }}</li>
				{% endfor %}
				</ul>
			</div>
		{% endif %}

		<form method="post" class="form-horizontal">
			<div class="form-group">
				<label class="form-control-label col-md-2 col-md-offset-1" for="mailer">Mailer</label>
				<div class="col-md-8">
					<input type="text" name="mailer" id="mailer" class="form-control" value="{{ post['mailer'] }}" />
				</div>
			</div>
			<div class="form-group">
				<label class="form-control-label col-md-2 col-md-offset-1" for="recipient">Recipient</label>
				<div class="col-md-8">
					<input type="text" name="recipient" id="recipient" class="form-control" value="{{ post['recipient'] }}" />
				</div>
			</div>
			<div class="form-group">
				<label class="form-control-label col-md-2 col-md-offset-1" for="message">Message</label>
				<div class="col-md-8">
					<textarea name="message" id="message" class="form-control">{{ post['message'] }}</textarea>
				</div>
			</div>
			<div class="form-group">
				<div class="col-md-8 col-md-offset-3">
					<button type="submit" class="btn btn-primary">Save</button>
					<a href="{{ url() }}" class="btn btn-default">Cancel</a>
				</div>
			</div>
		</form>
	</div>
</div>