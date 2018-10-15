var root_url = 'http://localhost/php_apache_folder/nyabun-opo-ngaso/ngaso/server';

function get_all_users(cb_success, cb_failure) {
	$.ajax({
		type: 'GET',
		url: root_url + '/api/users',
		success: cb_success,
		error: cb_failure
	})
}

function get_username_by_query(query, cb_success, cb_failure) {
	$.ajax({
		type: 'GET',
		url: root_url + '/api/users?query=' + query,
		success: cb_success,
		error: cb_failure
	})
}

function post_user(params, cb_success, cb_failure) {
	$.ajax({
		type: 'POST',
		url: root_url + '/api/users',
		data: params,
		success: cb_success,
		error: cb_failure
	})
}

function put_user(params, cb_success, cb_failure) {
	$.ajax({
		type: 'PUT',
		url: root_url + '/api/users/' + params['username'],
		data: params,
		success: cb_success,
		error: cb_failure
	})
}

function delete_user(username, cb_success, cb_failure) {
	$.ajax({
		type: 'DELETE',
		url: root_url + '/api/users/' + username,
		success: cb_success,
		error: cb_failure
	})
}

function reload_table(data) {
	$('#table-body').empty();

	data.forEach(el => {
		tr = $('<tr></tr>');

		td1 = $('<td></td>').text(el['username']);
		td2 = $('<td></td>').text(el['nama_lengkap']);
		td3 = $('<td></td>').text(el['email']);

		tr.append(td1, td2, td3);

		tr.click(function () {

			$('#username-input').val(el['username']);
			$('#nama-lengkap-input').val(el['nama_lengkap']);
			$('#email-input').val(el['email']);
			$('#password-1-input').val(el['password']);
			$('#password-2-input').val(el['password']);

			$('#username-input').prop("disabled", true);
			$('#alter-modal').modal('show');
		})
		$('#table-body').append(tr);
	});
}

function get_form() {
	var data = {};
	data['username'] = $('#username-input').val();
	data['nama_lengkap'] = $('#nama-lengkap-input').val();
	data['email'] = $('#email-input').val();
	if ($('#password-1-input').val() === $('#password-2-input').val()) {
		data['password'] = $('#password-1-input').val();
	} else {
		data['password'] = "q3w5e5tyu9iz3wxcrvbuimo,z3w4xevtbnmio,";
	}
	return data;
}


function get_form_c() {
	var data = {};
	data['username'] = $('#username-input-c').val();
	data['nama_lengkap'] = $('#nama-lengkap-input-c').val();
	data['email'] = $('#email-input-c').val();
	if ($('#password-1-input-c').val() === $('#password-2-input-c').val()) {
		data['password'] = $('#password-1-input-c').val();
	} else {
		data['password'] = "q3w5e5tyu9iz3wxcrvbuimo,z3w4xevtbnmio,";
	}
	return data;
}

