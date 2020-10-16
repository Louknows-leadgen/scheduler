<?php

class Home extends Controller{
	public $layout = 'main';
	public $view = 'home';

	public function index($name = ''){
		// $user = $this->model('user');
		// $user->name = $name;
		// echo $user->name;
		$this->view($this->layout,$this->view,'index');
	}
}