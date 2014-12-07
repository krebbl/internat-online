<?php
/* SVN FILE: $Id: app_controller.php 7945 2008-12-19 02:16:01Z gwoo $ */
/**
 * Short description for file.
 *
 * This file is application-wide controller file. You can put all
 * application-wide controller-related methods here.
 *
 * PHP versions 4 and 5
 *
 * CakePHP(tm) :  Rapid Development Framework (http://www.cakephp.org)
 * Copyright 2005-2008, Cake Software Foundation, Inc. (http://www.cakefoundation.org)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @filesource
 * @copyright     Copyright 2005-2008, Cake Software Foundation, Inc. (http://www.cakefoundation.org)
 * @link          http://www.cakefoundation.org/projects/info/cakephp CakePHP(tm) Project
 * @package       cake
 * @subpackage    cake.app
 * @since         CakePHP(tm) v 0.2.9
 * @version       $Revision: 7945 $
 * @modifiedby    $LastChangedBy: gwoo $
 * @lastmodified  $Date: 2008-12-18 18:16:01 -0800 (Thu, 18 Dec 2008) $
 * @license       http://www.opensource.org/licenses/mit-license.php The MIT License
 */
/**
 * Short description for class.
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @package       cake
 * @subpackage    cake.app
 */

App::import('Model','group');

class AppController extends Controller {
	var $helpers = array('form', 'javascript', 'html', 'myHtml','time');
	var $components = array('Acl', 'Auth', 'RequestHandler','History');
	var $createAction = 'edit';
	
	protected function callCreateAction(){
		$this->redirect($this->createAction);
	}
	
	function goBack(){
		$this->History->goBack();
	}
	
	function listAction() {
		if(!empty($this->data)){
			if(isset($this->data['create'])){
				$this->callCreateAction();
			}else if(isset($this->data['delete'])){
				$this->doDelete();
				// $this->redirect('index');
			}else if(isset($this->data['export'])){
				$this->export();
			}
		}
	}
	
	protected function getSemesterFromRequest(){
		$id = $this->data['semesterId'];
		$semester = $this->SchoolSemester->findSemesterByIdOrGetCurrent($id);
		if(count($semester) == 0){
			return false;
		}else{
			$this->data['semesterId'] = $semester['SchoolSemester']['id'];
		}
		return $semester;
	}
	
    function beforeFilter() {
        //Configure AuthComponent
        $this->Auth->authorize = 'actions';
        $this->Auth->loginAction = array('controller' => 'users', 'action' => 'login');
		$this->Auth->loginRedirect = array('controller' => 'pages', 'action' => 'display');
        $this->Auth->logoutRedirect = array('controller' => 'users', 'action' => 'login');
        
        $this->Auth->actionPath = 'c/';		
 		$user = $this->Auth->user();
		if(!empty($user)){
			$group = new Group();
			$group = $group->findById($user['User']['group_id']);
			if($group['Group']['name'] == 'admins'){
				$this->Auth->allow('*');
			}
		}
		$this->set('authorized',!empty($user));
		$this->History->startup($this);

		if(!empty($this->data) && isset($this->data['cancel'])){
			$this->History->goBack(0);
		}
    }
}
?>