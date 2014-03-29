<?php
class WelcomeController extends Yaf_Controller_Abstract {

    public function indexAction() {//默认Action

		$this->getView()->assign("content","welcome");
		
		$this->getView()->assign("title","Hello World");
    }
}


?>