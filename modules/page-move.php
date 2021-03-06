<?php
register_module([
	"name" => "Page mover",
	"version" => "0.4",
	"author" => "Starbeamrainbowlabs",
	"description" => "Adds an action to allow administrators to move pages.",
	"id" => "page-move",
	"code" => function() {
		add_action("move", function() {
			global $pageindex, $settings, $page, $isadmin;
			if(!$settings->editing)
			{
				exit(renderpage("Moving $page - error", "<p>You tried to move $page, but editing is disabled on this wiki.</p>
				<p>If you wish to move this page, please re-enable editing on this wiki first.</p>
				<p><a href='index.php?page=$page'>Go back to $page</a>.</p>
				<p>Nothing has been changed.</p>"));
			}
			if(!$isadmin)
			{
				exit(renderpage("Moving $page - Error", "<p>You tried to move $page, but you do not have permission to do that.</p>
				<p>You should try <a href='index.php?action=login'>logging in</a> as an admin.</p>"));
			}
			
			if(!isset($_GET["new_name"]) or strlen($_GET["new_name"]) == 0)
				exit(renderpage("Moving $page", "<h2>Moving $page</h2>
				<form method='get' action='index.php'>
					<input type='hidden' name='action' value='move' />
					<label for='old_name'>Old Name:</label>
					<input type='text' name='page' value='$page' readonly />
					<br />
					<label for='new_name'>New Name:</label>
					<input type='text' name='new_name' />
					<br />
					<input type='submit' value='Move Page' />
				</form>"));
			
			$new_name = makepathsafe($_GET["new_name"]);
			
			if(!isset($pageindex->$page))
				exit(renderpage("Moving $page - Error", "<p>You tried to move $page to $new_name, but the page with the name $page does not exist in the first place.</p>
				<p>Nothing has been changed.</p>"));
			
			if($page == $new_name)
				exit(renderpage("Moving $page - Error", "<p>You tried to move $page, but the new name you gave is the same as it's current name.</p>
				<p>It is possible that you tried to use some characters in the new name that are not allowed and were removed.</p>
				<p>Page names may only contain alphanumeric characters, dashes, and underscores.</p>"));
			
			//move the page in the page index
			$pageindex->$new_name = new stdClass();
			foreach($pageindex->$page as $key => $value)
			{
				$pageindex->$new_name->$key = $value;
			}
			unset($pageindex->$page);
			file_put_contents("./pageindex.json", json_encode($pageindex, JSON_PRETTY_PRINT));
			
			//move the page on the disk
			rename("$page.md", "$new_name.md");
			
			exit(renderpage("Moving $page", "<p><a href='index.php?page=$page'>$page</a> has been moved to <a href='index.php?page=$new_name'>$new_name</a> successfully.</p>"));
		});
	}
]);
?>
