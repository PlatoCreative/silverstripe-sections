<section {$AnchorAttr} class='section children-section'>
	<% if Title %>
		<h2 class='title'>
			$Title
		</h2>
	<% end_if %>
	<% if Children %>
	<% loop Children %>
		<a class="teaser"
			href="$Link"
		>
			<% if Title %>
				<p class='title'>
					$Title
				</p>
			<% end_if %>
		</a>
	<% end_loop %>
	<% end_if %>
</section>
