<?php
header('Content-Type: text/html; charset=utf-8');

//Change language
$full_url = "https://pl.twittodon.com" . $_SERVER['REQUEST_URI'];
?>


<!DOCTYPE html>
<html lang="en">

<head>
	<meta http-equiv="content-type" content="text/html; charset=utf-8">
	<meta name="Author" content="Tomasz Dunia">
	<meta name="Description" content="Twittodon.com - Connect your Twitter and Mastodon accounts and verify it to let you followers be sure that those are your official accounts!" />
	<meta name="Keywords" content="twitter, mastodon, fediverse, connect, verify" />
	<meta name="viewport" content="width=device-width, initial-scale=0.7">
	<title>Privacy policy - Twittodon.com - Connect your Twitter and Mastodon accounts and verify it!</title>
	<link rel="icon" href="favicon.ico" type="image/x-icon" />
	<link rel="shortcut icon" href="favicon.ico" type="image/x-icon" />

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

		label,
		button {
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

		privacy {
			display: inline-block;
			width: 100%;
			padding: 0;
			border: none;
			outline: none;
			box-sizing: border-box;
		}

		privacy {
			margin-bottom: 10px;
			text-align: left;
			color: #ffffff;
		}

		privacy:nth-of-type(2) {
			margin-top: 12px;
		}

		header {
			margin-bottom: 10px;
			text-align: center;
			color: #ffffff;
			font-size: 20px;
			font-weight: bold;
		}

		button {
			font-family: Verdana;
			color: #ffffff;
			/*text-shadow: 0 0 0.5em #000000, 0 0 0.5em #000000, 0 0 0.5em #000000;*/
			font-weight: bold;
			font-size: 25px;
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

		a,
		a:hover,
		a:active,
		a:visited {
			color: white;
		}

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

		.patreon {
			font-family: Verdana;
			font-size: 12px;
			color: #ffffff;
			height: 45px;
			width: 160px;
			margin: auto;
			border-radius: 15px;
			box-sizing: border-box;
			box-shadow: 7px 7px 10px #000000, -7px -7px 10px #666666;
			cursor: pointer;
			transition: 0.5s;
			background-color: #ff424d;
			position: absolute;
			bottom: 15px;
			right: 15px;
			display: inline-block;
			vertical-align: middle;
		}
	</style>
</head>

<body>
	<br /><br />
	<div class="container">
		<button type="button" class="lang plflag" onClick="location.href='<?php echo "$full_url"; ?>';"></button>
		<center><a href="/"><img src="/img/twittodon_logo-napis_white-blue-purple.png" alt="LOGO" width="80%" /></a>
			<br><br><br>
			<header>Friendly Privacy Policy</header>
			<label>&bull;&bull;&bull;&bull;&bull;&bull;&bull;&bull;&bull;&bull;&bull;&bull;&bull;&bull;&bull;&bull;&bull;&bull;&bull;&bull;&bull;&bull;&bull;&bull;&bull;&bull;&bull;&bull;&bull;&bull;</label>
			<br><br>

			<privacy>
				<center>
					<h3>WHO</h3>
				</center>
				The administrator of the personal data collected through the website is:<br>
				Tomasz Dunia<br>
				Mailing address: Fryderyka Chopina 19/4, 20-023 Lublin, Poland<br>
				E-mail address: contact[at]twittodon.com<br>
				<center>
					<h3>WHAT</h3>
				</center>
				The administrator processes the following categories of user's personal data:<br>
				A. publicly available data of Twitter account provided by the user<br>
				B. publicly available data of Mastodon account provided by the user<br>
				C. first name and/or last name and/or nickname<br>
				D. e-mail address<br>
				E. IP address<br>
				<center>
					<h3>WHY</h3>
				</center>
				The administrator processes personal data through the site in case of:<br>
				1. the user initiates the process of verifying the connection between his/her Twitter and Mastodon accounts (categories A and B of personal data),<br>
				2. the user's initiation of contact with the administrator through the contact forms available on the site (categories C, D and E of personal data),<br>
				following the user's consent expressed by a clear affirmative action (Article 6(1)(a) of <a href="https://eur-lex.europa.eu/legal-content/EN/TXT/HTML/?uri=CELEX%3A32016R0679">GDPR</a>).<br>
				Personal data are processed until the user withdraws his consent to their processing.<br>
				The Administrator shall exercise special care to protect the interests of data subjects, and in particular shall ensure that the data it collects are:<br>
				1. processed in accordance with the law,<br>
				2. collected for designated legitimate purposes and not subjected to further processing incompatible with those purposes,<br>
				3. substantively correct and adequate in relation to the purposes for which they are processed, and stored in a form that makes it possible to identify the persons to whom they relate for no longer than is necessary to achieve the purpose of processing.<br>
				4. not used for automated decision-making or profiling.<br>
				<center>
					<h3>TO WHOM</h3>
				</center>
				Personal data categories A and B are published on the site in the form of an open database, which is publicly available and downloadable by any visitor of the site. Personal data processed on this site is not shared in any other form, especially with third parties (except strictly necessary, e.g. hosting providers).<br>
				<center>
					<h3>CONTROL</h3>
				</center>
				User may request at any time:<br>
				1. access to the content of his/her personal data,<br>
				2. rectification of the content of his personal data,<br>
				3. deletion and, consequently, cessation of further processing of his/her personal data.<br>
				4. data portability. <br>
				The above requests should be submitted through the indicated contact details of the administrator.<br>
				In addition, if you consider that the processing of your personal data violates the provisions of the RODO, you have the right to lodge a complaint with the supervisory authority.
			</privacy>

			<br><br><br>
			<label>
				<center>
					<table style="font-size: 12px;">
						<tr>
							<td style="text-align: center; padding-right: 15px; border-right: solid 1px white;">
							<a href="https://tomaszdunia.pl" target="_blank"><img src="/img/author.gif" style="border-radius: 50%; height: 93px;" /></a><br>
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
								<img src="/img/stats_icon.png" height="10px" /> <a href="stats.php" target="_blank">You have an access to it's statistics!</a><br>
                            	<img src="/img/github_icon.png" height="10px" /> <a href="https://github.com/to3k/twittodon" target="_blank">It's code is open and available on GitHub.</a>
							</td>
						</tr>
					</table>
				</center>
			</label>
      </center>
		<br><br>
		<button type="button" class="patreon" onClick="window.open('https://www.patreon.com/bePatron?u=67755731',
  '_blank');">Donate on <img src="/img/patreon_600x100.png" height="20px" /></button>
	</div>
</body>

</html>