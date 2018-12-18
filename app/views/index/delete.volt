<div class="box">
	<div class="box-body">
		<table class="table">
			<tr>
				<th colspan="2">Delete this message ?</th>
			</tr>
			<tr>
				<td>Mailer</td>
				<td>{{ message.mailer }}</td>
			</tr>
			<tr>
				<td>Recipient</td>
				<td>{{ message.recipient }}</td>
			</tr>
			<tr>
				<td>Message</td>
				<td>{{ message.message }}</td>
			</tr>
			<tr>
				<td></td>
				<td>
					<form method="post">
					<button type="submit" class="btn btn-danger">Delete</button>
					<a href="{{ url() }}" class="btn btn-default">Cancel</a>
					</form>
				</td>
			</tr>
		</table>
	</div>
</div>