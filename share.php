<?php
    header('Content-Type: text/html; charset=utf-8');
	require("/*mysql config file*/");
	$mysqli = mysqli_connect($host, $user, $pass, $nazwa_bazy) or die('ERROR TD01');
	mysqli_set_charset($mysqli, "utf8mb4");

	$twitter = addslashes(strip_tags($_GET['t']));
	$mastodon = addslashes(strip_tags($_GET['m']));

    if(empty($twitter) OR empty($mastodon))
    {
        header("Location: https://twittodon.com");
    }
    else
    {
        $query = "SELECT * FROM connections WHERE twitter_login='".$twitter."' AND mastodon_login='".$mastodon."' AND twitter_verified='1' AND mastodon_verified='1'";
        $result = mysqli_query($mysqli, $query) or die('ERROR TD02');

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
        
        if(!empty($fromdb))
        {
            $explode = explode("@", $fromdb[3]);
			$mastodon_user = $explode[0];
			$mastodon_server = $explode[1];
			$mastodon_link = "https://".$explode[1]."/@".$explode[0];
        }
        else
        {
            header("Location: confirm.php");
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
	<title>Shared confirmation - Twittodon.com - Connect your Twitter and Mastodon accounts and verify it!</title>
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
		  color: #ffffff;
		  /*text-shadow: 0 0 0.5em #000000, 0 0 0.5em #000000, 0 0 0.5em #000000;*/
		  font-weight: bold; 
		  font-size:25px;
		  margin: 20px 20px;
		  background: none;
		  width: 290px;
		  height: 200px;
		  border-radius: 20px;
		  cursor: pointer;
		  box-shadow: 5px 5px 5px #000000, -5px -5px 5px #666666;
		  transition: 0.5s;
		}

		button:hover {
		  box-shadow: none;
		}
		
		a, a:hover, a:active, a:visited { color: white; }

        .verified {
			background: url("/img/twittodon_verified-badge.png");
			background-size: contain;
			background-repeat: no-repeat;
			background-position: center;
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
        <center><a href="https://twittodon.com"><img src="/img/twittodon_logo-napis_white-blue-purple.png" alt="LOGO" width="80%" /></a></center>
		<br>
		<div class="inputs">

		<?php
			if(!empty($fromdb))
            {
                echo "<header>HELLO!</header>";
				echo "<label>&bull;&bull;&bull;&bull;&bull;&bull;&bull;&bull;&bull;&bull;&bull;&bull;&bull;&bull;&bull;&bull;&bull;&bull;&bull;&bull;&bull;&bull;&bull;&bull;&bull;&bull;&bull;&bull;&bull;&bull;</label>";
				echo "<label><h3>These accounts:</h3></label>";
				echo "<label><a href=\"https://twitter.com/".$fromdb[1]."\"><img src=\"/img/twitter_logo-napis-badge_500x2600.png\" height=\"50px\" /><br>".$fromdb[5]." (@".$fromdb[1].")</a></label>";
				echo "<label><font size=\"20px\">+</font></label>";
				echo "<label><a rel=\"me\" href=\"".$mastodon_link."\"><img src=\"/img/mastodon_logo-napis-badge_500x2600.png\" height=\"50px\" /><br>".$fromdb[7]." (".$fromdb[3].")</a></label>";
				echo "<label><h3>are officially verified and owned by the same person!</h3></label>";
				echo "<label>&bull;&bull;&bull;&bull;&bull;&bull;&bull;&bull;&bull;&bull;&bull;&bull;&bull;&bull;&bull;&bull;&bull;&bull;&bull;&bull;&bull;&bull;&bull;&bull;&bull;&bull;&bull;&bull;&bull;&bull;</label>";
				echo "<label>Visit our database if you are looking for more verified connections like this!</label>";
                echo "<center><button class=\"button verified\" onclick=\"window.open(this.href='verified.php','_self')\">VERIFIED<br><br><br><br><br>DATABASE</button></center>";
            }
            else
            {
                echo "<header>VERIFICATION PROCESS</header><br>";
				echo "<label>Something went wrong!</label>";
				echo "<label>There is no such connection in the database yet. You need to declare account credentials first.</label>";
				echo "<label>Start verification process:</label>";
				echo "<button type=\"button\" onClick=\"location.href='connect.php';\">Take me there</button>";
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