window.addEventListener('load', function () {
	get_all_users(function (data) {
		reload_table(data['users']);
	}, function () {
		$('#error-msg').text('An error occured, please refresh');
		$('#error-modal').modal('show');
	});

	$('#refresh-button').click(
		
		function () {
			console.log('refresh');
			get_all_users(function (data) {
				reload_table(data['users']);
			}, function () {
				$('#error-msg').text('An error occured, please refresh');
				$('#error-modal').modal('show');
			})
		}
	);

	$('#search-button').click(
		function () {
			var que = $('#search-input').val();
			if (que.length === 0) {
				get_all_users(function (data) {
					reload_table(data['users']);
				}, function () {
					$('#error-msg').text('An error occured, please refresh');
					$('#error-modal').modal('show');
				});
			}
			else {
				get_username_by_query(que , function (data) {
					reload_table(data['users']);
				}, function () {
					$('#error-msg').text('An error occured, please refresh');
					$('#error-modal').modal('show');
				});
			}

		}
	)

	$('#save-button').click(
		function () {
			$('#cancel-button').prop("disabled", true);
			$('#save-button').prop("disabled", true);
			$('#delete-button').prop("disabled", true);
			put_user(get_form(), function (d) {
				get_all_users(function (data) {
					$('#alter-modal').modal('hide');
					$('#cancel-button').prop("disabled", false);
					$('#save-button').prop("disabled", false);
					$('#delete-button').prop("disabled", false);

					console.log(d);
					if (d['error']) {
						if (typeof d['error'] === 'string' || d['error'] instanceof String) {
							$('#error-msg').text(d['error'])

						} else {
							err_msg = [];
							for (var key in d['error']) {
								err_msg.push(d['error'][key]);
							}
							$('#error-msg').html(err_msg.join('<br>'));
						}
						$('#error-modal').modal('show');
					}

					reload_table(data['users'])
				}, function () {
					$('#alter-modal').modal('hide');
					$('#cancel-button').prop("disabled", false);
					$('#save-button').prop("disabled", false);
					$('#delete-button').prop("disabled", false);
					$('#error-msg').text('An error occured, please refresh');
					$('#error-modal').modal('show');
				})
			}, function () {
				$('#alter-modal').modal('hide');
				$('#cancel-button').prop("disabled", false);
				$('#save-button').prop("disabled", false);
				$('#delete-button').prop("disabled", false);
				$('#error-msg').text('An error occured, please refresh');
				$('#error-modal').modal('show');
			})
		}
	);

	$('#delete-button').click(
		function () {
			$('#cancel-button').prop("disabled", true);
			$('#save-button').prop("disabled", true);
			$('#delete-button').prop("disabled", true);
			delete_user(get_form()['username'], function () {
				get_all_users(function (data) {
					$('#alter-modal').modal('hide');
					$('#cancel-button').prop("disabled", false);
					$('#save-button').prop("disabled", false);
					$('#delete-button').prop("disabled", false);
					reload_table(data['users'])
				}, function () {
					$('#alter-modal').modal('hide');
					$('#cancel-button').prop("disabled", false);
					$('#save-button').prop("disabled", false);
					$('#delete-button').prop("disabled", false);
					$('#error-msg').text('An error occured, please refresh');
					$('#error-modal').modal('show');
				})
			}, function () {
				$('#alter-modal').modal('hide');
				$('#cancel-button').prop("disabled", false);
				$('#save-button').prop("disabled", false);
				$('#delete-button').prop("disabled", false);
				$('#error-msg').text('An error occured, please refresh');
				$('#error-modal').modal('show');
			})
		}
	)

	$('#create-button').click(
		function () {
			$("#create-form").trigger("reset");
			$('#create-modal').modal('show');
		}
	)

	$('#save-button-c').click(
		function () {
			$('#cancel-button-c').prop("disabled", true);
			$('#save-button-c').prop("disabled", true);
			post_user(get_form_c(), function (d) {
				get_all_users(function (data) {

					if (d['error']) {
						if (typeof d['error'] === 'string' || d['error'] instanceof String) {
							$('#error-msg').text(d['error'])

						} else {
							err_msg = [];
							for (var key in d['error']) {
								err_msg.push(d['error'][key]);
							}
							$('#error-msg').html(err_msg.join('<br>'));
						}
						$('#error-modal').modal('show');
					}

					$('#create-modal').modal('hide');
					$('#cancel-button-c').prop("disabled", false);
					$('#save-button-c').prop("disabled", false);
					reload_table(data['users'])
				}, function () {
					$('#create-modal').modal('hide');
					$('#cancel-button-c').prop("disabled", false);
					$('#save-button-c').prop("disabled", false);
					$('#error-msg').text('An error occured, please refresh');
					$('#error-modal').modal('show');
				})
			}, function () {
				$('#create-modal').modal('hide');
				$('#cancel-button-c').prop("disabled", false);
				$('#save-button-c').prop("disabled", false);
				$('#error-msg').text('An error occured, please refresh');
				$('#error-modal').modal('show');
			})
		}
	)
})
