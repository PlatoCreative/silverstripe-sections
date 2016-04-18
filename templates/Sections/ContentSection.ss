<section {$ClassAttr}{$AnchorAttr}>
	<% if Title %>
	<h2 class="title">
		$Title
	</h2>
	<% end_if %>
	<% if Content %>
	<div class="content">
		$Content
	</div>
	<% end_if %>
	<% if Form %>
	<div class="form">
		$Form
	</div>
	<% end_if %>
</section>
