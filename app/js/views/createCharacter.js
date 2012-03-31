define([
	'models/character',
	'tpl!template/createCharacter.html',
	'libs/backbone.modelbinding',
	'libs/backbone.validation'
],
function(Character_Model, Page_Tpl, ModelBinding) {
	return Backbone.View.extend({
		model: null,
		collection: null,
		loading: false,
		events: {
			'submit form': 'onSubmit',
			'blur .controls input': 'doValidate',
			'blur .controls select': 'doValidate',
		},
		initialize:function() {
			_(this).bindAll();
			this.loading = true;
			this.collection = this.options.collection;
			this.model = new Character_Model();
			this.render();
		},
		render: function() {
			$(this.el).html(Page_Tpl());
			ModelBinding.bind(this);
			Backbone.Validation.bind(this, {
				forceUpdate: true
			});
			this.loading = false;
			return this;
		},
		onSubmit: function(e) {
			e.preventDefault();
			var self = this;
			if( !this.model.isValid() ) {
				this.$('[name]').each(function(i, el) {
					self.markError($(el).attr('name'));
				});
				this.$('.error-message').show().fadeOut(5000);
				return;
			}
			this.$('.error-message').hide();

			this.collection.add(this.model);
			this.model.save({
				success: function(model,response) {
					this.navigate('character/'+this.model.get('slug'),{trigger:true});
				},
				error: function(model,response) {
					// TODO: display an error?
				}
			});

			return false;
		},
		doValidate: function(e) {
			this.markError($(e.target).attr('name'));
		},
		markError: function(fieldName) {
			this.$('[name="'+fieldName+'"]').closest('.control-group')
				.toggleClass('error', !this.model.isValid(fieldName))
		}
	});
});
