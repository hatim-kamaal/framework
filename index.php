<?php

define ( "APP_FOLDER", "/hats/framework/", true );

// ini_set('display_startup_errors',1);
// ini_set('display_errors',1);
// error_reporting(-1);
session_start ();
// require_once 'lib/framework.inc';

/**
 *
 * @author Hatim Kamal
 *        
 *        
 */
class ModelBean {
	private $data;
	public function __construct() {
		$this->data = array ();
	}
	public function __get($property) {
		if (isset ( $this->data [$property] ))
			return $this->data [$property];
	}
	public function __set($name, $value) {
		$this->data [$name] = $value;
	}
	public function remove($name) {
		unset ( $this->data [$name] );
	}
	public function getData() {
		return $this->data;
	}
}

$vb = new ModelBean ();
class FormManager {
	private $code;
	public function __construct($form, $heading) {
		$code = "<form id='$form' method='post' action='' role='form'
			class='form-horizontal minHt'>
		
			<div class='container minHt'>
				<div class='form-group'>
					<div class='alert alert-success'>
						<b>$heading</b>
					</div>
				</div>
		";
		
		$msg = $this->vb->message;
		if (isset($msg)) {
			$code .= "<div class=form-group>
							<div class=alert alert-warning>$msg</div>
						</div>";
		}
	}
	
	
	
	public function addTextField($label, $name, $value = null) {
		$this->code .= "
		<div class='form-group'>
			<label for='$name' class='col-sm-3 control-label'>$label</label>
			<div class='col-sm-5'>
				<input name='$name' id='$name' type='text'
				value='$value' class='form-control' />
			</div>
		</div>";
	}
}

/**
 * Resources access for the application.
 *
 * @author Hatim Kamaal
 *        
 */
class Database {
	private $conn;
	private $queries;
	
	/**
	 * Private constructor
	 * so nobody else can instance it
	 */
	private function __construct() {
		$this->queries = parse_ini_file ( "queries.ini", true );
		// $this->conn = mysqli_connect ( "localhost", "olivezrt_pb", "P@ssw0rd", "olivezrt_passbook" );
		$this->conn = mysqli_connect ( "localhost", "root", "", "olivezrt_passbook" );
	}
	
	/**
	 * Call this method to get single instance of class.
	 *
	 * @return Paths
	 */
	public static function getInst() {
		static $inst = null;
		if ($inst === null) {
			$inst = new Database ();
		}
		return $inst;
	}
	/**
	 *
	 * @param unknown $query        	
	 * @return mysqli_result
	 */
	public function getResultSet($query) {
		$rs = $this->run ( $query );
		if ($rs instanceof mysqli_result) {
			if (mysqli_num_rows ( $rs ) > 0) {
				return $rs;
			}
		}
	}
	/**
	 * This method should be used to make sql string
	 *
	 * @param unknown $options        	
	 * @param unknown $string        	
	 * @return unknown
	 */
	private function makeString($code, $params) {
		$string = $this->queries [$code];
		
		$options = $params->getData ();
		if (is_array ( $options ) && count ( $options ) > 0) {
			foreach ( array_keys ( $options ) as $opt ) {
				$string = str_replace ( "~$opt~", $options [$opt], $string );
			}
		}
		return $string;
	}
	
	/**
	 */
	public function getErrorMsg() {
		return $this->conn->error;
	}
	
	/**
	 *
	 * @param unknown $query        	
	 */
	public function run($query) {
		return $this->conn->query ( $query );
	}
	
	/**
	 *
	 * @param unknown $query        	
	 * @param unknown $options        	
	 */
	public function runOptions($query, $options) {
		return $this->run ( $this->makeString ( $query, $options ) );
	}
	
	/**
	 *
	 * @return mysqli_result
	 */
	public function read($qcode, $params) {
		return $this->getResultSet ( $this->makeString ( $qcode, $params ) );
	}
	
	/**
	 *
	 * @param unknown $fname        	
	 * @param unknown $lname        	
	 * @return NULL
	 */
	public function update($qcode, $params) {
		if (! $this->run ( $this->makeString ( $qcode, $params ) )) {
			return false;
		} else {
			return true;
		}
	}
}
// Global veriable for easy access.
$db = Database::getInst ();

