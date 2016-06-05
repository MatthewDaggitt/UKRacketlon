<?php
/**
 * @package     Joomla.Administrator
 * @subpackage  com_racketloneventsmanager
 *
 * @copyright   Copyright (C) 2005 - 2016 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */
 

// Google API key = AIzaSyA-XCnoJQEARUqKqIMI9J16Ax6g5e1Fxh0
// No direct access to this file
defined('_JEXEC') or die('Restricted access');
?>

<?php
	// Sort the items by date
	function cmp($a, $b) {
		if ($a->dated == $b->dated) {
			return ($a->startdate < $b->startdate) ? -1 : 1;
		}
		else {
			return ($a->dated > $b->dated) ? -1 : 1;
		}
	}
	usort($this->items, "cmp");

	

	// Generates a series of date divs
	function generateDates($row) {
		$result  = '';

		if ($row->dated) {

			$begin = new DateTime($row->startdate);
			$end = new DateTime($row->enddate);
			$end = $end->modify('+1 day'); 

			$interval = new DateInterval('P1D');
			$daterange = new DatePeriod($begin, $interval ,$end);
	
			foreach($daterange as $date) {
				$result .= '<div class="rem-date">';
				$result .= 	'<span class="rem-day">' . $date->format("d") . '</span>';
				$result .= 	'<span class="rem-month">' . $date->format("M") . '</span>';
				$result .= '</div>';
			}
		}
		else {
			$result .= '<div class="rem-date rem-date-tbc">';
			$result .= 	'<span class="rem-day">	?? </span>';
			$result .= 	'<span class="rem-month"> TBC </span>';
			$result .= '</div>';
		}

		return $result;
	}

	// Generate the correct trophy image
	function generateTrophy($row) {
		if ($row->type == "World tour") {
			$typeImage = "trophy_gold";
		}
		elseif ($row->type == "UK tour") {
			$typeImage = "trophy_silver";
		}
		elseif ($row->type == "Non-tour") {
			$typeImage = "trophy_bronze";
		}
		
		return '<img class="rem-trophy" src="' . JURI::root() . 'media/com_racketloneventsmanager/images/' . $typeImage . '" data-toggle="tooltip" title="' . $row->type . '">';
	}
?>

<script src="http://maps.googleapis.com/maps/api/js?key=AIzaSyA-XCnoJQEARUqKqIMI9J16Ax6g5e1Fxh0"></script>
<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
<script>
	function initialise() {

		var mapProp = {
			center:new google.maps.LatLng(54.5, -3.6252),
			zoom:5,
			streetViewControl: false,
			mapTypeControl: false,
			mapTypeId:google.maps.MapTypeId.ROADMAP
		};
		
		var map = new google.maps.Map(document.getElementById("googleMap"), mapProp);
		var infoWindow = new google.maps.InfoWindow({
    		content: "Hello"
  		});


		function createMarker(id, latlon, content, occured) {
			// Create a marker and set its position.
			var marker = new google.maps.Marker({
				map: map,
				position: latlon
			});

			if(occured) {
				marker.setIcon('http://maps.google.com/mapfiles/marker_grey.png');
			}
			else {
				marker.setIcon('http://maps.google.com/mapfiles/marker.png');
			}

			marker.addListener('mouseover', function() {
				infoWindow.open(map, marker);
				infoWindow.setContent(content);
			});

			marker.addListener('mouseout', function() {
				infoWindow.close();
			});

			var timerID;
			marker.addListener('click', function() {
				var eventElement;
				if(jQuery(window).width() < 768) {
					eventElement = "#rem-event-table-" + id;
				}
				else {
					eventElement = "#rem-event-row-" + id;
				}

				jQuery('html,body').animate({
				   scrollTop: jQuery(eventElement).offset().top - jQuery(window).height()/2 + jQuery(eventElement).height()/2
				});

				jQuery(eventElement).effect("pulsate", { times:4 }, 2000);
			});
		};

		<?php
			foreach ($this->items as $i => $row) {
				if($row->latitude != "" && $row->longitude != "") {

					$content = '<div class="rem-marker-title"> ' . $row->name . '</div>';
					$content .= '<div class="rem-marker-dates"> ' . generateDates($row) . '</div>';

					if(new DateTime() < new DateTime($row->startdate))
					{
						$occured = "false";
					}
					else
					{
						$occured = "true";
					}

					echo "\t\t createMarker('" . $row->id . "', {lat: " . $row->latitude . ", lng: " . $row->longitude . "}, '" . $content . "', " . $occured . ");", PHP_EOL;
				}
			}
		?>
	};
	google.maps.event.addDomListener(window, 'load', initialise);
