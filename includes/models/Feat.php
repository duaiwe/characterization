<?php

/**
 * Feat
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @package		 ##PACKAGE##
 * @subpackage ##SUBPACKAGE##
 * @author		 ##NAME## <##EMAIL##>
 * @version		 SVN: $Id: Builder.php 5845 2009-06-09 07:36:57Z jwage $
 */
class Feat extends BaseFeat {
	
	public function updateFromForm() {
		global $msg;
		$cache = array();
		$cache['error'] = array();
		
		// Skill Name
		$cache['name'] = $_POST['name'];
		if( empty($_POST['name']) ) {
			$msg->add('Feat name may not be blank.', Message::WARNING);
			$cache['error'][] = 'name';
		}
		else {
			$this->name = $_POST['name'];
		}
		
		// Feat Description
		$cache['description'] = $_POST['description'];
		if( empty($_POST['description']) ) {
			$msg->add('Feat description may not be blank.', Message::WARNING);
			$cache['error'][] = 'description';	
		}
		else {
			$this->description = $_POST['description'];
		}
		// End Model Data Updates
		
		// Update the form cache in the session if necessary.
		if( !empty($_POST['form_key']) ) {
			if( empty($cache['error']) ) {
				unset($_SESSION[$_POST['form_key']]);
			}
			else {
				$cache['form_key'] = $_POST['form_key'];
				$_SESSION['form_cache'] = $cache;
			}
		}

		return empty($cache['error']);
	}
}