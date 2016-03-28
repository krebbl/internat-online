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

	/**
	 * uploads files to the server
	 * @params:
	 *    $folder  = the folder to upload the files e.g. 'img/files'
	 *    $formdata   = the array containing the form files
	 *    $itemId  = id of the item (optional) will create a new sub folder
	 * @return:
	 *    will return an array with the success of each file upload
	 */
	function uploadFiles($folder, $formdata, $itemId = null)
	{
		// setup dir names absolute and relative
		$folder_url = WWW_ROOT . $folder;
		$rel_url = $folder;

		// create the folder if it does not exist
		if (!is_dir($folder_url)) {
			mkdir($folder_url);
		}

		// if itemId is set create an item folder
		if ($itemId) {
			// set new absolute folder
			$folder_url = WWW_ROOT . $folder . '/' . $itemId;
			// set new relative folder
			$rel_url = $folder . '/' . $itemId;
			// create directory
			if (!is_dir($folder_url)) {
				mkdir($folder_url);
			}
		}

		// list of permitted file types, this is only images but documents can be added
		$permitted = array('image/gif', 'image/jpeg', 'image/pjpeg', 'image/png');

		// loop through and deal with the files
		foreach ($formdata as $file) {
			// replace spaces with underscores
			$filename = str_replace(' ', '_', $file['name']);
			// assume filetype is false
			$typeOK = false;
			// check filetype is ok
			foreach ($permitted as $type) {
				if ($type == $file['type']) {
					$typeOK = true;
					break;
				}
			}

			// if file type ok upload the file
			if ($typeOK) {
				// switch based on error code
				switch ($file['error']) {
					case 0:
						// check filename already exists
						if (!file_exists($folder_url . '/' . $filename)) {
							// create full filename
							$full_url = $folder_url . '/' . $filename;
							$url = $rel_url . '/' . $filename;
							// upload the file
							$success = move_uploaded_file($file['tmp_name'], $full_url);
						} else {
							// create unique filename and upload file
							ini_set('date.timezone', 'Europe/London');
							$now = date('Y-m-d-His');
							$full_url = $folder_url . '/' . $now . "_" . $filename;
							$url = $rel_url . '/' . $now . "_" . $filename;
							$success = move_uploaded_file($file['tmp_name'], $full_url);
						}
						// if upload was successful
						if ($success) {
							// save the url of the file
							$result['urls'][] = $url;
						} else {
							$result['errors'][] = "Error uploaded $filename. Please try again.";
						}
						break;
					case 3:
						// an error occured
						$result['errors'][] = "Error uploading $filename. Please try again.";
						break;
					default:
						// an error occured
						$result['errors'][] = "System error uploading $filename. Contact webmaster.";
						break;
				}
			} elseif ($file['error'] == 4) {
				// no file was selected for upload
				$result['nofiles'][] = "No file Selected";
			} else {
				// unacceptable file type
				$result['errors'][] = "$filename cannot be uploaded. Acceptable file types: gif, jpg, png.";
			}
		}
		return $result;
	}
}
?>