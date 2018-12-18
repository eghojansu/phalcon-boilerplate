<div class="box">
	<div class="box-header text-right">
		<a class="btn btn-primary" href="{{ url('create') }}">New Message</a>
	</div>
	<div class="box-body">
		{{ flashSession.output() }}

		<table class="table table-bordered">
			<thead>
				<tr>
					<th>#</th>
					<th>Mailer</th>
					<th>Recipient</th>
					<th>Message</th>
					<th></th>
				</tr>
			</thead>
			<tbody>
				{% for message in messages %}
					<tr>
						<td>{{ message.id }}</td>
						<td>{{ message.mailer }}</td>
						<td>{{ message.recipient }}</td>
						<td>{{ message.message }}</td>
						<td>
							<a class="btn btn-success" href="{{ url('update/' ~ message.id) }}">Edit</a>
							<a class="btn btn-danger" href="{{ url('delete/' ~ message.id) }}">Delete</a>
						</td>
					</tr>
				{% else %}
					<tr>
						<td colspan="5">No message yet.</td>
					</tr>
				{% endfor %}
			</tbody>
		</table>
	</div>
</div>