/**
 * Resources access for the application.
 *
 * @author Hatim Kamaal
 *        
 *        
 */
class FileManager {
	private $fileInfo;
	private $hostURI;
	
	/**
	 * Private constructor
	 * so nobody else can instance it
	 */
	private function __construct() {
		$this->fileInfo = parse_ini_file ( "paths.ini", true );
		$this->hostURI = "http://" . $_SERVER ['HTTP_HOST'] . "/hats/passbook";
	}
	
	/**
	 * Call this method to get single instance of class.
	 *
	 * @return Paths
	 */
	public static function getInst() {
		static $inst = null;
		if ($inst === null) {
			$inst = new FileManager ();
		}
		return $inst;
	}
	
	/**
	 *
	 * @param unknown $property        	
	 */
	public function getAction($property) {
		if (array_key_exists ( $property, $this->fileInfo )) {
			$val = $this->fileInfo [$property];
			// return "pages/$val"."Action.php";
			return "pages/$val.php";
		}
	}
	
	/**
	 *
	 * @param unknown $property        	
	 */
	public function getScript($property) {
		if (array_key_exists ( $property, $this->fileInfo )) {
			return $this->hostURI . "/decor/" . $this->fileInfo [$property];
		}
	}
	
	/**
	 *
	 * @param unknown $property        	
	 */
	public function getUrl($property) {
		if (array_key_exists ( $property, $this->fileInfo )) {
			return $this->hostURI . "/$property";
		}
	}
}

// Global veriable for easy access.
$fm = FileManager::getInst ();
/*
 * ==================================================================
 * ==================================================================
 *
 */

/**
 *
 * @author Hats
 */
abstract class AbstractAction {
	protected $vb;
	protected $db;
	protected $fm;
	
	/**
	 */
	public function __construct($urlArray) {
		// $this->viewbean = $GLOBALS ['viewbean'];
		$this->vb = $GLOBALS ['vb'];
		$this->vb->rest_url_part = $urlArray;
		
		$this->db = $GLOBALS ['db'];
		$this->fm = $GLOBALS ['fm'];
		
		$this->extracUserData ();
		
		$this->authenticate ();
		
		$this->handleRequest ();
	}
	
	/**
	 * Extract user details from session.
	 */
	private function extracUserData() {
		$this->vb->isUserLoggedIn = false;
		
		$userDetails = $this->getSession ( "USER_DETAILS" );
		if (isset ( $userDetails )) {
			$this->vb->isUserLoggedIn = true;
			$this->vb->UserData = $userDetails;
		}
		
		$this->vb->message = "";
		$msg = $this->getSession ( "ErrorMessage" );
		if (isset ( $msg ) && strlen ( $msg ) > 1) {
			$this->vb->message = $msg;
			$this->removeSession ( "ErrorMessage" );
		}
	}
	
	/**
	 */
	private function authenticate() {
		if (! $this->isRestricted ()) {
			return;
		}
		
		$lastReq = $this->getSession ( "lastRequest" );
		if (isset ( $lastReq )) {
			$session_life = time () - $lastReq;
			if ($this->vb->isUserLoggedIn && $session_life < 3601) {
				$this->setSession ( "lastRequest", time () );
			} else {
				$this->clearSession ();
				$this->setSession ( "ErrorMessage", "Your session has been expired." );
				$this->redirect ( $this->fm->getUrl ( "signin" ) );
			}
		} else {
			$this->setSession ( "ErrorMessage", "Your session has been expired." );
			$this->redirect ( $this->fm->getUrl ( "signin" ) );
		}
	}
	
	/**
	 */
	public function doDefault() {
	}
	
