<section {$AnchorAttr} class='section team-section'>
	<% if Title %>
		<h2 class='title'>
			$Title
		</h2>
	<% end_if %>
	<% if Content %>
	<div class='content'>
		$Content
	</div>
	<% end_if %>
	<% if Team %>
	<% loop Team %>
		<div class="person" $AnchorAttr>
			<% if Image %>
				<% with Image %>
					<img src="$Fill(340,340).URL" alt="$Title" height="340" width="340" />
				<% end_with %>
			<% end_if %>
			<% if Name %>
				<p class='name'>
					$Name
				</p>
			<% end_if %>
			<% if Title %>
				<p class='title'>
					$Title
				</p>
			<% end_if %>
			<% if Email %>
				<a class='email' href="mailto: $Email">
					$Email
				</a>
			<% end_if %>
			<% if Description %>
				<div class='description'>
					$Description
				</div>
			<% end_if %>
		</div>
	<% end_loop %>
	<% end_if %>
</section>
