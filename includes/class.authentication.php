<?php

/*
	Authentication Class. 
	
	Still under development...
	
	1. login() will first try to validate the user via sessions, then cookies and, finally, normal form login if passed an array of credentials (an array variable of 'remember' set to true will create a persistent login cookie). login() returns true if authenticated, false if not.
	2. logout() will remove all associated cookies and sessions and then, if passed a variable, will redirect to a certain page.
	3. redirect() is a basic php redirect function.
	4. hash() will sha1 encrypt a passed variable using the salt defined in the config file.
	5. identical() will just check if two values are the same.
	6. user() will retrieve the current user info from the database.
	7. register() will register a new user with the passed credentials...still under development...
	
	
	USAGE:
	
	$auth = new Authentication();
	
	$credentials = array('username' => 'joe', 'password = 'strummer', 'remember' = true);
	
	if($auth->login($credentials))
		$auth->redirect('index.php');
	else
		$auth->logout('login.php?error=1');
		
	$user = $auth->user();
	
	
	NOTES:::

	login
	logout
	require user level to view page?
	session login
	cookie login
	store session data
	create hashed password
	change password (all existing cookies destroyed)
	change other user info
	create user and send activation key
	activate user
	delete user
	find if two strings are identical (for password changes and such)
	
	 When the user successfully logs in with Remember Me checked, a login cookie is issued in addition to the standard session management cookie.[2]
	The login cookie contains the user's username, a series identifier, and a token. The series and token are unguessable random numbers from a suitably large space. All three are stored together in a database table.
	When a non-logged-in user visits the site and presents a login cookie, the username, series, and token are looked up in the database.
	If the triplet is present, the user is considered authenticated. The used token is removed from the database. A new token is generated, stored in database with the username and the same series identifier, and a new login cookie containing all three is issued to the user.
	If the username and series are present but the token does not match, a theft is assumed. The user receives a strongly worded warning and all of the user's remembered sessions are deleted.
	If the username and series are not present, the login cookie is ignored.
	
	Note, however, that in the Drupal implementation at least, the "user id" that is included in the cookie is the numeric id (uid) assigned to the user, not the user's login name. The uid cannot be used to log in and reveals very little information from a privacy perspective, so I'm not sure how important this issue is. But if your site has usernames without a similar associated user id, leaving the username out of the PL cookie might be a good choice.
	
	Yes, when a user changes his or her password, all existing PL series should be destroyed. Thanks for documenting this requirement. The Drupal implementation already does this.
	
	REFERENCES:
	http://en.wikipedia.org/wiki/Session%5Ffixation
	http://codingforums.com/showthread.php?t=159869
	http://jaspan.com/improved_persistent_login_cookie_best_practice
	http://snipplr.com/view/11/login-class/

*/

class Authentication
{
	public $loggedin = false;
	private $db;
	
	public function login($credentials = array())
	{
		return $this->attemptLogin($credentials);
	}
	
	public function logout($redirect = null)
	{
		$this->removeCookieData();
		$this->removeSessionData();
		if($redirect)
			$this->redirect($redirect);
	}
	
	public function redirect($redirect)
	{
		header('Location:' . $redirect);
		exit();
	}
	
	public function hash($value)
	{
		return sha1(SECRET_KEY . $value);
	}
	
	public function identical($value1, $value2)
	{
		if($value1 == $value2)
			return true;
		else
			return false;
	}
	
	public function user()
	{
		session_start();
		if(!isset($_SESSION['userID']))
			return false;
			
		$db = new Database(DB_SERVER, DB_USER, DB_PASS, DB_DATABASE);
		$db->connect();
		$userID = $db->escape($_SESSION['userID']);
		$result = $db->query_first("SELECT * FROM users WHERE id = '$userID'");
		$db->close();
		return $result;
	}
	
	public function register($credentials = array())
	{
		$credentials['password'] = $this->hash(trim($credentials['password']) . trim($credentials['username']));
		$credentials['activation_key'] = $this->hash(uniqid(mt_rand(), true) . trim($credentials['username']));
		$db = new Database(DB_SERVER, DB_USER, DB_PASS, DB_DATABASE);
		$db->connect();
		$newuserID = $db->query_insert('users', $credentials);
		$newuser = $db->query_first("SELECT * FROM users WHERE id = '$newuserID'");
		$db->close();
		return $newuser;
	}
	
	private function attemptLogin($credential)
	{
		if($this->attemptSessionLogin()){ return true; }
		elseif($this->attemptCookieLogin()){ return true; }
		else
		{
			if(!empty($credential['username']) && !empty($credential['password']))
			{
				$db = new Database(DB_SERVER, DB_USER, DB_PASS, DB_DATABASE);
				$db->connect();
				$clean_user = $db->escape(trim($credential['username']));
				$clean_pass = $this->hash($db->escape(trim($credential['password'])) . $clean_user);
				$result = $db->query_first("SELECT * FROM users WHERE activated = 'y' AND username = '$clean_user' AND password = '$clean_pass'");
				$db->close();
				if($result['username'] == $clean_user && $result['password'] = $clean_pass)
				{
					if(!empty($credential['remember']))
					{
						$this->removeCookieData($result['id']);
						$this->storeCookieData(array('userID' => $result['id']));
					}
					$this->storeSessionData(array('userID' => $result['id']));
					$this->loggedin = true;
					return true;
				}
			}	
		}
		return false;
	}
	
