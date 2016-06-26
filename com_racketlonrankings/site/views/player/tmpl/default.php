<?php
/**
 * @package     Joomla.Administrator
 * @subpackage  com_racketlonrankings
 *
 * @copyright   Copyright (C) 2005 - 2016 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */
 
// No direct access to this file
defined('_JEXEC') or die('Restricted access');
?>

<?php if ($this->updating) : ?>
	<p> Apologies, the ratings are currently being updated. This normally only takes 5 minutes so please check again soon. If the problem persists please get in touch with the webmaster via the <a href="http://www.racketlon.co.uk/index.php/contact-us">Contact us</a> page.</p>
<?php else: ?>
		
	<!-- PHP scripts -->
	<?php
		$player = $this->params["player"];
		$tournaments = $this->params["tournaments"];
		$updateDate = $this->params["updateDate"];

		$ratingsOverTime = array(
			'names' => array(),
			'dates' => array(),
			'all' => array(),
			'tt' => array(),
			'bd' => array(),
			'sq' => array(),
			'tn' => array()
		);

		foreach($tournaments as $name => $t)
		{
			$ratingsOverTime['names'][] = $name;
			$ratingsOverTime['dates'][] = $t['startDate'];
			$ratingsOverTime['all'][] = $t['finalRating'];
			$ratingsOverTime['tt'][] = $t['finalRatingtt'];
			$ratingsOverTime['bd'][] = $t['finalRatingbd'];
			$ratingsOverTime['sq'][] = $t['finalRatingsq'];
			$ratingsOverTime['tn'][] = $t['finalRatingtn'];
		}
		$js_ratingsOverTime = json_encode($ratingsOverTime);	
		$js_players = json_encode($this->players);

		function displayGameResult($v1 , $v2)
		{
			if($v1 == 0 && $v2 == 0)
			{
				echo "N/A";
			}
			else
			{
				echo $v1 . "-" . $v2;
			}
		}

		function generateDates($begin, $end) {
			$begin = new DateTime($begin);
			$end = (new DateTime($end))->modify('+1 day');

			$interval = new DateInterval('P1D');
			$daterange = new DatePeriod($begin, $interval ,$end);

			$result  = '';
			foreach($daterange as $date) {
				$result .= '<div class="rem-date">';
				$result .= 	'<span class="rem-day">' . $date->format("d") . '</span>';
				$result .= 	'<span class="rem-month">' . $date->format("M") . '</span>';
				$result .= '</div>';
			}

			return $result;
		}
	?>

	<!-- Javascript -->

	<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
	<link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">

	<h1>
		Search
	</h1>

	<div id="player-search" class="ui-widget">
	  <input type="text" name="searchword" id="player-search-box" class="bd-bootstrapinput-9 form-control" placeholder="Name">
	  <a href="#" id="player-search-icon" class=" bd-icon-30" link-disable="true"></a>
	</div>

	<p id="player-search-error" class="collapse"> </p>

	<?php if($this->id >= -1) : ?>
		<?php if($this->id == -1 || is_null($player)) : ?>
			<p> No players found </p>
		<?php else : ?>
			<h1>
				<?php echo $player["name"] ?>
			</h1>

			<!-- Tags -->

			<div id="player-tags">
				<?php if ($player["active"]) : ?>
					<div class="badge active">
						Active
					</div>
				<?php else : ?>
					<div class="badge inactive">
						Inactive
					</div>
				<?php endif ?>

				<?php if ($player["gender"]) : ?>
					<div class="badge female">
						Female
					</div>
				<?php else : ?>
					<div class="badge male">
						Male
					</div>
				<?php endif ?>

				<div class="badge country">
					<?php echo $player["country"] ?>
				</div>

				<?php if ($player["ageCategory"]) : ?>
					<div class="badge">
						<?php echo $player["ageCategory"] ?>
					</div>
				<?php endif ?>

				<!--
				-->
			</div>

			<!-- Overall ratings -->
			<div class="rating-section">
				<h2>
					Overall rating: <?php echo ("<b>" . $player['class'] . "</b> (" . $player['rating'] . ")") ?>
				</h2>
				<div id="all-rating-container">
					<div id="all-rating-graph"></div>
				</div>
			</div>

			<!-- Sport ratings -->
			<div class="rating-section">
				<h2>
					Sports ratings
				</h2>
				<div id="sports-ratings-container">
					<div class="sport-container">
						Table tennis: <?php echo ("<b>" . $player['classtt'] . "</b> (" . $player['ratingtt'] . ")") ?>

						<div class="rating-graph" id="tt-rating-graph"></div>
					</div>

					<div class="sport-container">
						Badminton: <?php echo ("<b>" . $player['classbd'] . "</b> (" . $player['ratingbd'] . ")") ?>

						<div class="rating-graph" id="bd-rating-graph"></div>
					</div>

					<div class="sport-container">
						Squash: <?php echo ("<b>" . $player['classsq'] . "</b> (" . $player['ratingsq'] . ")") ?>
						<div class="rating-graph" id="sq-rating-graph"></div>
					</div>

					<div class="sport-container">
						Tennis: <?php echo ("<b>" . $player['classtn'] . "</b> (" . $player['ratingtn'] . ")") ?>
						<div class="rating-graph" id="tn-rating-graph"></div>
					</div>
				</div>
			</div>

			<!-- Tournaments -->
			<div class="rating-section">
				<h2>
					Tournaments
				</h2>
				<?php foreach(array_reverse($tournaments) as $name => $t) : ?>
					<div class="tournament-results-container">
						<h3>
							<?php echo $name; ?>
						</h3>
						
						<table class="tournament-table">

							<thead>
								<tr>
									<th class="padding-col"></th>
									<th class="op-col" data-type="html">Opponent</th>
									<th class="result-col" > Result</th>
									<th class="rat-col" 	data-breakpoints="xss xs">Rating</th>
									<th class="op-rat-col" 	data-breakpoints="xss xs">Op. rating</th>
									<th class="rat-chg-col" data-breakpoints="xss xs s">Rating \(\delta\)</th> 
									<th class="total-col" 	data-breakpoints="xss">Total</th>
									<th class="tt-col" 		data-breakpoints="xss xs s m">TT</th>
									<th class="bd-col" 		data-breakpoints="xss xs s m">Bd</th>
									<th class="sq-col" 		data-breakpoints="xss xs s m">Sq</th>
									<th class="tn-col" 		data-breakpoints="xss xs s m">Tn</th>
								</tr>
							</thead>

							<tbody>
								<?php foreach($t['matches'] as $m) : ?>
									<tr>
										<td></td>
										<td>
											<a href="http://www.racketlon.co.uk/index.php/rankings/search?option=com_racketlonrankings&player_id=<?php echo $m['p2id'] ?>">
												<?php echo $m['p2name'] ?>
											</a>
										</td>
										<td>
											<?php echo ($m['tot1'] > $m['tot2'] ?  "Won" : "Lost") ?>
										</td>
										<td>
											<?php echo $m['p1rating'] ?>
										</td>
										<td>
											<?php echo $m['p2rating'] ?>
										</td>
										<td>
											<?php echo (($m['p1ratingchg'] > 0 ? "+" : "") . $m['p1ratingchg']) ?>
										</td>
										<td>
											<?php echo displayGameResult($m['tot1'], $m['tot2']) ?>
										</td>
										<td>
											<?php echo displayGameResult($m['tt1'], $m['tt2']) ?>
										</td>
										<td>
											<?php echo displayGameResult($m['bd1'], $m['bd2']) ?>
										</td>
										<td>
											<?php echo displayGameResult($m['sq1'], $m['sq2']) ?>
										</td>
										<td>
											<?php echo displayGameResult($m['tn1'], $m['tn2']) ?>
										</td>
									</tr>
								<?php endforeach ?>
							</tbody>
						</table>
					</div>
				<?php endforeach ?>
			</div>

			<!-- Tables  -->

			<script type="text/javascript" src="/templates/uk_racketlon/js/footable.min.js"></script>
			<link rel="stylesheet" type="text/css" href="/templates/uk_racketlon/css/footable.bootstrap.min.css">

			<script>
				jQuery(".tournament-table").footable({
					"breakpoints": {
						"xss": 320,
						"xs": 480,
						"s": 768,
						"m": 992,
						"l": 1200,
						"xl": 1400
					}
				});

				jQuery(document).on('DOMNodeInserted', '.footable-details', function () {
				    MathJax.Hub.Queue(["Typeset", MathJax.Hub, ".footable-details"]);
				});
			</script>

			<!-- Charts -->


			<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
			<script type="text/javascript" src="/templates/uk_racketlon/js/heartcode-canvasloader.min.js"></script>

			<script type="text/javascript">

				google.charts.load('current', {'packages':['corechart']});

				// When to redraw the charts
				google.charts.setOnLoadCallback(drawAll);

				var firstTime = true;
				jQuery(window).resize(function() {
			    	if(this.resizeTO) {
			    		clearTimeout(this.resizeTO);
			    	}
				    this.resizeTO = setTimeout(function() {
				        jQuery(this).trigger('resizeEnd');
				    }, 500);
				});
				jQuery(window).on('resizeEnd', drawAll);

				// Loading animations
				function setupLoaderAnimation(element)
				{
					var cl = new CanvasLoader(element);
					cl.setDiameter(93); // default is 40
					cl.setDensity(20); // default is 40
					cl.setRange(0.7); // default is 1.3
					cl.setSpeed(1); // default is 2
					cl.setFPS(25); // default is 24
					cl.show(); // Hidden by default
				}

				setupLoaderAnimation('all-rating-graph');
				setupLoaderAnimation('tt-rating-graph');
				setupLoaderAnimation('bd-rating-graph');
				setupLoaderAnimation('sq-rating-graph');
				setupLoaderAnimation('tn-rating-graph');
				

				// Some useful functions
				Array.prototype.max = function() {
					return Math.max.apply(null, this);
				};

				Array.prototype.min = function() {
					return Math.min.apply(null, this);
				};

				function notNull(x)
				{
					return x !== null;
				}

				function removeNulls(xs)
				{	
					return xs.filter(notNull);
				}

				function calculateClass(rating)
				{
					var number = Math.ceil((2000 - (rating % 2000))/500);

					if(rating < 10000) return "??";
					if(rating < 12000) return "D" + number;
					if(rating < 14000) return "C" + number;
					if(rating < 16000) return "B" + number;
					if(rating < 18000) return "A" + number;
					if(rating < 20000) return number + "+";
					return '0+';
				}

				

				// Calculating data bounds
				var data = <?php echo $js_ratingsOverTime ?>;

				var maxR = Math.max(
					removeNulls(data['all']).max(),
					removeNulls(data['tt']).max(),
					removeNulls(data['bd']).max(),
					removeNulls(data['sq']).max(),
					removeNulls(data['tn']).max()
				);
				var minR = Math.min(
					removeNulls(data['all']).min(),
					removeNulls(data['tt']).min(),
					removeNulls(data['bd']).min(),
					removeNulls(data['sq']).min(),
					removeNulls(data['tn']).min()
				);
				var maxR = (Math.ceil(maxR/500) + 1)*500;
				var minR = (Math.floor(minR/500) - 1)*500;

				var yticks = [];
				for(var i = minR; i <= maxR; i+=500)
				{
					yticks.push({v:i, f:calculateClass(i)});
				}


				var minD = new Date(new Date(data['dates'][0]).getFullYear(), 0, 1)
				var maxD = new Date(new Date(data['dates'][data['dates'].length-1]).getFullYear() + 1, 0, 1)

				var xticks = [];
				var d = new Date(minD);
				while(d <= maxD)
				{
					xticks.push(new Date(d));
					d.setFullYear(d.getFullYear() + 1);
				}



				// Draw the graphs

				function drawAll()
				{
					drawChart(data['dates'], data['all'], data['names'], jQuery('#all-rating-graph')[0], '#e2431e');
					drawChart(data['dates'], data['tt'],  data['names'], jQuery('#tt-rating-graph')[0],  '#e7711b');
					drawChart(data['dates'], data['bd'],  data['names'], jQuery('#bd-rating-graph')[0],  '#f1ca3a');
					drawChart(data['dates'], data['sq'],  data['names'], jQuery('#sq-rating-graph')[0],  '#1c91c0');
					drawChart(data['dates'], data['tn'],  data['names'], jQuery('#tn-rating-graph')[0],  '#43459d');

					firstTime = false;
				}

				function drawChart(xs, ys, ts, element, colour) {

					var dataTable = new google.visualization.DataTable();
					dataTable.addColumn('date', 'Date');
					dataTable.addColumn('number', 'Rating');
					dataTable.addColumn({type: 'string', role: 'tooltip'});
					dataTable.addColumn({type: 'string', role: 'style'});


					var pointSize = jQuery(window).width() > 480 ? 10 : 7;

					for(var i = 0; i < xs.length; i++)
					{
						dataTable.addRow([
							new Date(xs[i]), 
							ys[i], 
							ts[i] + " (" + ys[i] + ")",
							(i == xs.length - 1) ? 'point { size: ' + pointSize + ' ; stroke-color: #000000 }' : null
						]);
					}


			        var options = {
			          	curveType: 'function',
			          	fontSize: 16,
			          	fontName: 'Arial',
			          	pointShape: 'circle',
			          	pointSize: pointSize,
			          	animation: {
			          		duration: 500,
			          		startup: firstTime,
			          		easing: 'out'
			          	},
			          	hAxis: {
			          		format: 'y',
			          		viewWindowMode: 'maximized',
			          		ticks: xticks,
			          		maxValue : maxD
			          	},
			          	vAxis: {
			          		viewWindowMode: 'maximized',
			          		ticks: yticks
			          	},
			          	chartArea: {
			          		left: 40,
			          		width: element.offsetWidth - 65,
			          		top: 10,
			          		height: element.offsetHeight - 40
			          	},
			          	series: {
				            0: {
				            	visibleInLegend: false,
				            	color: colour 
				            },
				        }
			        };

			        var chart = new google.visualization.LineChart(element);

			        chart.draw(dataTable, options);
			    }
			</script>
		<?php endif ?>
	<?php endif ?>

	<div id="ratings-disclaimer">
		<b> Notes </b>
		<p >
			Rankings last updated on <?php echo date_format(new DateTime($updateDate), 'l \t\h\e jS \o\f F\, Y') ?>. UK Racketlon endeavours to track ratings as accurately as possible. If you think you have found a mistake, please feel free to <a href="http://www.racketlon.co.uk/index.php/contact-us">contact us</a>.
		</p>
	</div>

	<script>
		// Fill autocomplete
	    var players = <?php echo $js_players ?>;
	    var names = [];
	    var idsByName = {};

	    for(var i = 0; i < players.length; i++)
	    {
	    	names.push(players[i]['name']);
	    	idsByName[players[i]['name']] = players[i]['id'];
	    }

	    function search()
	    {
	    	var name = jQuery("#player-search-box").val();
	    	if(name)
	    	{
	    		var errorTxt = jQuery("#player-search-error");
	    		if(name in idsByName)
	    		{
	    			errorTxt.text("");
	    			window.location="http://www.racketlon.co.uk/index.php/rankings/search?option=com_racketlonrankings&player_id=" + idsByName[name];
	    		}
	    		else
	    		{
	    			jQuery('#ui-id-1').hide();
	    			errorTxt.text("Could not find player '" + name + "'");
	    			errorTxt.collapse('show');
	    		}
	    	}
	    }

	    jQuery("#player-search-box").autocomplete({
	    	source: function(req, response) {
				response(jQuery.ui.autocomplete.filter(names, req.term).slice(0, 10));//for getting 5 results
			},
			select: function(event, ui) {
		        jQuery("#player-search-box").val(ui.item.value);
		        search();
		    }
	    });

	    document.getElementById("player-search-box").onkeypress = function(e)
	    {
		    if(!e) 
		    {
		    	e = window.event;
		    } 

		    var keyCode = e.keyCode || e.which;
		    if (keyCode == '13')
		    {
		    	// Enter pressed
		    	search();
		    }
		};

		document.getElementById("player-search-icon").onclick = function(e)
		{
			search();
		};
	</script>


<?php endif ?>




