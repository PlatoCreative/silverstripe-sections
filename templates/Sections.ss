<% if Sections %>
<div class="sections" id="sections">
	<% loop Sections.Sort('Sort', ASC) %>
	<!-- AdminTitle = $AdminTitle -->
	$Layout
	<% end_loop %>
</div>
<% end_if %>
