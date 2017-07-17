<?php  

namespace App\Models;

use \App\Token;
use PDO;

class RememberedLogins extends \Core\Model
{
	public static function findByToken($token)
	{
		$token = new Token($token);
		$token_hash = $token->getHash();

		$db = static::getDB();	
	
		$sql = "SELECT * FROM remembered_logins WHERE token_hash = :token_hash";	
		$stmt = $db->prepare($sql);
		$stmt->bindValue(':token_hash', $token_hash, PDO::PARAM_STR);
		$stmt->execute();	

		$stmt->setFetchMode(PDO::FETCH_CLASS, get_called_class());

		return $stmt->fetch();	
	}

	public function getUser()
	{
		return User::findById($this->user_id);
	}

	public function hasExpired()
	{
		return strtotime($this->expires_at) < time();	
	}

	public function deleteCookie()
	{
		$sql = "DELETE FROM remembered_logins WHERE token_hash = :token_hash";	

		$db = static::getDB();
		$stmt = $db->prepare($sql);
		$stmt->bindValue(':token_hash', $this->token_hash, PDO::PARAM_STR);
		$stmt->execute();	
	}


}




?>