</script>

<h1>
	The <?php echo $this->year;?> Racketlon calendar
</h1>

<?php echo $this->introText; ?>

<div id="rem-legends-div">
	<div class="rem-legend" id="rem-tour-legend">
		<div class="rem-legend-title-div">
			<span class="rem-legend-title">Tour types</span>
		</div>

		<br>

		<table class="rem-legend-content-div">
			<thead>
				<tr>
					<td id="rem-legend-tour-key-header"> </td>
					<td id="rem-legend-tour-value-header"> </td>
				</tr>
			</thead>

			<tbody>
				<tr class="rem-legend-row">
					<td>
						<img class="rem-trophy rem-trophy-key" src="<?php echo JURI::root();?>/media/com_racketloneventsmanager/images/trophy_gold">
					</td>
					<td> World tour </td>
				</tr>
				<tr class="rem-legend-row">
					<td>
						<img class="rem-trophy  rem-trophy-key" src="<?php echo JURI::root();?>/media/com_racketloneventsmanager/images/trophy_silver">
					</td>
					<td> UK tour </td>
				</tr>
				<tr class="rem-legend-row">
					<td>
						<img class="rem-trophy  rem-trophy-key" src="<?php echo JURI::root();?>/media/com_racketloneventsmanager/images/trophy_bronze">
					</td>
					<td> Non-tour </td>
				</tr>
			</tbody>
		</table>
	</div>

	<div class="rem-legend" id="rem-type-legend">
		<div class="rem-legend-title-div">
			<span class="rem-legend-title">Event types</span>
		</div>

		<br>

		<table class="rem-legend-content-div">
			<thead>
				<tr>
					<td id="rem-legend-type-key-header"> </td>
					<td id="rem-legend-type-value-header"> </td>
				</tr>
			</thead>
			<tbody>
				<tr class="rem-legend-row">
					<td>
						<img class="rem-type-image rem-trophy-key" src="<?php echo JURI::root();?>/media/com_racketloneventsmanager/images/singles">
					</td>
					<td> Singles </td>
				</tr>
				<tr class="rem-legend-row">
					<td>
						<img class="rem-type-image rem-trophy-key" src="<?php echo JURI::root();?>/media/com_racketloneventsmanager/images/doubles">
					</td>
					<td> Doubles </td>
				</tr>
				<tr class="rem-legend-row">
					<td>
						<img class="rem-type-image rem-trophy-key" src="<?php echo JURI::root();?>/media/com_racketloneventsmanager/images/team">
					</td>
					<td> Teams </td>
				</tr>
			</tbody>
		</table>
	</div>
</div>

<div id="googleMap"></div>

