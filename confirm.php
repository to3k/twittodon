<?php
    header('Content-Type: text/html; charset=utf-8');
	require("/*mysql config file*/");
	$mysqli = mysqli_connect($host, $user, $pass, $nazwa_bazy) or die('ERROR TD01');
	mysqli_set_charset($mysqli, "utf8mb4");

	$twitter = addslashes(strip_tags($_GET['t']));
	$mastodon = addslashes(strip_tags($_GET['m']));
	$explode = explode("@", $mastodon);
	$mastodon_user = $explode[0];
	$mastodon_server = $explode[1];
	$mastodon_link = "https://".$explode[1]."/@".$explode[0];
	$mastodon_special_link = $mastodon_user."_at_".$mastodon_server;

	if(isset($_POST['verify_twitter']))
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
		
		preg_match("(<div class=\"tweet-content media-body\" dir=\"auto\">.+?".$mastodon_special_link.".+?Twittodon.com)is", $site_source_code, $phrase);

		if(!empty($phrase[0]))
		{
			$today = date("Y-m-d");
			$update = "UPDATE connections SET twitter_verified='1', date='".$today."' WHERE twitter_login='".$twitter."' AND mastodon_login='".$mastodon."'";	
			mysqli_query($mysqli, $update) or die('ERROR TD02');
		}
		else
		{
			$nitter_link = "https://nitter.it/".$twitter;
		
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
			
			preg_match("(<div class=\"tweet-content media-body\" dir=\"auto\">.+?".$mastodon_special_link.".+?Twittodon.com)is", $site_source_code, $phrase);
			
			if(!empty($phrase[0]))
			{
				$today = date("Y-m-d");
				$update = "UPDATE connections SET twitter_verified='1', date='".$today."' WHERE twitter_login='".$twitter."' AND mastodon_login='".$mastodon."'";	
				mysqli_query($mysqli, $update) or die('ERROR TD02');
			}
			else
			{
				$twitter_verified_error = true;
			}
		}
	}

	if(isset($_POST['verify_mastodon']))
	{
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
		
		preg_match("(<description>.+?twitter.com\/".$twitter.".+?Twittodon.com)is", $site_source_code, $phrase);

		if(!empty($phrase[0]))
		{
			$update = "UPDATE connections SET mastodon_verified='1' WHERE twitter_login='".$twitter."' AND mastodon_login='".$mastodon."'";
			mysqli_query($mysqli, $update) or die('ERROR TD03');
		}
		else
		{
			$mastodon_verified_error = true;
		}
	}

	$query = "SELECT * FROM connections WHERE twitter_login='".$twitter."' AND mastodon_login='".$mastodon."'";
	$result = mysqli_query($mysqli, $query) or die('ERROR TD04');

	$fromdb = mysqli_fetch_row($result);
	//$fromdb[0] - id
    //$fromdb[1] - twitter_login
    //$fromdb[2] - twitter_verified
    //$fromdb[3] - mastodon_login
    //$fromdb[4] - mastodon_verified
    //$fromdb[5] - twitter_name
    //$fromdb[6] - twitter_img
    //$fromdb[7] - mastodon_name
    //$fromdb[8] - mastodon_img
    //$fromdb[9] - date

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
	<title>Confirm - Twittodon.com - Connect your Twitter and Mastodon accounts and verify it!</title>
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

		label, label_red, label_green, input, textarea, button {
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
		label_red {
		  margin-bottom: 10px;
		  text-align: center;
		  color: #ff0000;
		}
		label_green {
		  margin-bottom: 10px;
		  text-align: center;
		  color: #00ff00;
		}
		
		header {
		  margin-bottom: 10px;
		  text-align: center;
		  color: #ffffff;
		  font-size: 20px;
		  font-weight: bold;
		}

		label:nth-of-type(2) {
		  margin-top: 12px;
		}
		label_red:nth-of-type(2) {
		  margin-top: 12px;
		}
		label_green:nth-of-type(2) {
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
		  height: 50px;
		  text-align: center;
		  border-radius: 25px;
		  box-shadow: inset 5px 5px 5px #000000, inset -5px -5px 5px #666666;
		  -webkit-appearance: none;
		  -webkit-text-fill-color: #ffffff;
		  opacity: 1;
		  resize: none;
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

		<?php
			if(empty($fromdb))
			{
				echo "<header>VERIFICATION PROCESS</header><br>";
				echo "<label_red><img src=\"/img/fail.png\" height=\"15px\" />   Something went wrong!<br>There is no such connection in the database yet. You need to declare account credentials first.<br>Complete previous step first:</label_red><br>";
				echo "<button type=\"button\" onClick=\"location.href='connect.php';\">Take me there</button>";
			}
			elseif($fromdb[2]==1 AND $fromdb[4]==1)
			{
				echo "<header>SUCCESS!</header>";
				echo "<label>&bull;&bull;&bull;&bull;&bull;&bull;&bull;&bull;&bull;&bull;&bull;&bull;&bull;&bull;&bull;&bull;&bull;&bull;&bull;&bull;&bull;&bull;&bull;&bull;&bull;&bull;&bull;&bull;&bull;&bull;</label>";
				echo "<label><h3>These accounts:</h3></label>";
				echo "<label><a href=\"https://twitter.com/".$fromdb[1]."\" target=\"_blank\"><img src=\"/img/twitter_logo-napis-badge_500x2600.png\" height=\"50px\" /><br>".$fromdb[5]." (@".$fromdb[1].")</a></label>";
				echo "<label><font size=\"20px\">+</font></label>";
				echo "<label><a href=\"".$mastodon_link."\" target=\"_blank\"><img src=\"/img/mastodon_logo-napis-badge_500x2600.png\" height=\"50px\" /><br>".$fromdb[7]." (".$fromdb[3].")</a></label>";
				echo "<label><h3>are already verified!</h3></label>";
				echo "<label>&bull;&bull;&bull;&bull;&bull;&bull;&bull;&bull;&bull;&bull;&bull;&bull;&bull;&bull;&bull;&bull;&bull;&bull;&bull;&bull;&bull;&bull;&bull;&bull;&bull;&bull;&bull;&bull;&bull;&bull;</label>";
				echo "<label>The connection of your accounts has been placed in the database,<br>so greater audience can now easily find you!</label>";
				echo "<button type=\"button\" onClick=\"location.href='verified.php'\">Go to database</button>";
				echo "<br><label>&bull;</label>";
				echo "<label>Now you can go to confirmation page and share it with your followers!</label>";
				echo "<button type=\"button\" onClick=\"location.href='https://twittodon.com/share.php?t=".$twitter."&m=".$mastodon."'\">Take me there</button>";
				echo "<br><label>&bull;</label>";
				echo "<label><b>Finally, I have a bonus for you!</b><br>You can copy the link below and put it in your profile on Mastodon (<i>Preferences -> Profile -> Appearance -> Profile metadata section</i>). It will be automatically verified by your instance and will point directly to your Twittodon confirmation page with links to both your profiles and information that connection between them is verified.<br><br><img src=\"/img/twitter_verified_link_on_mastodon.png\" width=\"90%\" /></label>";
				echo "<input type=\"text\" id=\"CopyInput3\" value=\"https://twittodon.com/share.php?t=".$twitter."&m=".$mastodon."\" size=\"20\" disabled>";
				echo "<button type=\"button\" id=\"CopyButton3\" onclick=\"CopyFunction3()\">Copy</button>";
			}
			else
			{
				echo "<header>VERIFICATION PROCESS</header><br>";
				echo "<label>By using link below, you can come back here later and finish this process:</label>";
				echo "<input type=\"text\" id=\"CopyInput0\" value=\"https://twittodon.com/confirm.php?t=".$twitter."&m=".$mastodon."\" size=\"20\" disabled>";
				echo "<button type=\"button\" id=\"CopyButton0\" onclick=\"CopyFunction0()\">Copy</button><br>";
				echo "<label>&bull;&bull;&bull;&bull;&bull;&bull;&bull;&bull;&bull;&bull;&bull;&bull;&bull;&bull;&bull;&bull;&bull;&bull;&bull;&bull;&bull;&bull;&bull;&bull;&bull;&bull;&bull;&bull;&bull;&bull;</label>";
				
				if($fromdb[2]==1)
				{
					echo "<label><h3>Twitter account verification:</h3></label>";
					echo "<label><a href=\"https://twitter.com/".$fromdb[1]."\" target=\"_blank\"><img src=\"/img/twitter_logo-napis-badge_500x2600.png\" height=\"50px\" /><br>".$fromdb[5]." (@".$fromdb[1].")</a></label><br>";
					echo "<label_green>SUCCESS!<br>Your Twitter account has been verified successfully.<br>You may proceed to verify your Mastodon account.</label_green><br>";
				}
				else
				{
					echo "<form action=\"confirm.php?t=".$twitter."&m=".$mastodon."#twitter_step4\" method=\"POST\" name=\"form1\">";
					echo "<label><h3>Twitter account verification:</h3></label>";
					echo "<label><a href=\"https://twitter.com/".$fromdb[1]."\" target=\"_blank\"><img src=\"/img/twitter_logo-napis_500x2000.png\" height=\"50px\" /><br>".$fromdb[5]." (@".$fromdb[1].")</a></label><br>";
					echo "<label><b>Step 1</b><br>Check if this link directs to your Twitter account:<br><a href=\"https://twitter.com/".$twitter."\" target=\"_blank\">https://twitter.com/".$twitter."</a></label>";
					echo "<label><b>Step 2</b><br>To verify that you are a owner of this Twitter account you need to post a tweet with the specified content. You have two options to do that.</label>";
					echo "<label><b>Step 3 - <i>option 1</i></b><br>Button below will direct you to your Twitter account and prepare a proper tweet, the only thing you need to do is to confirm sending tweet (you must be logged into account which you are verifying and your account needs to be public!):</label>";
					echo "<button type=\"button\" onClick=\"window.open('https://twitter.com/share?text=This is my account on Mastodon - ".$mastodon_special_link." - verified by @twittodon_com Twittodon.com', '_blank');\">Prepare tweet</button><br>";
					echo "<label><b>Step 3 - <i>option 2</i></b><br>If above solution doesn't work for you or you don't want to do it that way, you can do it manually by copying the text below and tweeting it on your timeline (your account needs to be public!):</label>";
					echo "<textarea id=\"CopyInput1\" wrap=\"hard\" disabled>This is my account on Mastodon - ".$mastodon_special_link." - verified by @twittodon_com Twittodon.com</textarea>";
					echo "<button type=\"button\" id=\"CopyButton1\" onclick=\"CopyFunction1()\">Copy</button><br>";
					echo "<label id=\"twitter_step4\"><b>Step 4</b><br>After posting a tweet confirm using button below to perform verification:</label>";
					echo "<button type=\"submit\" id=\"verify_twitter\" name=\"verify_twitter\">Verify</button><br>";
					if($twitter_verified_error==true)
					{
						echo "<label_red><img src=\"/img/fail.png\" height=\"15px\" />   SOMETHING WENT WRONG!<br>Check if you did all steps correctly and try again. If further failures occur, report the problem using <a href=\"bug_report.php?t=".$twitter."&m=".$mastodon."\" target=\"_blank\">this form</a>.</label_red>";
					}
					echo "</form>";
				}

				echo "<br><label>&bull;&bull;&bull;&bull;&bull;&bull;&bull;&bull;&bull;&bull;&bull;&bull;&bull;&bull;&bull;&bull;&bull;&bull;&bull;&bull;&bull;&bull;&bull;&bull;&bull;&bull;&bull;&bull;&bull;&bull;</label>";

				if($fromdb[4]==1)
				{
					echo "<label><h3>Mastodon account verification:</h3></label>";
					echo "<label><a href=\"".$mastodon_link."\" target=\"_blank\"><img src=\"/img/mastodon_logo-napis-badge_500x2600.png\" height=\"50px\" /><br>".$fromdb[7]." (".$fromdb[3].")</a></label><br>";
					echo "<label_green>SUCCESS!<br>Your Mastodon account has been verified successfully.</br>You may proceed to verify your Twitter account.</label_green>";
				}
				else
				{
					echo "<form action=\"confirm.php?t=".$twitter."&m=".$mastodon."#mastodon_step4\" method=\"POST\" name=\"form2\">";
					echo "<label><h3>Mastodon account verification:</h3></label>";
					echo "<label><a href=\"".$mastodon_link."\" target=\"_blank\"><img src=\"/img/mastodon_logo-napis_500x2000.png\" height=\"50px\" /><br>".$fromdb[7]." (".$fromdb[3].")</a></label><br>";
					echo "<label><b>Step 1</b><br>Check if this link directs to your Mastodon account:<br><a href=\"".$mastodon_link."\" target=\"_blank\">".$mastodon_link."</a></label>";
					echo "<label><b>Step 2</b><br>To verify that you are a owner of this Mastodon account you need to post a toot with the specified content. You have two options to do that.</label>";
					echo "<label><b>Step 3 - <i>option 1</i></b><br>Button below will direct you to your Mastodon account and prepare a proper toot, the only thing you need to do is to confirm sending toot (you must be logged into account which you are verifying and your account needs to be public!):</label>";
					echo "<button type=\"button\" onClick=\"window.open('https://".$mastodon_server."/publish?text=This is my account on Twitter - https://twitter.com\/".$twitter." - verified by https://Twittodon.com', '_blank');\">Prepare toot</button><br>";
					echo "<label><b>Step 3 - <i>option 2</i></b><br>If above solution doesn't work for you or you don't want to do it that way, you can do it manually by copying the text below and posting it on your timeline (your account needs to be public!):</label>";
					echo "<textarea id=\"CopyInput2\" wrap=\"hard\" disabled>This is my account on Twitter - twitter.com/".$twitter." - verified by https://Twittodon.com</textarea>";
					echo "<button type=\"button\" id=\"CopyButton2\" onclick=\"CopyFunction2()\">Copy</button><br>";
					echo "<label id=\"mastodon_step4\"><b>Step 4</b><br>After posting a toot confirm using button below to perform verification:</label>";
					echo "<button type=\"submit\" id=\"verify_mastodon\" name=\"verify_mastodon\">Verify</button><br>";
					if($mastodon_verified_error==true)
					{
						echo "<label_red><img src=\"/img/fail.png\" height=\"15px\" />   SOMETHING WENT WRONG!<br>Check if you did all steps correctly and try again. If further failures occur, report the problem using <a href=\"bug_report.php?t=".$twitter."&m=".$mastodon."\" target=\"_blank\">this form</a>.</label_red>";
					}
					echo "</form>";
				}
			}
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
	</div>
	<script>
		function CopyFunction0() {
		// Get the text field
		var copyText = document.getElementById("CopyInput0");

		// Select the text field
		copyText.select();
		copyText.setSelectionRange(0, 99999); // For mobile devices

		// Copy the text inside the text field
		navigator.clipboard.writeText(copyText.value);
		
		// Alert the copied text
		//alert("Copied!");
		var btn = document.getElementById("CopyButton0");
		btn.innerHTML = "Copied!";
		}
	</script>
	<script>
		function CopyFunction1() {
		// Get the text field
		var copyText = document.getElementById("CopyInput1");

		// Select the text field
		copyText.select();
		copyText.setSelectionRange(0, 99999); // For mobile devices

		// Copy the text inside the text field
		navigator.clipboard.writeText(copyText.value);
		
		// Alert the copied text
		//alert("Copied!");
		var btn = document.getElementById("CopyButton1");
		btn.innerHTML = "Copied!";
		}
	</script>
	<script>
		function CopyFunction2() {
		// Get the text field
		var copyText = document.getElementById("CopyInput2");

		// Select the text field
		copyText.select();
		copyText.setSelectionRange(0, 99999); // For mobile devices

		// Copy the text inside the text field
		navigator.clipboard.writeText(copyText.value);
		
		// Alert the copied text
		//alert("Copied!");
		var btn = document.getElementById("CopyButton2");
		btn.innerHTML = "Copied!";
		}
	</script>
	<script>
		function CopyFunction3() {
		// Get the text field
		var copyText = document.getElementById("CopyInput3");

		// Select the text field
		copyText.select();
		copyText.setSelectionRange(0, 99999); // For mobile devices

		// Copy the text inside the text field
		navigator.clipboard.writeText(copyText.value);
		
		// Alert the copied text
		//alert("Copied!");
		var btn = document.getElementById("CopyButton3");
		btn.innerHTML = "Copied!";
		}
	</script>
</body>

</html>
