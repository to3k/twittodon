<?php
    header('Content-Type: text/html; charset=utf-8');
	require("/*mysql config file*/");
	$mysqli = mysqli_connect($host, $user, $pass, $nazwa_bazy) or die('ERROR TD01');
	mysqli_set_charset($mysqli, "utf8mb4");

	$query = "SELECT * FROM connections WHERE twitter_verified='1' AND mastodon_verified='1'";
	$result = mysqli_query($mysqli, $query) or die('ERROR TD02');

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
	<meta name="viewport" content="width=device-width, initial-scale=0.5">
	<title>Verified - Twittodon.com - Connect your Twitter and Mastodon accounts and verify it!</title>
	<link rel="icon" href="favicon.ico" type="image/x-icon"/>
	<link rel="shortcut icon" href="favicon.ico" type="image/x-icon"/>
    <link rel="stylesheet" type="text/css" href="/dist/jstable.css">
    <script type="text/javascript" src="/dist/jstable.min.js"></script>
    <script type="text/javascript" src="/dist/jstable.es5.min.js"></script>
    <script type="text/javascript" src="/dist/polyfill-fetch.min.js"></script>
	
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
		  width: 900px;
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
		  color: #0ffff0;
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
		  height: 25px;
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

		highlight_blue {
			color: #1DA1F2;
		}
		highlight_purple {
			color: #6364ff;
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
		<header>VERIFIED LIST</header>
		<label>&bull;&bull;&bull;&bull;&bull;&bull;&bull;&bull;&bull;&bull;&bull;&bull;&bull;&bull;&bull;&bull;&bull;&bull;&bull;&bull;&bull;&bull;&bull;&bull;&bull;&bull;&bull;&bull;&bull;&bull;</label>
		<br>
        <table id="verified_table">
            <thead>
                <tr>
                <th width="40%"><highlight_blue>Twitter</highlight_blue></th>
                <th width="40%"><highlight_purple>Mastodon</highlight_purple></th>
                <th width="20%" data-sort="desc">Added</th>
                </tr>
            </thead>
            <tbody>
            <?php
                $export_arr = array();
		while($fromdb = mysqli_fetch_row($result))
                {
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
                    echo "<tr>";
                    echo "<td style=\"white-space: normal\"><a href=\"https://twitter.com/".$fromdb[1]."\" target=\"_blank\">@".$fromdb[1]."</a><br>".$fromdb[5]."</td>";
                    $explode = explode("@", $fromdb[3]);
                    $mastodon_user = $explode[0];
                    $mastodon_server = $explode[1];
                    $mastodon_link = "https://".$explode[1]."/@".$explode[0];
                    echo "<td style=\"white-space: normal\"><a href=\"".$mastodon_link."\" target=\"_blank\">".$fromdb[3]."</a><br>".$fromdb[7]."</highlight_purple></td>";
                    echo "<td style=\"white-space: nowrap\">".$fromdb[9]."</td>";
                    echo "</tr>";
		    $export_arr[] = array($fromdb[1],$fromdb[3],$fromdb[9]);
                }
		$serialize_export_arr = serialize($export_arr);
            ?>
            </tbody>
        </table>
	    <br>
            <form method="post" action="download.php">
                <textarea name="export_data" style="display: none;"><?php echo $serialize_export_arr; ?></textarea>
                <button type="submit" name="Export">Download entire table as a CSV file</button>
            </form>
            <br>
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
        new JSTable("#verified_table", {
            perPage: 10,
            perPageSelect: [10, 50, 100, 500, 1000, 5000, 10000],
            nextPrev: true,
            firstLast: false,
            prevText: "&lsaquo;",
            nextText: "&rsaquo;",
            firstText: "&laquo;",
            lastText: "&raquo;",
            ellipsisText: "&hellip;",
            truncatePager: true,
            pagerDelta: 2,
            searchable: true,
            sortable: true,
            labels: 
            {
                placeholder: "Search...",
                perPage: "{select} entries per page",
                noRows: "No entries found",
                info: "From {start} to {end} of {rows} entries",
                loading: "Loading...",
                infoFiltered: "From {start} to {end} of {rows} entries<br>(filtered from {rowsTotal} entries)"
            },
            layout: 
            {
                top: "{select}{search}",
                bottom: "{info}{pager}"
            }
        });
	</script>
</body>

</html>