<table class="table table-hover" id="rem-desktop-events-table">
	<thead>
		<tr>
			<th colspan="6" id="rem-events-subheading"> Events in <?php echo $this->year;?> </th>
		</tr>
	</thead>
	
	<tfoot>
		<tr>
			<td colspan="5"></td>
		</tr>
	</tfoot>
	
	<tbody>
		<?php $lastDate = ""?>

		<?php foreach ($this->items as $i => $row) : ?>
		
			<?php if((!$row->dated) && $lastDate == "") : ?>
				<?php $lastDate = "TBC"; ?>
				<tr>
					<td colspan="6" id="rem-events-tbc-subheading"> To be confirmed </td>
				</tr>
			<?php endif ?>

			<tr id="rem-event-row-<?php echo $row->id; ?>">
				<td> <?php echo generateTrophy($row); ?> </td>
				<td> <?php echo $row->name; ?> </td>
				<td> <?php echo generateDates($row); ?> </td>
				<td> <?php echo $row->location; ?> </td>
				<td>
					<div class="rem-type-image-container">
						<?php if ($row->singles == 1): ?>
							<img 
								class="rem-type-image" 
								src="<?php echo JURI::root();?>/media/com_racketloneventsmanager/images/singles.png"
								data-toggle="tooltip"
								title="Singles"
							>
						<?php endif ?>

						<?php if ($row->doubles == 1): ?>
							<img 
								class="rem-type-image" 
								src="<?php echo JURI::root();?>/media/com_racketloneventsmanager/images/doubles.png"
								data-toggle="tooltip"
								title="Doubles"
							>
						<?php endif ?>

						<?php if ($row->teams == 1): ?>
							<img 
								class="rem-type-image" 
								src="<?php echo JURI::root();?>/media/com_racketloneventsmanager/images/team.png"
								data-toggle="tooltip"
								title="Teams"
							>
						<?php endif ?>
					</div>
				</td>
				<td>
					<?php if ($row->link != ""): ?>
						<?php if (new DateTime() < new DateTime($row->startdate)) : ?>
							<a href='<?php echo $row->link?>' class="rem-event-link-button enter bd-slide-button btn">
								<span> Enter </span>
							</a>
						<?php else: ?>
							<a href='<?php echo $row->link?>' class="rem-event-link-button results bd-slide-button btn">
								<span> Results </span>
							</a>
						<?php endif ?>
					<?php else: ?>
						<div class="rem-event-link-nyo">
							<span>
								<?php if (new DateTime() < new DateTime($row->startdate) || !$row->dated) : ?>
									Not yet open
								<?php else: ?>
									No results
								<?php endif ?>
							</span>
						</div>
					<?php endif ?>
				</td>
			</tr>
		<?php endforeach; ?>
	</tbody>
</table>

<div id="rem-mobile-events-tables">
	<?php foreach ($this->items as $i => $row) : ?>
		<table class="rem-mobile-events-table table table-hover" id="rem-event-table-<?php echo $row->id; ?>">
			<thead>
				<tr>
					<th>
						<div class="rem-trophy-header"> <?php echo generateTrophy($row); ?> </div>
					</th>
					<th class="rem-name-header"> <?php echo $row->name; ?> </th>
				</tr>
			</thead>
			<tfoot>
				<tr>
					<td colspan="2"></td>
				</tr>
			</tfoot>
			<tbody>
				<tr>
					<td class="rem-mobile-row-header"> Location </td>
					<td> <?php echo $row->location; ?> </td>
				</tr>
				<tr>
					<td class="rem-mobile-row-header"> Dates </td>
					<td>
						<?php echo generateDates($row); ?>
					</td>
				</tr>
				<tr>
					<td class="rem-mobile-row-header"> Type </td>
					<td>
						<div class="rem-type-image-container">
							<?php if ($row->singles == 1) : ?>
								<img 
									class="rem-type-image" 
									src="<?php echo JURI::root();?>/media/com_racketloneventsmanager/images/singles.png"
									data-toggle="tooltip"
									title="Singles"
								>
							<?php endif ?>

							<?php if ($row->doubles == 1) : ?>
								<img 
									class="rem-type-image" 
									src="<?php echo JURI::root();?>/media/com_racketloneventsmanager/images/doubles.png"
									data-toggle="tooltip"
									title="Doubles"
								>
							<?php endif ?>

							<?php if ($row->teams == 1) : ?>
								<img 
									class="rem-type-image" 
									src="<?php echo JURI::root();?>/media/com_racketloneventsmanager/images/team.png"
									data-toggle="tooltip"
									title="Teams"
								>
							<?php endif ?>
						</div>
					</td>
				<tr>
					<td class="rem-mobile-row-header"> </td>
					<td> 
						<?php if ($row->link != ""): ?>
							<?php if (new DateTime() < new DateTime($row->startdate)) : ?>
								<a href='<?php echo $row->link?>' class="rem-event-link-button enter bd-slide-button btn">
									<span> Enter </span>
								</a>
							<?php else: ?>
								<a href='<?php echo $row->link?>' class="rem-event-link-button results bd-slide-button btn">
									<span> Results </span>
								</a>
							<?php endif ?>
						<?php else: ?>
							<div class="rem-event-link-nyo">
								<span>
									<?php if (new DateTime() < new DateTime($row->startdate) || !$row->dated) : ?>
										Not yet open
									<?php else: ?>
										No results
									<?php endif ?>
								</span>
							</div>
						<?php endif ?>
					</td>
				<tr>
			</tbody>
		</table>
	<?php endforeach; ?>
</div>