	private function attemptSessionLogin()
	{
		session_name('auth_session');
		session_start();
		if ((isset($_SESSION['time']) && (time() < ($_SESSION['time'] + 1800))) && (isset($_SESSION['fingerprint']) && $_SESSION['fingerprint'] == $this->hash($_SERVER['HTTP_USER_AGENT'] . $_SERVER['REMOTE_ADDR'])) && isset($_SESSION['userID']))
		{
			//session_regenerate_id(true);
			$_SESSION['time'] = time();
			$this->loggedin = true;
			return true;
		}
		$this->removeSessionData();
		return false;
	}
	
	private function attemptCookieLogin()
	{
		if(isset($_COOKIE['auth_cookie']))
		{
			$data = json_decode(stripslashes($_COOKIE['auth_cookie']), true);
			$db = new Database(DB_SERVER, DB_USER, DB_PASS, DB_DATABASE);
			$db->connect();
			$userID = $db->escape($data['u']);
			$identifier = $db->escape($data['i']);
			$token = $db->escape($data['t']);			
			$result = $db->query_first("SELECT * FROM user_sessions WHERE userID = '$userID' AND identifier = '$identifier' AND token = '$token'");
			$db->close();
			if($result['userID'] == $userID && $result['identifier'] == $identifier && $result['token'] == $token)
			{
				$this->storeCookieData(array('userID' => $result['userID'], 'identifier' => $result['identifier']));
				$this->storeSessionData(array('userID' => $result['userID']));
				$this->loggedin = true;
				return true;
			}
			$this->removeCookieData();
		}
		return false;
	}
	
	private function storeSessionData($values = array())
	{
		session_name('auth_session');
		session_start();
		$_SESSION['userID'] = $values['userID'];
		$_SESSION['time'] = time();
		$_SESSION['fingerprint'] = $this->hash($_SERVER['HTTP_USER_AGENT'] . $_SERVER['REMOTE_ADDR']);
	}
	
	private function storeCookieData($values = array())
	{
		$db = new Database(DB_SERVER, DB_USER, DB_PASS, DB_DATABASE);
		$db->connect();
		if($values['identifier'])
		{
			$userID = $values['userID'];
			$identifier = $values['identifier'];
			$data['token'] = $this->hash(uniqid(mt_rand(), true) . $userID);
			$data['last_active'] = 'NOW()';
			$db->query_update('user_sessions', $data, "userID = '$userID' AND identifier = '$identifier'");
			$cookie_values = json_encode(array('u' => $userID, 'i' => $identifier, 't' => $data['token']));
		}
		else
		{
			$data['userID'] = $values['userID'];
			$data['identifier'] = $this->hash(uniqid(mt_rand(), true) . $values['userID']);
			$data['token'] = $this->hash(uniqid(mt_rand(), true) . $values['userID']);
			$db->query_insert('user_sessions', $data);
			$cookie_values = json_encode(array('u' => $data['userID'], 'i' => $data['identifier'], 't' => $data['token']));
		}
		setcookie('auth_cookie', $cookie_values, time() + 2592000, '/');
		$db->close();
	}
	
	private function removeSessionData()
	{
		session_name('auth_session');
		session_start();
		$_SESSION = array();
		session_unset();
		session_destroy();
		$this->loggedin = false;
	}
	
	private function removeCookieData($userID = null)
	{
		$db = new Database(DB_SERVER, DB_USER, DB_PASS, DB_DATABASE);
		$db->connect();
		if(isset($_COOKIE['auth_cookie']))
		{
			$data = json_decode(stripslashes($_COOKIE['auth_cookie']), true);
			$userID = $db->escape($data['u']);
			$identifier = $db->escape($data['i']);
			$db->query("DELETE FROM user_sessions WHERE userID = '$userID' AND identifier = '$identifier'");
			setcookie('auth_cookie', '', time() - 3600, '/');
		}
		if(isset($userID))
		{
			$limit = 5;
			$result = $db->fetch_all_array("SELECT * FROM user_sessions WHERE userID = '$userID' ORDER BY last_active DESC");
			if(count($result) > $limit)
			{
				$i = 1;
				foreach($result as $value)
				{
					if($i <= $limit)
					{
						$id = $value['id'];
						$db->query("DELETE FROM user_sessions WHERE id = '$id'");
					}
					$i++;
				}
			}
		}
		$this->loggedin = false;
		$db->close();
	}
}