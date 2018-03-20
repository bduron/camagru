<?php

namespace App\Models;

use PDO;
use \App\Token;
use \App\Mail;
use \App\Models\User;

class User extends \Core\Model
{
	public $errors = [];


	public function __construct($data = [])
	{
		foreach ($data as $key => $value)
			$this->$key = $value;
	}

	public function updateProfile($data)
	{
		foreach ($data as $key => $value)
			$this->$key = $value;

		$this->validateProfile();

		if (empty($this->errors))
		{		
			$sql = "UPDATE users
					SET name = :name, email = :email
					WHERE id = :id";

			$db = static::getDB();
			$stmt = $db->prepare($sql);

			$stmt->bindValue(':name', $this->name, PDO::PARAM_STR);
			$stmt->bindValue(':email', $this->email, PDO::PARAM_STR);
			$stmt->bindValue(':id', $_SESSION['user_id'], PDO::PARAM_INT);

			return $stmt->execute();
		}
		return false;
	}

	public function updatePassword($data)
	{
		foreach ($data as $key => $value)
			$this->$key = $value;

		$this->validatePassword();

		$password_hash = password_hash($this->password, PASSWORD_DEFAULT);

		if (empty($this->errors))
		{		
			$sql = "UPDATE users
					SET password_hash = :password_hash
					WHERE id = :id";

			$db = static::getDB();
			$stmt = $db->prepare($sql);

			$stmt->bindValue(':password_hash', $password_hash, PDO::PARAM_STR);
			$stmt->bindValue(':id', $_SESSION['user_id'], PDO::PARAM_INT);

			return $stmt->execute();
		}
		return false;
	}

	public function save()
	{
		$this->validate();

		if (empty($this->errors))
		{		
			$password_hash = password_hash($this->password, PASSWORD_DEFAULT);
				
			$token = new Token();
			$hashed_token = $token->getHash();
			$this->activation_token = $token->getValue();

			$sql = "INSERT INTO users (name, email, password_hash, activation_hash)
					VALUES (:name, :email, :password_hash, :activation_hash)";

			$db = static::getDB();
			$stmt = $db->prepare($sql);

			$stmt->bindValue(':name', $this->name, PDO::PARAM_STR);
			$stmt->bindValue(':email', $this->email, PDO::PARAM_STR);
			$stmt->bindValue(':password_hash', $password_hash, PDO::PARAM_STR);
			$stmt->bindValue(':activation_hash', $hashed_token, PDO::PARAM_STR);

			return $stmt->execute();
		}
		return false;
	}


	public function validate()
	{
		$this->validateProfile();
		$this->validatePassword();
	}			

	public function validateProfile()
	{
		if ($this->name == '')
			$this->errors[] = "Name is required";	

		if (strlen($this->name) > 50 )
			$this->errors[] = "Username must be less than 50 characters";	

		if (strlen($this->name) < 6 )
			$this->errors[] = "Username must be at least 6 characters";	

		if ($this->nameExists($this->name, $this->id ?? null))
			$this->errors[]	= "This name is already taken";
	
		if (filter_var($this->email, FILTER_VALIDATE_EMAIL) === false)
			$this->errors[] = "Invalid email format";	

		if (static::emailExists($this->email, $this->id ?? null))
			$this->errors[]	= "This email is already registered";
	}			

	public function validatePassword()
	{
		if (strlen($this->password) < 6)
			$this->errors[]	= "Please enter at least 6 characters for the password";

		if (preg_match('/.*[a-z]+.*/i', $this->password) == 0)
			$this->errors[]	= "Password needs at least one letter";

		if (preg_match('/.*[0-9]+.*/i', $this->password) == 0)
			$this->errors[]	= "Password needs at least one digit";

		if ($this->password != $this->password_confirm)
			$this->errors[]	= "Passwords don't match";
	}			

	public static function emailExists($email, $ignore_id = null)
	{
		$user = static::findByEmail($email);
		if ($user)
			if ($user->id != $ignore_id)
				return true;
		return false;

	}

	public static function findByEmail($email)
	{
		$sql = "SELECT * FROM users WHERE email = :email";

		$db = static::getDB();
		$stmt = $db->prepare($sql);
		$stmt->bindvalue(':email', $email, PDO::PARAM_STR);
		$stmt->execute();	

		$stmt->setFetchMode(PDO::FETCH_CLASS, get_called_class());

		return $stmt->fetch();	
	}

	public static function nameExists($name, $ignore_id = null)
	{
		$user = static::findByName($name);
		if ($user)
			if ($user->id != $ignore_id)
				return true;
		return false;
	}

	public static function findByName($name)
	{
		$sql = "SELECT * FROM users WHERE name = :name";

		$db = static::getDB();
		$stmt = $db->prepare($sql);
		$stmt->bindValue(':name', $name, PDO::PARAM_STR);
		$stmt->execute();	

		$stmt->setFetchMode(PDO::FETCH_CLASS, get_called_class());

		return $stmt->fetch();	
	}

