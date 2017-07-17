<?php

namespace App\Models;

use PDO;
use \App\Token;
use \App\Mail;

class User extends \Core\Model
{
	public $errors = [];


	public function __construct($data = [])
	{
		foreach ($data as $key => $value)
			$this->$key = $value;
	}

	public function save()
	{
		$this->validate();

		if (empty($this->errors))
		{		
			$password_hash = password_hash($this->password, PASSWORD_DEFAULT);
				
			$sql = "INSERT INTO users (name, email, password_hash)
					VALUES (:name, :email, :password_hash)";

			$db = static::getDB();
			$stmt = $db->prepare($sql);

			$stmt->bindValue(':name', $this->name, PDO::PARAM_STR);
			$stmt->bindValue(':email', $this->email, PDO::PARAM_STR);
			$stmt->bindValue(':password_hash', $password_hash, PDO::PARAM_STR);

			return $stmt->execute();
		}
		return false;
	}

	public function validate()
	{
		if ($this->name == '')
			$this->errors[] = "Name is required";	

		if (strlen($this->name) > 50 )
			$this->errors[] = "Username must be less than 50 characters";	

		if ($this->nameExists($this->name))
			$this->errors[]	= "This name is already taken";
	
		if (filter_var($this->email, FILTER_VALIDATE_EMAIL) === false)
			$this->errors[] = "Invalid email format";	

		if (static::emailExists($this->email))
			$this->errors[]	= "This email is already registered";

		if (strlen($this->password) < 6)
			$this->errors[]	= "Please enter at least 6 characters for the password";

		if (preg_match('/.*[a-z]+.*/i', $this->password) == 0)
			$this->errors[]	= "Password needs at least one letter";

		if (preg_match('/.*[0-9]+.*/i', $this->password) == 0)
			$this->errors[]	= "Password needs at least one digit";

		if ($this->password != $this->password_confirm)
			$this->errors[]	= "Passwords don't match";
	}			

	public static function emailExists($email)
	{
		return static::findByEmail($email) !== false;
	}

	public static function findByEmail($email)
	{
		$sql = "SELECT * FROM users WHERE email = :email";

		$db = static::getDB();
		$stmt = $db->prepare($sql);
		$stmt->bindValue(':email', $email, PDO::PARAM_STR);
		$stmt->execute();	

		return $stmt->fetch();	
	}

	public static function nameExists($name)
	{
		return static::findByName($name) !== false;
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
		
		if ($user)
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
		$user = static::findById($user['id']);	

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

}

?>
