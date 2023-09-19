<?php
    header('Content-Type: text/html; charset=utf-8');
	
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
	<title>Twittodon.com - Connect your Twitter and Mastodon accounts and verify it!</title>
	<link rel="icon" href="favicon.ico" type="image/x-icon"/>
	<link rel="shortcut icon" href="favicon.ico" type="image/x-icon"/>
	
	<style type="text/css">
		body {
		  font-family: Verdana;
		  font-size: 14px;
		  margin: 40px;
		  background: #333333;
		  display: flex;
		  align-items: center;
		  text-align: justify;
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
		
		label, button {
		  display: inline;
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
		
		button {
		  font-family: Verdana;
		  color: #ffffff;
		  /*text-shadow: 0 0 0.5em #000000, 0 0 0.5em #000000, 0 0 0.5em #000000;*/
		  font-weight: bold; 
		  font-size:22px;
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
		
		.disabled {
			opacity: 0.6;
			cursor: not-allowed;
		}

		.connect {
			background: url("/img/twittodon_twitter-plus-mastodon_white_transparent.png");
			background-size: contain;
			background-repeat: no-repeat;
			background-position: center;
		}

		.verified {
			background: url("/img/twittodon_verified-badge.png");
			background-size: contain;
			background-repeat: no-repeat;
			background-position: center;
		}

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
		<center><a href="https://twittodon.com"><img src="/img/twittodon_logo-napis_white-blue-purple.png" alt="LOGO" width="80%" /></a></center>
		<br>
		<label>
		<center><h2>What is <highlight_blue>Twitt</highlight_blue><highlight_purple>odon</highlight_purple>.com?</h2>
		&bull;&bull;&bull;&bull;&bull;&bull;&bull;&bull;&bull;&bull;&bull;&bull;&bull;&bull;&bull;&bull;&bull;&bull;&bull;&bull;&bull;&bull;&bull;&bull;&bull;&bull;&bull;&bull;&bull;&bull;<br><br>
		<highlight_blue>Tool to verify connection between your Twitter and Mastodon accounts.<br>Let your followers find you.</highlight_blue><br>
		&bull;&bull;&bull;<br>
		<highlight_purple>Main goal is to create a great database of Twitter-Mastodon verified connections.<br>To find people you know from one platform and follow them on the other.</highlight_purple><br>
		&bull;&bull;&bull;<br>
		<highlight_blue>Helps you with recreating your network of contacts.</highlight_blue><br>
		&bull;&bull;&bull;<br>
		<highlight_purple>Counteracts the existence of fake accounts and impersonators.</highlight_purple><br>
		&bull;&bull;&bull;<br>
		<highlight_blue>Secure and transparent solution.<br>Unlike other solutions, similar to this, there is no need to provide credentials to your accounts or give access for third-party apps.</highlight_blue><br>
		&bull;&bull;&bull;<br>
		<highlight_purple>Database holds only the basic information necessary for this tool to function properly.</highlight_purple><br>
		&bull;&bull;&bull;<br>
		<highlight_blue>Completely free tool created to serve the society.</highlight_blue><br>
		<br>
		</center>
		</label>
		<center>
		<button class="button connect" onclick="window.open(this.href='connect.php','_self')">CONNECT<br><br><br><br><br>ACCOUNTS</button>
		<button class="button verified" onclick="window.open(this.href='verified.php','_self')">VERIFIED<br><br><br><br><br>DATABASE</button>
		</center>
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
                            <img src="/img/stats_icon.png" height="10px" /> <a href="stats.php">You have an access to its statistics!</a><br>
                        </td>
                    </tr>
                </table>
			</center>
		</label>
	</div>
</body>

</html>