	public static function findById($id)
	{
		$sql = "SELECT * FROM users WHERE id = :id";

		$db = static::getDB();
		$stmt = $db->prepare($sql);
		$stmt->bindValue(':id', $id, PDO::PARAM_INT);
		$stmt->execute();	

		$stmt->setFetchMode(PDO::FETCH_CLASS, get_called_class());

		return $stmt->fetch();	
	}

	public static function authenticate($name, $password)
	{
		$user = static::findByName($name);
		
		if ($user && $user->is_active)
			if (password_verify($password, $user->password_hash))
				return $user;
		return false;
	}

	public function rememberLogin()
	{
		$token = new Token();
		$hashed_token = $token->getHash();
		$this->remember_token = $token->getValue();

		$this->expiry_timestamp = time() + 60 * 60 * 24 * 30;	

		$sql = 'INSERT INTO remembered_logins (token_hash, user_id, expires_at)
				VALUES (:token_hash, :user_id, :expires_at)';
		$db = static::getDB();
		$stmt = $db->prepare($sql);

		$stmt->bindValue(':token_hash', $hashed_token, PDO::PARAM_STR);
		$stmt->bindValue(':user_id', $this->id, PDO::PARAM_STR);
		$stmt->bindValue(':expires_at', date('Y-m-d H:i:s', $this->expiry_timestamp), PDO::PARAM_STR);

		return $stmt->execute();
	}

	public static function sendPasswordReset($email)
	{
		$user = static::findByEmail($email);	
		$user = static::findById($user->id);	

		if ($user)
		{
			if ($user->startPasswordReset())
				$user->sendPasswordResetEmail();
		}	
	}

	protected function startPasswordReset()
	{
		$token = new Token();
		$this->password_reset_token = $token->getValue();
		$hashed_token = $token->getHash();
		$expiry_timestamp = time() + 60 * 60 * 2;

		$sql = "UPDATE users 
				SET password_reset_hash = :token_hash,
				password_reset_expires_at = :expires_at
				WHERE id = :user_id";
		
		$db = static::getDB();	
		$stmt = $db->prepare($sql);
		$stmt->bindValue(':token_hash', $hashed_token, PDO::PARAM_STR);
		$stmt->bindValue(':user_id', $this->id, PDO::PARAM_STR);
		$stmt->bindValue(':expires_at', date('Y-m-d H:i:s', $expiry_timestamp), PDO::PARAM_STR);
		
		return $stmt->execute();
	}

	protected function sendPasswordResetEmail()
	{	
		$url = 'http://' . $_SERVER['HTTP_HOST'] . '/password/reset/' . $this->password_reset_token;
		$html = "Please click <a href=\"$url\">here</a> to reset your password.";
		
		Mail::send($this->email, 'Camagru Password reset', $html);
	
	}

	public static function findByPasswordReset($token)
	{
		$token = new Token($token);
		$hashed_token = $token->getHash();

		$sql = "SELECT * FROM users WHERE password_reset_hash = :token_hash";

		$db = static::getDB();
		$stmt = $db->prepare($sql);
		$stmt->bindValue(':token_hash', $hashed_token, PDO::PARAM_STR);
		$stmt->execute();	

		$stmt->setFetchMode(PDO::FETCH_CLASS, get_called_class());

		$user = $stmt->fetch();	

		if ($user)	
			if (strtotime($user->password_reset_expires_at) > time())
		   		return $user;	

	}

	public function resetPassword($password, $password_confirm)
	{
		$this->password = $password;
		$this->password_confirm = $password_confirm;

		$this->validate();
	
		if (empty($this->errors))
		{
			$password_hash = password_hash($this->password, PASSWORD_DEFAULT);	
		
			$sql = 'UPDATE users 
					SET password_hash = :password_hash,
						password_reset_hash = NULL,
						password_reset_expires_at = NULL
					WHERE id = :id';
			
			$db = static::getDB();
			$stmt = $db->prepare($sql);
			$stmt->bindValue(':password_hash', $password_hash, PDO::PARAM_STR);
			$stmt->bindValue(':id', $this->id, PDO::PARAM_INT);
			return $stmt->execute();	
		}
		return false;
	}

	public function sendActivationEmail()
	{	
		$url = 'http://' . $_SERVER['HTTP_HOST'] . '/signup/activate/' . $this->activation_token;
		$html = "Please click <a href=\"$url\">here</a> to confirm your registration.";
		
		Mail::send($this->email, 'Camagru - Confirm your account', $html);
	
	}

	public static function activate($token)
	{
		$token = new Token($token);
		$hashed_token = $token->getHash();	

		$sql = 'UPDATE users
				SET activation_hash = null, is_active = 1
				WHERE activation_hash = :hashed_token';	
		
		$db = static::getDB();
		$stmt = $db->prepare($sql);
		$stmt->bindValue(':hashed_token', $hashed_token, PDO::PARAM_STR);
		$stmt->execute();	
	}
}

?>
