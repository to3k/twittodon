<?php
    header('Content-Type: text/html; charset=utf-8');
	require("/*mysql config file*/");
	$mysqli = mysqli_connect($host, $user, $pass, $nazwa_bazy) or die('ERROR TD01');
	mysqli_set_charset($mysqli, "utf8mb4");

    if(isset($_POST['twitter']) OR isset($_POST['mastodon']))
    {
        $message1 = "";
		$message2 = "";
		
		$twitter = trim(addslashes(strip_tags($_POST['twitter'])));
        $check1 = '/^[A-Za-z0-9_]{1,15}$/';
        if(!preg_match($check1, $twitter))
        {
            $message1 = "<message-red><img src=\"/img/fail.png\" height=\"15px\" />   Invalid format! Correct it and try again. Format should be: USERNAME without @ (e.g. theto3k).<br>If further failures occur, report the problem using <a href=\"bug_report.php\" target=\"_blank\">this form</a>.</message-red>";
        }

        $mastodon = trim(addslashes(strip_tags($_POST['mastodon'])));
        $check2 = '/^[a-zA-Z0-9_]+@[a-zA-Z0-9\-.]+\.[a-zA-Z]+/';
        if(!preg_match($check2, $mastodon))
        {
            $message2 = "<message-red><img src=\"/img/fail.png\" height=\"15px\" />   Invalid format! Correct it and try again. Format should be: USERNAME@INSTANCE (e.g. to3k@mstdn.social).<br>If further failures occur, report the problem using <a href=\"bug_report.php\" target=\"_blank\">this form</a>.</message-red><br>";
        }

		if(empty($message1) AND empty($message2))
		{
			$query = "SELECT * FROM connections WHERE twitter_login='".$twitter."' AND mastodon_login='".$mastodon."' LIMIT 1";
			$result = mysqli_query($mysqli, $query) or die('ERROR TD02');

			if(mysqli_num_rows($result) == false)
			{
				$nitter_link = "https://nitter.net/".$twitter;

                $curl = curl_init($nitter_link);
                curl_setopt($curl, CURLOPT_URL, $nitter_link);
                curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
                curl_setopt($curl, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/88.0.4324.182 Safari/537.36');
                curl_setopt($curl, CURLOPT_TIMEOUT, 30);
                curl_setopt($curl, CURLOPT_HEADER, 0);	

                $site_source_code = curl_exec($curl);
                for($i=1; $i<=5; $i++)
                {
                    if($site_source_code == "") { $site_source_code=curl_exec($curl); }
                    else { break; }
                }

				preg_match("(class=\"profile-card-fullname\".+?>(.+?)</a>)is", $site_source_code, $phrase);
				$twitter_name = addslashes(strip_tags($phrase[1]));

				if(empty($twitter_name))
				{
					$message1 = "<message-red><img src=\"/img/fail.png\" height=\"15px\" />   Are you sure that this account exists? Check if entered username is correct.<br>If further failures occur, report the problem using <a href=\"bug_report.php\" target=\"_blank\">this form</a>.</message-red>";
				}

				$explode = explode("@", $mastodon);
				$mastodon_user = $explode[0];
				$mastodon_server = $explode[1];
				$mastodon_link = "https://".$explode[1]."/@".$explode[0];
				$mastodon_rss = $mastodon_link.".rss";
				
                $curl = curl_init($mastodon_rss);
                curl_setopt($curl, CURLOPT_URL, $mastodon_rss);
                curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
                curl_setopt($curl, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/88.0.4324.182 Safari/537.36');
                curl_setopt($curl, CURLOPT_TIMEOUT, 30);
                curl_setopt($curl, CURLOPT_HEADER, 0);	

                $site_source_code = curl_exec($curl);
                for($i=1; $i<=5; $i++)
                {
                    if($site_source_code == "") { $site_source_code=curl_exec($curl); }
                    else { break; }
                }
                
				preg_match("(<title>(.+?)</title>)is", $site_source_code, $phrase);
				$mastodon_name = addslashes(strip_tags($phrase[1]));

				if(empty($mastodon_name))
				{
					$message2 = "<message-red><img src=\"/img/fail.png\" height=\"15px\" />   Are you sure that this account exists? Check if entered username is correct.<br>If further failures occur, report the problem using <a href=\"bug_report.php\" target=\"_blank\">this form</a>.</message-red><br>";
				}

				$today = date("Y-m-d");
				if(empty($message1) AND empty($message2))
				{
					$add = "INSERT INTO connections (twitter_login, twitter_verified, mastodon_login, mastodon_verified, twitter_name, mastodon_name, date) VALUES ('".$twitter."', '0', '".$mastodon."', '0', '".$twitter_name."', '".$mastodon_name."', '".$today."')";
					mysqli_query($mysqli, $add) or die('ERROR TD03');
				}
			}
			
			if(empty($message1) AND empty($message2))
			{
				header("Location: confirm.php?t=".$twitter."&m=".$mastodon);
			}
		}
	}

	mysqli_close($mysqli);
	
	//Change language
	$full_url = "https://pl.twittodon.com".$_SERVER['REQUEST_URI'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8">
	<meta name="Author" content="Tomasz Dunia">
	<meta name="Description" content="Twittodon.com - Connect your Twitter and Mastodon accounts and verify it to let you followers be sure that those are your official accounts!" />
	<meta name="Keywords" content="twitter, mastodon, fediverse, connect, verify" />
	<meta name="viewport" content="width=device-width, initial-scale=0.7">
	<title>Connect - Twittodon.com - Connect your Twitter and Mastodon accounts and verify it!</title>
	<link rel="icon" href="favicon.ico" type="image/x-icon"/>
	<link rel="shortcut icon" href="favicon.ico" type="image/x-icon"/>
	
	<style>
		body {
		  font-family: Verdana;
		  font-size: 14px;
		  margin: 40px;
		  background: #333333;
		  display: flex;
		  align-items: center;
		  text-align: center;
		  justify-content: center;
		  place-items: center;
		}

		.container {
		  position: relative;
		  width: 750px;
		  border-radius: 20px;
		  padding: 40px;
		  box-sizing: border-box;
		  background: #333333;
		  box-shadow: 10px 10px 20px 10px #000000, -10px -10px 20px 10px #666666;
		}

		.home {
		  font-family: Verdana;
		  font-size: 12px;
		  color: #ffffff;
		  text-shadow: 0 0 0.5em #000000, 0 0 0.5em #000000, 0 0 0.5em #000000;
		  height: 100px;
		  width: 100px;
		  background: url("/img/twittodon_logo_800x800_white_transparent.png");
		  background-size: cover;
		  margin: auto;
		  border-radius: 50%;
		  box-sizing: border-box;
		  box-shadow: 7px 7px 10px #000000, -7px -7px 10px #666666;
		  cursor: pointer;
		  transition: 0.5s;
		}

		home:hover {
		  box-shadow: none;
		}

		.inputs {
		  text-align: center;
		  margin-top: 30px;
		}

		label, input, button {
		  display: block;
		  width: 100%;
		  padding: 0;
		  border: none;
		  outline: none;
		  box-sizing: border-box;
		}

		label {
		  margin-bottom: 10px;
		  text-align: center;
		  color: #ffffff;
		}

		label:nth-of-type(2) {
		  margin-top: 12px;
		}
		
		message-green {
		  margin-bottom: 4px;
		  color: green;
		  font-size:12px;
		}
		
		message-green:nth-of-type(2) {
		  margin-top: 12px;
		}
		
		message-red {
		  margin-bottom: 4px;
		  color: red;
		  font-size:12px;
		}
		
		message-red:nth-of-type(2) {
		  margin-top: 12px;
		}

		input::placeholder {
		  color: #ffffff;
		  opacity: 0.5;
		}

		input {
		  font-family: Verdana;
		  font-size: 12px;
		  background: #333333;
		  color: #ffffff;
		  padding: 10px;
		  padding-left: 20px;
		  height: 50px;
		  text-align: center;
		  border-radius: 25px;
		  box-shadow: inset 5px 5px 5px #000000, inset -5px -5px 5px #666666;
		  -webkit-appearance: none;
		  -webkit-text-fill-color: #ffffff;
		  opacity: 1;
		}

		button {
		  font-family: Verdana;
		  font-size: 14px;
		  color: #ffffff;
		  margin-top: 20px;
		  background: none;
		  height: 40px;
		  border-radius: 20px;
		  cursor: pointer;
		  font-weight: 900;
		  box-shadow: 5px 5px 5px #000000, -5px -5px 5px #666666;
		  transition: 0.5s;
		}

		button:hover {
		  box-shadow: none;
		}
		
		a, a:hover, a:active, a:visited { color: white; }

		highlight_blue {
			color: #1DA1F2;
			font-weight: bold;
		}
		highlight_purple {
			color: #6364ff;
			font-weight: bold;
		}

		.lang {
		  font-family: Verdana;
		  font-size: 12px;
		  color: #ffffff;
		  text-shadow: 0 0 0.5em #000000, 0 0 0.5em #000000, 0 0 0.5em #000000;
		  height: 30px;
		  width: 30px;
		  margin: auto;
		  border-radius: 50%;
		  box-sizing: border-box;
		  box-shadow: 7px 7px 10px #000000, -7px -7px 10px #666666;
		  cursor: pointer;
		  transition: 0.5s;
          position: absolute;
          top: 15px;
          right: 15px;
		}
        .plflag {
			background: url("/img/pl_flag.png");
			background-size: cover;
		}
        .ukflag {
			background: url("/img/uk_flag.png");
			background-size: cover;
		}
	</style>
</head>

<body>
	<div class="container">
		<button type="button" class="lang plflag" onClick="location.href='<?php echo "$full_url"; ?>';"></button>
		<button type="button" class="home" onClick="location.href='https://twittodon.com';"></button>
		<div class="inputs">
		<form action="" method="POST" name="form">
			<label><highlight_blue>Your Twitter account:</highlight_blue></label>
			<?php
				echo "<input type=\"text\" name=\"twitter\" placeholder=\"USERNAME without @ (e.g. theto3k)\" value=\"".addslashes($twitter)."\" size=\"20\" autocomplete=\"off\"><br>";
			?>
            <?php 
				echo $message1;
			?>
			<label>&bull;&bull;&bull;</label><br>
			<label><highlight_purple>Your Mastodon account:</highlight_purple></label>
			<?php
				echo "<input type=\"text\" name=\"mastodon\" placeholder=\"USERNAME@INSTANCE (e.g. to3k@mstdn.social)\" value=\"".addslashes($mastodon)."\" size=\"20\" autocomplete=\"off\"><br>";
			?>
            <?php 
				echo $message2;
			?>
			<br>
		</div>
			<?php
				echo "<button type=\"submit\" id=\"ButtonNext\" name=\"next\" onclick=\"PleaseWaitButton()\">Next step</button>";
			?>
			<br><br>
			<label>
				<center>
					<table style="font-size: 12px;">
						<tr>
							<td style="text-align: center; padding-right: 15px; border-right: solid 1px white;">
							<a href="https://tomaszdunia.pl" target="_blank"><img src="/img/author.gif" style="border-radius: 50%; height: 80px;" /></a><br>
								Author:<br>
								Tomasz Dunia<br>
								<i>to3k</i>
							</td>
							<td style="vertical-align: top; padding-left: 15px; border-left: solid 1px white;">
								<img src="/img/website_icon.png" height="10px" /> Website: <a href="https://tomaszdunia.pl" target="_blank">tomaszdunia.pl</a><br>
								<img src="/img/twitter_icon.png" height="10px" /> Twitter: <a href="https://twitter.com/theto3k" target="_blank">@theto3k</a><br>
								<img src="/img/mastodon_icon.png" height="10px" /> Mastodon: <a href="https://mstdn.social/@to3k" target="_blank">to3k@mstdn.social</a><br>
								<img src="/img/email_icon.png" height="10px" /> Write to me using <a href="contact.php">contact form</a> (🇬🇧/🇵🇱).<br>
								<img src="/img/no_icon.png" height="10px" /> <img src="/img/cookies_icon.png" height="10px" /> This site is not using cookies.<br>
								<img src="/img/no_icon.png" height="10px" /> <img src="/img/eye_icon.png" height="10px" /> This site is free of any tracking scripts.<br>
								This site is transparent so:<br>
								<img src="/img/stats_icon.png" height="10px" /> <a href="stats.php">You have an access to it's statistics!</a><br>
							</td>
						</tr>
					</table>
				</center>
			</label>
		</form>
	</div>

	<script>
		function PleaseWaitButton() {
		// Alert the copied text
		//alert("Copied!");
		var btn = document.getElementById("ButtonNext");
		btn.innerHTML = "Please wait...";
		}
	</script>
</body>

</html>