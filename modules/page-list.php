<?php
register_module([
	"name" => "Page list",
	"version" => "0.4",
	"author" => "Starbeamrainbowlabs",
	"description" => "Adds a page that lists all the pages in the index long with their metadata.",
	"id" => "page-list",
	"code" => function() {
		add_action("list", function() {
			global $pageindex, $settings;
			$title = "All Pages";
			$content = "	<h1>$title on $settings->sitename</h1>
	<table>
		<tr>
			<th>Page Name</th>
			<th>Size</th>
			<th>Last Editor</th>
			<th>Last Edit Time</th>
		</tr>\n";
		foreach($pageindex as $pagename => $pagedetails)
		{
			$content .= "\t\t<tr>
			<td><a href='index.php?page=$pagename'>$pagename</a></td>
			<td>" . human_filesize($pagedetails->size) . "</td>
			<td>$pagedetails->lasteditor</td>
			<td>" . human_time_since($pagedetails->lastmodified) . " <small>(" . date("l jS \of F Y \a\\t h:ia T", $pagedetails->lastmodified) . ")</small></td>

		</tr>\n";
			}
			$content .= "	</table>";
			exit(renderpage("$title - $settings->sitename", $content));
		});
	}
]);

?>
