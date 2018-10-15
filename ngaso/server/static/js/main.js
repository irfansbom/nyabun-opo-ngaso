var root_url = 'http://localhost/php_apache_folder/stis-git-studnt/student/';

function get_all_students(cb_success, cb_failure) {
	$.ajax({
		type: 'GET',
		url: root_url + '/api/student',
		success: cb_success,
		error: cb_failure
	})
}

function get_student_by_id(id, cb_success, cb_failure) {
	$.ajax({
		type: 'GET',
		url: root_url + '/api/student/' + id,
		success: cb_success,
		error: cb_failure
	})
}

function get_student_by_name_query(query, cb_success, cb_failure) {
	$.ajax({
		type: 'GET',
		url: root_url + '/api/student?q=' + query,
		success: cb_success,
		error: cb_failure
	})
}

function post_student(params, cb_success, cb_failure) {
	$.ajax({
		type: 'POST',
		url: root_url + '/api/student',
		data: params,
		success: cb_success,
		error: cb_failure
	})
}

function put_student(params, cb_success, cb_failure) {
	$.ajax({
		type: 'PUT',
		url: root_url + '/api/student/' + params['id'],
		data: params,
		success: cb_success,
		error: cb_failure
	})
}

function delete_student(id, cb_success, cb_failure) {
	$.ajax({
		type: 'DELETE',
		url: root_url + '/api/student/' + id,
		success: cb_success,
		error: cb_failure
	})
}

function reload_table(data) {
	$('#table-body').empty();

	data.forEach(el => {
		tr = $('<tr></tr>');

		td1 = $('<td></td>').text(el['id']);
		td2 = $('<td></td>').text(el['name']);
		td3 = $('<td></td>').text(el['email']);

		tr.append(td1, td2, td3);

		tr.click(function () {

			$('#id-input').val(el['id']);
			$('#name-input').val(el['name']);
			$('#email-input').val(el['email']);
			$('#dob-input').val(el['dob']);
			$('#address-input').text(el['address']);
			$('#phone-input').val(el['phone']);
			$('#father-input').val(el['father_name']);
			$('#mother-input').val(el['mother_name']);

			$('#id-input').prop("disabled", true);
			$('#alter-modal').modal('show');
		})
		$('#table-body').append(tr);
	});
}

function get_form() {
	var data = {};
	data['id'] = $('#id-input').val();
	data['name'] = $('#name-input').val();
	data['email'] = $('#email-input').val();
	data['dob'] = $('#dob-input').val();
	data['address'] = $('#address-input').val();
	data['phone'] = $('#phone-input').val();
	data['father_name'] = $('#father-input').val();
	data['mother_name'] = $('#mother-input').val();

	return data;
}


function get_form_c() {
	var data = {};
	data['id'] = $('#id-input-c').val();
	data['name'] = $('#name-input-c').val();
	data['email'] = $('#email-input-c').val();
	data['dob'] = $('#dob-input-c').val();
	data['address'] = $('#address-input-c').val();
	data['phone'] = $('#phone-input-c').val();
	data['father_name'] = $('#father-input-c').val();
	data['mother_name'] = $('#mother-input-c').val();

	return data;
}

window.addEventListener('load', function () {
	get_all_students(function (data) {
		reload_table(data['students']);
	}, function () {
		$('#error-msg').text('An error occured, please refresh');
		$('#error-modal').modal('show');
	})

	$('#save-button').click(
		function () {
			$('#cancel-button').prop("disabled", true);
			$('#save-button').prop("disabled", true);
			$('#delete-button').prop("disabled", true);
			put_student(get_form(), function (d) {
				get_all_students(function (data) {
					$('#alter-modal').modal('hide');
					$('#cancel-button').prop("disabled", false);
					$('#save-button').prop("disabled", false);
					$('#delete-button').prop("disabled", false);

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

					reload_table(data['students'])
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
			delete_student(get_form()['id'], function () {
				get_all_students(function (data) {
					$('#alter-modal').modal('hide');
					$('#cancel-button').prop("disabled", false);
					$('#save-button').prop("disabled", false);
					$('#delete-button').prop("disabled", false);
					reload_table(data['students'])
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
			post_student(get_form_c(), function (d) {
				get_all_students(function (data) {

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
					reload_table(data['students'])
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
