/**
 * File: CMSMain.EditForm.js
 */
(function($) {
	$.entwine('ss', function($){
		/**
		 * Class: .cms-edit-form input[name=Title]
		 *
		 * Input validation on the Title field
		 */
		$('.cms-edit-form input[name=Title]').entwine({
			// Constructor: onmatch
			onmatch : function() {
				var self = this;

				self.data('OrigVal', self.val());

				var form = self.closest('form');
				var urlSegmentInput = $('input:text[name=URLSegment]', form);
				var liveLinkInput = $('input[name=LiveLink]', form);

				if (urlSegmentInput.length > 0) {
					self._addActions();
					this.bind('change', function(e) {
						var origTitle = self.data('OrigVal');
						var title = self.val();
						self.data('OrigVal', title);

						// Criteria for defining a "new" page
						if (
							urlSegmentInput.val().indexOf(urlSegmentInput.data('defaultUrl')) === 0
							&& liveLinkInput.val() == ''
						) {
							self.updateURLSegment(title);
						} else {
							$('.update', self.parent()).show();
						}

						self.updateRelatedFields(title, origTitle);
					});
				}

				this._super();
			},
			onunmatch: function() {
				this._super();
			},

			/**
			 * Function: updateRelatedFields
			 *
			 * Update the related fields if appropriate
			 * (String) title The new title
			 * (Stirng) origTitle The original title
			 */
			updateRelatedFields: function(title, origTitle) {
				// Update these fields only if their value was originally the same as the title
				this.parents('form').find('input[name=MenuTitle]').each(function() {
					var $this = $(this);
					if($this.val() == origTitle) {
						$this.val(title);
						// Onchange bubbling didn't work in IE8, so .trigger('change') couldn't be used
						if($this.updatedRelatedFields) $this.updatedRelatedFields();
					}
				});
			},

			/**
			 * Function: updateURLSegment
			 *
			 * Update the URLSegment
			 * (String) title
			 */
			updateURLSegment: function(title) {
				var urlSegmentInput = $('input:text[name=URLSegment]', this.closest('form'));
				var urlSegmentField = urlSegmentInput.closest('.field.urlsegment');
				var updateURLFromTitle = $('.update', this.parent());
				urlSegmentField.update(title);
				if (updateURLFromTitle.is(':visible')) {
					updateURLFromTitle.hide();
				}
			},



		});
	});
}(jQuery));
