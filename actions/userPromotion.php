<?php
class page{
	public $title;
	public $content;
	public function page(){
		$this -> title = "User Promotion";
	}
	public function main()
	{
		global $sql;
		global $rmut;
		global $user;
		$tmp = new Template();
		if($user['group_id'] == 1)
		{
			if(isset($_POST['submit']))
			{
				$author = $sql -> san($_POST['author']);
				$q = "SELECT * FROM users WHERE username LIKE '".$author."'";
				$temp = $sql -> query($q);
				if($sql -> numRows($temp) == 0)
				{
					$this -> content = $tmp -> get("userPromotionNameNotFound");
					$this -> content .= $tmp -> get("userPromotion");
				}
				else
				{
					$grp = $sql -> san($_POST['Groups']);
					$change = "UPDATE users SET group_id =".$grp. " WHERE username like '" .$author."'";
					$sql -> query($change);
					$grps = array(1 => "Admin", 2 => "Moderator", 3 => "Member", 4 => "Trusted Member", 5 => "Banned");
					$rmut = array("author" => $_POST['author'], "group" => $grps[$_POST['Groups']]);
					$this -> content .= Replace::on($tmp -> get("permissionsSuccess"));
				}
			}
			else
			{
				$this -> content = $tmp -> get("userPromotion");
			}
		}
		else
		{
			global $config;
			header("Location: " .$config['url']);
		}
	}
}
?>
