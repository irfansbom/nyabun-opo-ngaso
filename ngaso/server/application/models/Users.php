<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Users extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}

	public function get_all_users()
	{
		$query = $this->db->query('SELECT * FROM users ORDER BY username');
		return [
			'status' => '200',
			'users' => $query->result_array()
		];
	}

	public function get_users_by_search_query(string $query = null, bool $strict = false)
	{
		if ($query === null) {
			return $this->get_all_users();
		}

		if ($strict) {
			$query = $this->db->query('SELECT * FROM users WHERE username = ? ORDER BY username', [$query]);
		} else {
			$query = $this->db->query('SELECT * FROM users WHERE username LIKE ? ORDER BY username', ['%' . $query . '%']);
		}

		return [
			'status' => '200',
			'users' => $query->result_array()
		];
	}

	public function validate_user_array(array $user_array = null)
	{



		if (strlen($user_array['username']) < 4) {
			$data['error']['username'] = 'Username harus lebih dari 4 karakter';
		}

		if (strlen($user_array['username']) > 80) {
			$data['error']['username'] = 'Username tidak boleh lebih dari 80 karakter';
		}

		if (strlen($user_array['nama_lengkap']) === 0) {
			$data['error']['nama_lengkap'] = 'Nama lengkap kosong';
		}

		if (strlen($user_array['nama_lengkap']) > 120) {
			$data['error']['nama_lengkap'] = 'Nama lengkap tidak boleh lebih dari 120 karakter';
		}

		if ((preg_match('/[0-9]+/', $user_array['password']) !== 1) || (preg_match('/[A-Za-z]+/', $user_array['password']) !== 1)) {
			$data['error']['password'] = 'Password harus minimal terdiri dari satu huruf dan satu angka';
		}

		if ($user_array['password'] === "q3w5e5tyu9iz3wxcrvbuimo,z3w4xevtbnmio,") {
			$data['error']['password'] = 'Kedua password harus sama';
		}


		if (!filter_var($user_array['email'], FILTER_VALIDATE_EMAIL)) {
			$data['error']['email'] = 'Email tidak valid';
		}


		if (!isset($data['error'])) {
			$data = [];
			array_push($data, $user_array['username']);
			array_push($data, $user_array['nama_lengkap']);
			array_push($data, $user_array['password']);
			array_push($data, $user_array['email']);
		}

		return $data;
	}

	public function add_user(array $user_array = null)
	{
		if ($user_array === null) {
			return [
				'status' => '400',
				'error' => 'Request array is empty'
			];
		}

		$user_array = $this->validate_user_array($user_array);

		if ($user_array['error'] !== null) {
			return [
				'status' => '400',
				'error' => $user_array['error']
			];
		}

		$pre_create = $this->get_users_by_search_query($user_array[0], true);
		if (count($pre_create['users']) > 0) {
			return [
				'status' => '409',
				'error' => 'Resource user is exists',
				'users' => $pre_create['users']
			];
		}

		$this->db->query('INSERT INTO users VALUES (? , ? , ? , ?)', $user_array);

		$response = $this->get_users_by_search_query($user_array[0], true);
		$response['status'] = 201;

		return $response;
	}

	public function put_user(array $user_array = null)
	{
		if ($user_array === null) {
			return [
				'status' => '400',
				'error' => 'Request array is empty'
			];
		}

		$user_array = $this->validate_user_array($user_array);

		if ($user_array['error'] !== null) {
			return [
				'status' => '400',
				'error' => $user_array['error']
			];
		}

		for ($i = 1; $i < 4; $i++) {
			$user_array[$i + 3] = $user_array[$i];
		}

		$this->db->query(
			'INSERT INTO users VALUES (? , ? , ? , ?) ON DUPLICATE KEY UPDATE nama_lengkap = ?, password = ?, email = ?',
			$user_array
		);


		$response = $this->get_users_by_search_query($user_array[0], true);
		$response['status'] = 200;

		return $response;
	}

	public function delete_user(string $username = null)
	{
		if ($username === null) {
			return [
				'status' => '400',
				'error' => 'Request array is empty'
			];
		}

		$this->db->query('DELETE FROM users WHERE username = ?', [$username]);
		$aff = $this->db->affected_rows();

		return [
			'status' => 200,
			'affected_rows' => $aff
		];

	}
}
