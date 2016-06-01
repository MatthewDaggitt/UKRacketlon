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

<?php
	function classSortValue($class)
	{
		return $class == "??" ? ' data-sort-value="Z"' : '';
	}
?>

<h1> Top UK players </h1>

Note: Genders are currently randomly assigned and some UK players are not properly registered...

<div class="test">
	<form class="form-inline">
		<label>
			Gender: 
			<select name="gender">
			  <option value="all">All</option>
			  <option value="1">Female</option>
			  <option value="0">Male</option>
			</select>
		</label>

		<!--
		<label>
			Age: 
			<select name="age">
			  <option value="all">All</option>
			  <option value="u18">U18</option>
			  <option value="o45">O45</option>
			  <option value="o45">O55</option>
			</select>
		</label>
		-->

		<label>
			Nationality: 
			<select name="country">
			  <option value="GBR">UK</option>
			  <option value="all">All</option>
			</select>
		</label>
	</form>
</div>

<div id="loading-div"> </div>

<div class="rankings-table-container">
	<h2> 
		<?php echo $key ?>
	</h2>

	<table class="rankings-table" data-sorting="true" data-paging="true" data-filtering="true" data-toggle-column="last">
		<thead>
			<tr>
				<th class="rank-col" 	data-type="number" 	data-sortable="false"> # </th>
				<th class="name-col" 	data-type="html" 	data-sortable="false"> Name </th>
				<th class="rating-col" 	data-type="number" 	data-breakpoints="xss"> Rating</th>
				<th class="class-col" 	data-type="text" 	data-breakpoints="xss"> Class </th>
				<th class="tt-col" 		data-type="text" 	data-breakpoints="xss"> TT </th>
				<th class="bd-col" 		data-type="text" 	data-breakpoints="xss"> Bd </th>
				<th class="sq-col" 		data-type="text" 	data-breakpoints="xss"> Sq </th>
				<th class="tn-col" 		data-type="text" 	data-breakpoints="xss"> Tn </th>
				<th class="dob-col" 	data-type="date" 	data-visible="false"> DoB </th>
				<th data-name="gender" 	class="gender-col" 	data-type="text" 	data-visible="false"> Gender </th>
				<th data-name="country" class="country-col" data-type="text" 	data-visible="false"> Country </th>
			</tr>
		</thead>
		
		<tfoot>
			<tr>
				<td colspan="8"></td>
			</tr>
		</tfoot>
		
		<tbody>
			<?php foreach($this->data as $i => $p) : ?>
				<tr>
					<td> 
						<?php echo ($i + 1) ?>
					</td>
					<td>
						<a href="http://www.racketlon.co.uk/index.php/rankings/search?option=com_racketlonrankings&player_id=<?php echo $p['id'] ?>">
							<?php echo $p['name'] ?>
						</a>
					</td>
					<td>
						<?php echo ($p['rating']) ?>
					</td>
					<td <?php echo classSortValue($p['class']) ?>>
						<?php echo ($p['class']) ?>
					</td>
					<td <?php echo classSortValue($p['classtt']) ?>>
						<?php echo ($p['classtt']) ?>
					</td>
					<td <?php echo classSortValue($p['classbd']) ?>>
						<?php echo ($p['classbd']) ?>
					</td>
					<td <?php echo classSortValue($p['classsq']) ?>>
						<?php echo ($p['classsq']) ?>
					</td>
					<td <?php echo classSortValue($p['classtn']) ?>>
						<?php echo ($p['classtn']) ?>
					</td>
					<td>
						<?php echo ($p['dob']) ?>
					</td>
					<td>
						<?php echo ($p['gender']) ?>
					</td>
					<td>
						<?php echo ($p['country']) ?>
					</td>
				</tr>
			<?php endforeach ?>
		</tbody>
	</table>
</div>

<script type="text/javascript" src="/templates/uk_racketlon/js/footable.min.js"></script>
<link rel="stylesheet" type="text/css" href="/templates/uk_racketlon/css/footable.bootstrap.min.css">

<script type="text/javascript" src="/templates/uk_racketlon/heartcode-canvasloader.min.js"></script>

<script>

	var cl = new CanvasLoader("loading-div");
	cl.setDiameter(93); // default is 40
	cl.setDensity(20); // default is 40
	cl.setRange(0.7); // default is 1.3
	cl.setSpeed(1); // default is 2
	cl.setFPS(25); // default is 24
	cl.show(); // Hidden by default

	setTimeout(function() {
		
		jQuery(".rankings-table").footable({
			"breakpoints": {
				"xss": 320,
				"xs": 480,
				"s": 768,
				"m": 992,
				"l": 1200,
				"xl": 1400
			}
		});
		FooTable.get('.rankings-table').pageSize(25);


		function filter(name, value)
		{
			var filtering = FooTable.get('.rankings-table').use(FooTable.Filtering);

			if (value === 'all')
			{
				filtering.removeFilter(name);
			} 
			else 
			{
				console.log(name, value, [name]);
				filtering.addFilter(name, value, [name]);
			}
			filtering.filter();

			var tds= jQuery("table > tbody > td:nth-child(1)");
			console.log(tds);
		}

		jQuery('[name=gender]').on('change', function()
		{
			filter("gender", this.value);
		});


		jQuery('[name=country]').on('change', function()
		{
			filter("country", this.value);
		});

		jQuery('[name=country]').trigger("change");

		jQuery(".rankings-table-container").show();
		cl.kill();
	}, 100);

</script>