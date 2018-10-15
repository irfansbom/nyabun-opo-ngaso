<?php

use Restserver\Libraries\REST_Controller;

defined('BASEPATH') or exit('No direct script access allowed');
require APPPATH . 'libraries/REST_Controller.php';
require APPPATH . 'libraries/Format.php';

class Api extends REST_Controller
{
	public function __construct($config = 'rest')
	{
		parent::__construct($config);
		$this->load->model('users');
	}

	public function index_get()
	{
		$this->response(['w' => 'w']);
	}

	public function users_get()
	{
		$query = $this->query('query');

		if ($query === null) {
			$response = $this->users->get_all_users();
		} else {
			$response = $this->users->get_users_by_search_query($query);
		}

		$this->response($response);
	}

	public function users_post()
	{
		$data = $this->post();
		$response = $this->users->add_user($data);

		$this->response($response);
	}

	public function users_put(string $username = null)
	{
		if ($username === null) {
			$response = ['status' => 400, 'error' => 'URL needs a username i.e (users/{username})'];
		} else {
			$data = $this->put();
			$data['username'] = $username;
			$response = $this->users->put_user($data);
		}

		$this->response($response);
	}

	public function users_delete(string $username = null)
	{
		if ($username === null) {
			$response = ['status' => 400, 'error' => 'URL needs a username i.e (users/{username})'];
		} else {
			$response = $this->users->delete_user($username);
		}

		$this->response($response);
	}
}
