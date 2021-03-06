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

<?php if($this->updating) : ?>
	
	<p> Apologies, the rankings are currently being updated. This normally only takes 5 minutes so please check again soon. If the problem persists please get in touch with the webmaster via the <a href="http://www.racketlon.co.uk/index.php/contact-us">Contact us</a> page.</p>

<?php else : ?>

	<?php
		$countries = $this->data["countries"];
		$players = $this->data["players"];
		$updateDate = $this->data["updateDate"];

		$js_players = json_encode($players);
	?>

	<h1> All rankings </h1>

	<div id="ranking-controls">

		<div class="control-group">
			<div class="control-label">
				<label>
					Nationality: 
				</label>
			</div>
			<div class="controls">
				<select name="country">
					<option value="All">All</option>
					<?php foreach($countries as $code => $name) : ?>
						<option 
							value="<?php echo $code ?>"
							<?php echo ($code == "GBR" ? 'selected="selected"' : "") ?>
						>
							<?php echo $name ?>
						</option>
					<?php endforeach ?>
				</select>
			</div>
		</div>

		<div class="control-group">
			<div class="control-label">
				<label>
					Gender:
				</label>
			</div>
			<div class="controls">
				<select name="gender">
				  <option value="All">All</option>
				  <option value="1">Female</option>
				  <option value="0">Male</option>
				</select>
			</div>
		</div>

		<div class="control-group">
			<div class="control-label">
				<label>
					Age group: 
				</label>
			</div>
			<div class="controls">
				<select name="age">
					<option value="All">All</option>
					<option value="U21">U21</option>
					<option value="O45">O45</option>
					<option value="O55">O55</option>
				</select>
			</div>
		</div>

		<div class="control-group" id="search-control-group">
			<div class="control-label">
				<label>
					Search:
				</label>
			</div>
			<div class="controls">
				<input name="name" type="text" placeholder="name">
			</div>
		</div>
	</div>

	<h2 id="ranking-title"> </h2>

	<div class="rankings-table-container">
		<h2> 
			<?php echo $key ?>
		</h2>

		<table class="rankings-table" data-sorting="true" data-paging="true" data-filtering="true" data-toggle-column="last">
			<thead>
				<tr>
					<th data-name="rank" 	class="rank-col" 	data-type="number" 	data-sortable="false"> 	# </th>
					<th data-name="name" 	class="name-col" 	data-type="html" 	data-sortable="false"> 	Name </th>
					<th data-name="rating" 	class="rating-col" 	data-type="number" 	data-breakpoints="xss"> Rating</th>
					<th data-name="class" 	class="class-col" 	data-type="text" 	data-breakpoints="xss"> Class </th>
					<th data-name="tt" 		class="tt-col" 		data-type="text" 	data-breakpoints="xss xs"> TT </th>
					<th data-name="bd" 		class="bd-col" 		data-type="text" 	data-breakpoints="xss xs"> Bd </th>
					<th data-name="sq" 		class="sq-col" 		data-type="text" 	data-breakpoints="xss xs"> Sq </th>
					<th data-name="tn" 		class="tn-col" 		data-type="text" 	data-breakpoints="xss xs"> Tn </th>
					<th data-name="age" 	class="age-col" 	data-type="date" 	data-visible="false"> 	DoB </th>
					<th data-name="gender" 	class="gender-col" 	data-type="text" 	data-visible="false"> 	Gender </th>
					<th data-name="country" class="country-col" data-type="text" 	data-visible="false"> 	Country </th>
					<th data-name="dummy"></th>
				</tr>
			</thead>
		</table>

		<div id="ratings-disclaimer">
			<b> Notes </b>
			<p >
				Rankings last updated on <?php echo date_format(new DateTime($updateDate), 'l \t\h\e jS \o\f F\, Y') ?>. Only players who have at least 5 matches on record and have played in the last 270 days are included in the rankings. Non-UK players are only included in the rankings if they have played in tournaments on the FIR tour. More information on rankings and ratings can be found <a href="http://www.racketlon.co.uk/index.php/rankings/ratings-explained">here</a>.
			</p>
			<p>
				UK Racketlon endeavours to track ratings as accurately as possible. If you think you have found a mistake, please feel free to <a href="http://www.racketlon.co.uk/index.php/contact-us">contact us</a>.
			</p>
		</div>
	</div>




	<script type="text/javascript" src="/templates/uk_racketlon/js/footable.js"></script>
	<link rel="stylesheet" type="text/css" href="/templates/uk_racketlon/css/footable.bootstrap.min.css">
	<script type="text/javascript" src="/templates/uk_racketlon/js/heartcode-canvasloader.min.js"></script>

	<script>
		// Data setup
		var players = <?php echo $js_players ?>;
		var updateDate = new Date("<?php echo $updateDate ?>");
		var oneDay = 24*60*60*1000;

		var rows = [];
		for(var i = 0; i < players.length; i++)
		{
			p = players[i];

			var name = '<a href="http://www.racketlon.co.uk/index.php/rankings/search?option=com_racketlonrankings&player_id=' + p['id'] + '">' + p['name'] + "</a>";
			
			var country = p['country'];
			if(p['country'] == "SCO" || p['country'] == "WAL" || p['country'] == "IMN" || p['country'] == "NIR" || p['country'] == "ENG")
			{
				country += " GBR";
			}

			if(p['gbrdate'] != "0000-00-00" && country.indexOf("GBR") == -1)
			{
				var lastDate = new Date(p['gbrdate']);
				var days = Math.round(Math.abs((updateDate.getTime() - lastDate.getTime())/(oneDay)));

				if(days <= 275)
				{
					country += " GBR";
				}
			}

			rows.push({
				"rank": 	i+1,
				"name": 	name,
				"rating": 	p['rating'],
				"class": 	
				{
					"options": 
					{
						"classes": "player-class-cell"
					},
					"value": (1 - p['rating']/100000).toFixed(5),	// Needed to hack the sorting order
				},
				"tt": 		(1 - p['ratingtt']/100000).toFixed(5),
				"bd": 		(1 - p['ratingbd']/100000).toFixed(5),
				"sq": 		(1 - p['ratingsq']/100000).toFixed(5),
				"tn": 		(1 - p['ratingtn']/100000).toFixed(5),
				"age": 		"All " + p['dob'],
				"gender": 	"All " + p['gender'],
				"country": 	"All " + country,
				"dummy": 	""
			});
		}

		function formatRating(rating)
		{
			rating = (1 - parseFloat(rating))*100000;

			if(rating < 10000)
				return "??";
			if(rating < 12000)
				return "D" + Math.ceil((12000 - rating)/500);
			if(rating < 14000)
				return "C" + Math.ceil((14000 - rating)/500);
			if(rating < 16000)
				return "B" + Math.ceil((16000 - rating)/500);
			if(rating < 18000)
				return "A" + Math.ceil((18000 - rating)/500);
			if(rating < 20000)
				return Math.ceil((20000 - rating)/500) + "+";
			
			return '0+';
		}

		var columns = [
			{},
			{},
			{},

			{"formatter":formatRating},
			{"formatter":formatRating},
			{"formatter":formatRating},
			{"formatter":formatRating},
			{"formatter":formatRating},

			{},
			{},
			{}
		]


		jQuery(".rankings-table").footable({
			"toggleColumn": "last",
			"breakpoints": {
				"xss": 320,
				"xs": 480,
				"s": 600,
				"m": 992,
				"l": 1200,
				"xl": 1400
			},
			"rows": rows,
			"columns": columns
		});

		

		function filter()
		{
			var gender 	= jQuery('[name=gender] option:selected');
			var country = jQuery('[name=country] option:selected');
			var age 	= jQuery('[name=age] option:selected');
			var name 	= jQuery('[name=name]');

			// Filters
			var filtering = FooTable.get('.rankings-table').use(FooTable.Filtering);
			filtering.addFilter("gender", 	gender.val(), 	["gender"]);
			filtering.addFilter("country", 	country.val(), 	["country"]);
			filtering.addFilter("age", 		age.val(), 		["age"]);
			filtering.addFilter("name", 	name.val(), 	["name"]);
			filtering.filter();

			// Header
			var genderTxt = gender.text();
			var countryTxt = country.text();
			var ageTxt = age.text();

			var text = "";
			if(ageTxt != "All")
			{
				text += ageTxt + " ";
			}
			if(genderTxt != 'All')
			{
				text += genderTxt + " ";
			}
			if(countryTxt != "All" || (genderTxt == "All" && ageTxt == "All"))
			{
				text += countryTxt + " ";
			}
			text += "players";
			jQuery('#ranking-title').text(text);
		}

		// Listeners
		var britishCodes = ["IMN", "ENG", "WAL", "SCO", "NIR", "GBR"];

		jQuery('[name=gender]').on('change', filter);
		jQuery('[name=age]').on('change', filter);
		jQuery('[name=country]').on('change', function() {
			if(britishCodes.indexOf(this.value) > -1)
			{
				jQuery('[name=age]').prop('disabled', false);
			}
			else
			{
				jQuery('[name=age]').val("All");
				jQuery('[name=age]').prop('disabled', true);
			}
			filter();
		});
		jQuery('[name=name]').on('change', filter);
		jQuery('[name=name]').on('keyup', filter);

		// Cleanup
		FooTable.get('.rankings-table').pageSize(25);
		jQuery(".rankings-table-container").show();

		jQuery('[name=country]').val("GBR");
		jQuery('[name=country]').trigger("change");

		jQuery(function($) {
			

		});
	</script>
<?php endif ?>