	/**
	 */
	public function handleRequest() {
		foreach ( $_GET as $key => $val ) {
			$this->vb->$key = $val;
		}
		foreach ( $_POST as $key => $val ) {
			$this->vb->$key = $val;
		}
		
		$method = $_SERVER ['REQUEST_METHOD'];
		if ($method === 'POST') {
			
			$action = 'do';
			if (isset ( $_POST ['ACTION_REFERENCE'] )) {
				$action .= $_POST ['ACTION_REFERENCE'];
			}
			
			if (strlen ( $action ) == 2) {
				$action = 'doDefault';
			}
			
			if (method_exists ( $this, $action )) {
				
				$callControlMethod = true;
				if (isset ( $_POST ['ACTION_REFERENCE'] )) {
					$beforeAction = "before" . $_POST ['ACTION_REFERENCE'];
				} else {
					$beforeAction = "beforeDefault";
				}
				if (method_exists ( $this, $beforeAction )) {
					$return = $this->$beforeAction ();
					if (isset ( $return )) {
						$callControlMethod = $return;
					}
				}
				
				if ($callControlMethod) {
					$this->$action ();
				}
			} else {
				// echo "No method is linked for " . $action;
			}
		}
		
		// Call the view
		$this->view ();
		
		$this->display ();
	}
	
	/**
	 */
	abstract public function view();
	abstract public function page();
	
	/**
	 */
	public function isRestricted() {
		return true;
	}
	
	/**
	 */
	public function isService() {
		return false;
	}
	
	/**
	 */
	public function isJson() {
		return false;
	}
	
	/**
	 *
	 * @param unknown $page        	
	 */
	final function redirect($page) {
		header ( "Location:$page" );
	}
	
	/**
	 */
	public function display() {
		global $vb, $fm, $db;
		
		if ($this->isService ()) {
			if ($this->isJson ()) {
				echo json_encode ( $vb->output_data );
			} else {
				echo $vb->output_data;
			}
		} else {
			require_once $fm->getAction ( "layout_main" );
		}
	}
	
	/**
	 *
	 * @param unknown $name        	
	 */
	public function removeSession($name) {
		if (isset ( $_SESSION [$name] )) {
			unset ( $_SESSION [$name] );
		}
	}
	/**
	 *
	 * @param unknown $property        	
	 * @return mixed
	 */
	public function getSession($property) {
		if (isset ( $_SESSION [$property] )) {
			return unserialize ( $_SESSION [$property] );
		}
	}
	/**
	 *
	 * @param unknown $name        	
	 * @param unknown $value        	
	 */
	public function setSession($name, $value) {
		$_SESSION [$name] = serialize ( $value );
	}
	/**
	 */
	public function clearSession() {
		foreach ( $_SESSION as $key => $value ) {
			if (isset ( $_SESSION [$key] )) {
				unset ( $_SESSION [$key] );
			}
		}
	}
}

/**
 *
 * @author Hats
 *        
 */
class RequestManager {
	
	public function filterURI() {
		$uri = $_SERVER['REQUEST_URI'];
		$uri = str_replace(APP_FOLDER, "", $uri);
		
		echo "$uri";
		
	}
	
	public function __construct() {

		$this->filterURI();
		
		$url = "/home";
		if (isset ( $_GET ['url'] )) {
			$url = $_GET ['url'];
		}
		
		if (strcmp ( $url, "url_403.shtml" ) == 0) {
			$url = "/error";
		}
		
		// $urlArray = array();
		$urlArray = explode ( "/", $url );
		$pageRequest = $urlArray [0];
		// Remove the first element.
		array_shift ( $urlArray );
		
		$action = $this->getAction ( $pageRequest );
		if (isset ( $action )) {
			// require_once '';
			new $action ( $urlArray );
			// new $action;
		}
	}
	
	/**
	 *
	 * @param unknown $request        	
	 * @return string
	 */
	private function getAction($request) {
		global $fm;
		$action = $fm->getAction ( $request );
		if (! isset ( $action )) {
			$action = "";
		}
		
		if (is_file ( $action )) {
			require_once $action;
			$urlArray = explode ( "/", $action );
			$actionClassName = $urlArray [count ( $urlArray ) - 1];
			return substr ( $actionClassName, 0, strlen ( $actionClassName ) - 4 );
		} else {
			require_once $fm->getAction ( "error" );
			return "Error";
		}
	}
}
new RequestManager ();