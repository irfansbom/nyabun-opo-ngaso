<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Student extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}

	public function get_all_students()
	{
		$query = $this->db->query('SELECT * FROM students ORDER BY id');
		if ($this->db->error()['code'] !== 0) {
			return ['error' => 'db_error', 'code' => $this->db->error()['code']];
		}

		return ['students' => $query->result_array()];
	}

	public function get_students_by_id(string $id = null, bool $strict = false)
	{
		if ($id === null || strlen($id) === 0) {
			return ['students' => []];
		}

		if ($strict) {
			$query = $this->db->query('SELECT * FROM students WHERE id = ? ORDER BY id', [$id]);
		} else {
			$query = $this->db->query('SELECT * FROM students WHERE id LIKE ? ORDER BY id', ['%' . $id . '%']);
		}

		if ($this->db->error()['code'] !== 0) {
			return ['error' => 'db_error', 'code' => $this->db->error()['code']];
		}

		return ['students' =>$query->result_array()];

	}

	public function get_students_by_name(string $name = null, bool $strict = false)
	{
		if ($name === null || strlen($name) === 0) {
			return ['students' => []];
		}

		if ($strict) {
			$query = $this->db->query('SELECT * FROM students WHERE name = ? ORDER BY name', [$name]);
		} else {
			$query = $this->db->query('SELECT * FROM students WHERE name LIKE ? ORDER BY name', ['%' . $name . '%']);
		}

		if ($this->db->error()['code'] !== 0) {
			return ['error' => 'db_error', 'code' => $this->db->error()['code']];
		}

		return ['students' =>$query->result_array()];
	}

	public function validate_student(array $student_array = null)
	{
		if ($student_array === null) {
			return [
				'error' => 'student array is null'
			];
		}

		if (preg_match('/(^[\d]{9}$|^[\d]{2}[.][\d]{4}$)/', $student_array['id']) !== 1) {
			$data['error']['id'] = 'Student id is not match (i.e. 16.1111 or 211231233)';
		}

		if (strlen($student_array['name']) === 0) {
			$data['error']['name'] = 'Student name is empty';
		}

		if (strlen($student_array['name']) > 120) {
			$data['error']['name'] = 'Student name should be less than 120 characters';
		}

		if (!filter_var($student_array['email'], FILTER_VALIDATE_EMAIL)) {
			$data['error']['email'] = 'Email is not valid';
		}

		if (preg_match('/^[\d]{4}[-][\d]{1,2}[-][\d]{1,2}$/', $student_array['dob']) === 1) {
			$re = explode('-', $student_array['dob']);
			if (!checkdate((int)$re[1], (int)$re[2], (int)$re[0])) {
				$data['error']['dob'] = 'Date is not valid or out of range (should be yyyy-mm-dd)';
			}
		} else {
			$data['error']['dob'] = 'Date is not well formed (i.e. yyyy-mm-dd)';
		}

		if (strlen($student_array['address']) < 5) {
			$data['error']['address'] = 'Please provide more detailed address';
		}

		if (preg_match('/^[\d]{3,15}$/', $student_array['phone']) !== 1) {
			$data['error']['phone'] = 'Phone number is not valid (should be 3 - 15 digit)';
		}

		if (strlen($student_array['father_name']) === 0) {
			$data['error']['father_name'] = 'Father name is empty';
		}

		if (strlen($student_array['father_name']) > 120) {
			$data['error']['father_name'] = 'Father name should be less than 120 characters';
		}

		if (strlen($student_array['mother_name']) === 0) {
			$data['error']['mother_name'] = 'Mother name is empty';
		}

		if (strlen($student_array['mother_name']) > 120) {
			$data['error']['mother_name'] = 'Mother name should be less than 120 characters';
		}

		if (!isset($data['error'])) {
			$data = [];
			array_push($data, $student_array['id']);
			array_push($data, $student_array['name']);
			array_push($data, $student_array['email']);
			array_push($data, $student_array['dob']);
			array_push($data, $student_array['address']);
			array_push($data, $student_array['phone']);
			array_push($data, $student_array['father_name']);
			array_push($data, $student_array['mother_name']);

		}

		return $data;
	}

	public function add_student(array $student_array = null)
	{
		$data = $this->validate_student($student_array);
		if (isset($data['error'])) {
			return ['error' => $data['error']];
		}

		$this->db->query('INSERT INTO students VALUES (? , ? , ? , ? , ? , ? , ? , ?)', $data);

		if ($this->db->error()['code'] !== 0) {
			return ['error' => 'db_error', 'code' => $this->db->error()['code']];
		}

		return $this->get_students_by_id($data[0], true);
	}

	public function put_student(array $student_array = null)
	{
		$data = $this->validate_student($student_array);
		if (isset($data['error'])) {
			return ['error' => $data['error']];
		}
		
		for ($i=1; $i < 8; $i++) { 
			$data[$i+7] = $data[$i];
		}

		$this->db->query(
			'INSERT INTO students VALUES (? , ? , ? , ? , ? , ? , ? , ?) ON DUPLICATE KEY '.
			'UPDATE name = ?, email = ?, dob = ?, address = ?, phone = ?, father_name = ?, mother_name = ?', 
		$data);

		if ($this->db->error()['code'] !== 0) {
			return ['error' => 'db_error', 'code' => $this->db->error()['code']];
		}

		return $this->get_students_by_id($data[0], true);
	}

	public function delete_student(string $id = null)
	{
		if ($id === null){
			$aff = 0;			
		}
		else {
			$this->db->query('DELETE FROM students WHERE id = ?', [$id]);
			$aff = $this->db->affected_rows();
		}

		return ['affected_rows' => $aff];

	}
}
