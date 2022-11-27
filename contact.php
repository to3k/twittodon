<?php
    header('Content-Type: text/html; charset=utf-8');
	require("/*mysql config file*/");
	$mysqli = mysqli_connect($host, $user, $pass, $nazwa_bazy) or die('ERROR TD01');
	mysqli_set_charset($mysqli, "utf8mb4");

    session_start();
	
	$alert = 0;
	if(isset($_POST['submit'])) {
		if(addslashes(strip_tags($_POST['form_address'])) != "" AND addslashes(strip_tags($_POST['form_name'])) != "" AND addslashes(strip_tags($_POST['form_message'])) != "")
		{
			$email = addslashes(strip_tags($_POST['form_address']));

			$check = '/^[a-zA-Z0-9.\-_]+@[a-zA-Z0-9\-.]+\.[a-zA-Z]{2,4}$/';

			if(preg_match($check, $email))
			{
				if($_SESSION['captcha'] != addslashes(strip_tags($_POST['user_code'])))
				{ 
					$alert = 1;
				} 
				else 
				{ 
					$message = "<html xmlns=\"http://www.w3.org/1999/xhtml\" xml:lang=\"en\" lang=\"en\">
						<head>
							<meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\" />
						</head>
						<body>
							<b>Submitter's address:</b> ".addslashes(strip_tags($_POST['form_address']))."<br>
							<b>Submitter's name:</b> ".addslashes(strip_tags($_POST['form_name']))."<br>
							<b>IP:</b> ".addslashes(strip_tags($_POST['ip']))."<br>
							<b>Message:</b><br>
							".addslashes(strip_tags($_POST['form_message']))."
						</body>
						</html>";
					$subject="Message from Twittodon.com ".date('d-m-Y H:i');
					$header = "MIME-Version: 1.0r\n"."Content-type: text/html; charset=utf-8\n";
					$header .= "From: ".addslashes(strip_tags($_POST['form_address']))."\n";
					$address = "contact@twittodon.com";
		
					mail($address, $subject, $message, $header);
					$alert = 2;
				}
			}
			else
			{
				$alert = 3;
			}	
		}
		else { $alert = 4; }
	}

	if($_SERVER['HTTP_CLIENT_IP'])
	{
	 $ip = $_SERVER['HTTP_CLIENT_IP'];
	}
	elseif($_SERVER['HTTP_X_FORWARDED_FOR'])
	{
	 $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
	}
	else
	{
	 $ip = $_SERVER['REMOTE_ADDR'];
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
	<title>Contact form - Twittodon.com - Connect your Twitter and Mastodon accounts and verify it!</title>
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

		label, input, button, textarea {
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

        textarea {
		  font-family: Verdana;
		  font-size: 12px;
		  background: #333333;
		  color: #ffffff;
		  padding: 10px;
		  padding-left: 20px;
		  text-align: center;
		  border-radius: 25px;
		  box-shadow: inset 5px 5px 5px #000000, inset -5px -5px 5px #666666;
		  -webkit-appearance: none;
		  opacity: 1;
          resize: vertical;
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
        <br>
		<label><h2>Contact form</h2></label>
		<label>&bull;&bull;&bull;&bull;&bull;&bull;&bull;&bull;&bull;&bull;&bull;&bull;&bull;&bull;&bull;&bull;&bull;&bull;&bull;&bull;&bull;&bull;&bull;&bull;&bull;&bull;&bull;&bull;&bull;&bull;</label>
		<?php
			if($alert==1)
			{
				echo "<h3><font color=\"red\"><img src=\"/img/fail.png\" height=\"15px\" />   Message not sent. Invalid CAPTCHA.</font></h3>";
			}
			elseif($alert==2)
			{
				echo "<h3><font color=\"green\">Message sent.</font></h3></body></html>";
				exit;
			}
			elseif($alert==3)
			{
				echo "<h3><font color=\"red\"><img src=\"/img/fail.png\" height=\"15px\" />   The message has not been sent. An invalid email address was provided.</font></h3>";
			}
			elseif($alert==4)
			{
				echo "<h3><font color=\"red\"><img src=\"/img/fail.png\" height=\"15px\" />   The message has not been sent. All fields must be filled.</font></h3>";
			}
		?>
		<div class="inputs">
			<form method="post" action="">
			<?php
				echo "<input type=\"hidden\" name=\"ip\" value=\"".$ip."\" />";
			?>
			<input type="text" name="form_address" placeholder="Enter your e-mail address, so I can write you back" <?php echo "value=\"".addslashes(strip_tags($_POST['form_address']))."\""; ?> size="30"><br>
			<input type="text" name="form_name" placeholder="Enter your name, so I know how to call you" <?php echo "value=\"".addslashes(strip_tags($_POST['form_name']))."\""; ?> size="30"><br>
			<textarea name="form_message" placeholder="Type your message here..." size="30" rows="15"><?php echo addslashes(strip_tags($_POST['form_message'])); ?></textarea><br>
			<img src="captcha.php" alt="Captcha" /><br>
			<input type="text" name="user_code" placeholder="Enter the code from the image"><br>
			<button type="submit" name="submit">Send</button><br>
			<br><br>
			</form>
		</div>
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
	</div>
</body>

</html>