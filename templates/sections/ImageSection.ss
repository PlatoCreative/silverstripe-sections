<section {$AnchorAttr} class='section image-section'>
	<div class="row">
		<div class="column">
			<div class="slider cycle-slideshow"
				data-cycle-fx="ease"
				data-cycle-speed="500"
				data-cycle-timeout="6000"
				data-cycle-slides=">.slide"
				data-cycle-pager=">.slider-pager"
				data-cycle-swipe=true
				data-cycle-prev=">.slider-prev"
				data-cycle-next=">.slider-next"
				>
				<% loop Images %>
					<div class="slide">
						<div class="parallax">
							<img
								alt="{$Title}"
								data-interchange="
									[{$Fill(500, 1200).URL}, small],
									[{$Fill(400, 800).URL}, medium],
									[{$Fill(1030, 1200).URL}, large],
									[{$Fill(1030, 1400).URL}, xlarge]"
								data-focus-x="$FocusX"
								data-focus-y="$FocusY"
								/>
						</div>
					</div>
				<% end_loop %>
				<% if Images.count() >=2 %>
					<div class="slider-prev">
						<i class="fa fa-chevron-left"></i>
					</div>
					<div class="slider-next">
						<i class="fa fa-chevron-right"></i>
					</div>
					<div class="slider-pager-wrapper">
						<div class="slider-pager"></div>
					</div>
				<% end_if %>
			</div>
			<div class="next-section">
				<i class="fa fa-chevron-down"></i>
			</div>
		</div>
	</div>
</section>
