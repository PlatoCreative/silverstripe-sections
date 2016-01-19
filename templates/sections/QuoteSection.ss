<div {$AnchorAttr} class='section quote-section'>
	<blockquote class='blockquote'>
		<% if Quote %>
		<p>
			$Quote
		</p>
		<% end_if %>
		<% if Citation %>
		<footer>
			<cite class='cite'>
				$Citation
			</cite>
		</footer>
		<% end_if %>
	</blockquote>
</div>
