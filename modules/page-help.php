<?php
register_module([
	"name" => "Help page",
	"version" => "0.4",
	"author" => "Starbeamrainbowlabs",
	"description" => "Adds the help action. You really want this one.",
	"id" => "page-help",
	"code" => function() {
		add_action("help", function() {
			global $settings, $version;
			
			$title = "Help - $settings->sitename";
			$content = "	<h1>$settings->sitename Help</h1>
	<p>Welcome to $settings->sitename!</p>
	<p>$settings->sitename is powered by Pepperminty wiki, a complete wiki in a box you can drop into your server.</p>
	<h2>Navigating</h2>
	<p>All the navigation links can be found in the top right corner, along with a box in which you can type a page name and hit enter to be taken to that page (if your site administrator has enabled it).</p>
	<p>In order to edit pages on $settings->sitename, you probably need to be logged in. If you do not already have an account you will need to ask $settings->sitename's administrator for an account since there is not registration form. Note that the $settings->sitename's administrator may have changed these settings to allow anonymous edits.</p>
	<h2>Editing</h2>
	<p>$settings->sitename's editor uses a modified version of slimdown, a flavour of markdown that is implementated using regular expressions. See the credits page for more information and links to the original source for this. A quick reference can be found below:</p>
	<table>
		<tr><th>Type This</th><th>To get this</th>
		<tr><td><code>_italics_</code></td><td><em>italics</em></td></tr>
		<tr><td><code>*bold*</code></td><td><strong>bold</strong></td></tr>
		<tr><td><code># Heading</code></td><td><h2>Heading</h2></td></tr>
		<tr><td><code>## Sub Heading</code></td><td><h3>Sub Heading</h3></td></tr>
		<tr><td><code>[[Internal Link]]</code></td><td><a href='index.php?page=Internal Link'>Internal Link</a></td></tr>
		<tr><td><code>[[Display Text|Internal Link]]</code></td><td><a href='index.php?page=Internal Link'>Display Text</a></td></tr>
		<tr><td><code>[Display text](//google.com/)</code></td><td><a href='//google.com/'>Display Text</a></td></tr>
		<tr><td><code>~~Strikethrough~~</code></td><td><del>Strikethough</del></td></tr>
		<tr><td><code>&gt; Blockquote<br />&gt; Some text</code></td><td><blockquote> Blockquote<br />Some text</td></tr>
		<tr><td><code>
	---
	</code></td><td><hr /></td></tr>
		<tr><tds><code> - One
 - Two
 - Three</code></td><td><ul><li>One</li><li>Two</li><li>Three</li></ul></td></tr>
	</table>
	<h2>Administrator Actions</h2>
	<p>By default, the <code>delete</code> and <code>move</code> actions are shown on the nav bar. These can be used by administrators to delete or move pages.</p>
	<p>The other thing admininistrators can do is update the wiki (provided they know the site's secret). This page can be found here: <a href='?action=update'>Update $settings->sitename</a>.</p>
	<p>$settings->sitename is currently running on Pepperminty Wiki <code>$version</code></p>";
			exit(renderpage($title, $content));
		});
	}
]);

?>
