/**
 * File: CMSMain.SectionForm.js
 */
(function($) {
	$.entwine('ss', function($){
		/**
		 * Class: .cms-edit-form input[name=Title]
		 *
		 * Input validation on the Title field
		 */

		$('.cms-edit-form input[name=MenuTitle]').entwine({
			// Constructor: onmatch
			onmatch : function() {
				var self = this;
				self.data('OrigVal', self.val());

				var form = self.closest('form');
				var AdminTitle = $('input:text[name=AdminTitle]', form);
                var MenuTitle = $('input:text[name=MenuTitle]', form);

				if (MenuTitle.length > 0) {
					self._addActions();
					this.bind('change', function(e) {
						var origTitle = self.data('OrigVal');
						var title = self.val();
						self.data('OrigVal', title);
						self.updateRelatedFields(title, origTitle);
                        if(AdminTitle.val() == origTitle){
                            AdminTitle.val(title);
                        }
					});
				}
			}
		});
	});
}(jQuery));
