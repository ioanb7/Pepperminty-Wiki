<?php
register_module([
	"name" => "Page viewer",
	"version" => "0.4",
	"author" => "Starbeamrainbowlabs",
	"description" => "Allows you to view pages. You should include this one.",
	"id" => "page-view",
	"code" => function() {
		add_action("view", function() {
			global $pageindex, $settings, $page;
			
			//check to make sure that the page exists
			if(!isset($pageindex->$page))
			{
				// todo make this intelligent so we only redirect if the user is acutally able to create the page
				if($settings->editing)
				{
					//editing is enabled, redirect to the editing page
					http_response_code(307); //temporary redirect
					header("location: index.php?action=edit&newpage=yes&page=" . rawurlencode($page));
					exit();
				}
				else
				{
					//editing is disabled, show an error message
					http_response_code(404);
					exit(renderpage("$page - 404 - $settings->sitename", "<p>$page does not exist.</p><p>Since editing is currently disabled on this wiki, you may not create this page. If you feel that this page should exist, try contacting this wiki's Administrator.</p>"));
				}
			}
			$title = "$page - $settings->sitename";
			$content = "<h1>$page</h1>";
			
			$slimdown_start = microtime(true);
			
			$content .= Slimdown::render(file_get_contents("$page.md"));
			
			$content .= "\n\t<!-- Took " . (microtime(true) - $slimdown_start) . " seconds to parse markdown -->\n";
			
			if(isset($_GET["printable"]) and $_GET["printable"] === "yes")
				$minimal = true;
			else
				$minimal = false;
			exit(renderpage($title, $content, $minimal));
		});
	}
]);

?>
