export default {
	props: {
		name: {
			type: String,
			required: true,
		},
		type: {
			type: String,
		},
		label: {
			type: String,
		},
		placeholder: {
			type: String,
			default: ""
		},
		required: {
			type: Boolean,
			default: true,
		},
		value: {
			type: [String, Number, Date, Array],
		},
		disabled: {
			type: Boolean,
			default: false,
		},
		readonly: {
			type: Boolean,
			default: false,
		},
		choices: {
			type: Array,
			default() {
				return [];
			}
		},
		multiple: {
			type: Boolean,
			default: false,
		},
		step: {
			type: [String, Number],
			default: 1,
		},
		min: {
			type: [String, Number, Date],
		},
		max: {
			type: [String, Number, Date],
		},
	},
	data() {
		return {
			instance: null,
			val: this.value,
			errors: [],
		};
	},
	computed: {
		canSend() {
			return this.errors.length == 0;
		},
		model: {
			get() {
				if(this.multiple || this.type == 'checkbox') {
					if(this.val instanceof Array) {
						return this.val;
					}
					else {
						return this.val == null ? [] : [this.val];
					}
				}
				else {
					if(this.val instanceof Array && this.type != 'file') {
						return this.val[0] == null ? null : this.val[0];
					}
					else {
						return (this.val == null) ? null : this.val;
					}
				}
			},
			set(newValue) {
				this.val = newValue;
			}
		},
	},
	watch: {
		model(n, o) {
			this.checkValidity();
			this.$emit("change", n);
		},
		value(nVal, oVal) {
			this.val = nVal;
		}
	},
	methods: {
		checkValidity() {
			this.errors = [];
			// On va regarder si l'input est requis et pas disabled
			if(this.required && !this.disabled) {
				// Si jamais le model est null OU que l'on soit en multiple avec un tableau vide OU alors que le model soit une string mais vide
				if(this.model == null || (this.multiple && this.model.length == 0) || (!this.multiple && this.model.toString().replace(/\s/g, '').length == 0)) {
					this.errors.push("Vous devez renseigner ce champ");
				}
				else {
					switch(this.type) {
						// SI ON EST EN MODE TEXTE
						case "text":
						case "textarea":
							if (this.min == this.max && this.model.length != this.min && this.min != null && this.max != null){
								this.errors.push(`Le champ doit faire ${this.min} caractères.`);
							}
							else if (this.max != null && this.min != null && (this.model.length > this.max || this.model.length < this.min)) {
								this.errors.push(`Le champ doit faire entre ${this.min} et ${this.max} caractères.`);
							} else if (this.max != null && this.model.length > this.max) {
								this.errors.push(`Le champ doit faire ${this.max} caractères ou moins.`);
							} else if (this.min != null && this.model.length < this.min) {
								this.errors.push(`Le champ doit faire ${this.min} caractères ou plus.`);
							}
						break;
						// SI ON EST EN MODE EMAIL GROSSE REGEX
						case "email":
							if (!/^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/.test(this.model)) {
								this.errors.push('Veuillez rentrer un email valide.');
							}
						break;
						// SI ON EST EN MODE NOMBRE
						case "number":
							if (this.max != null && this.min != null && (this.model > this.max || this.model < this.min)) {
								this.errors.push(`Veuillez rentrer une valeur entre ${this.min} et ${this.max}.`);
							} else if (this.max != null && this.model > this.max) {
								this.errors.push(`Veuillez rentrer une valeur inférieure à ${this.max}.`);
							} else if (this.min != null && this.model < this.min) {
								this.errors.push(`Veuillez rentrer une valeur supérieure à ${this.min}.`);
							}
						break;
						// SI ON EST EN MODE DATE
						case "date" :
							let date = new Date(this.model);
							if(!(date instanceof Date && !isNaN(date))){
								this.errors.push('Veuillez rentrer une date valide.');
							} else {
								if(this.max != null || this.min != null) {
									let error = [];
									if(this.min != null && new Date(this.min) > date) {
										error.push(' supérieure à ' + new moment(new Date(this.min)).format('DD/MM/YYYY'));
									}
									if(this.max != null && new Date(this.max) < date) {
										error.push(` inférieure à ` + new moment(new Date(this.max)).format('DD/MM/YYYY'));
									}
									if(error.length > 0) {
										this.errors.push(`Veuillez rentrer une date ${error.join(' et')}.`);
									}
								}
							}
						break;
						// SI ON EST EN MODE TELEPHONE
						case "phone" :
							if(this.model.length > 8 && this.model.length < 25 && !/([\d\ \-\_]|[\+]{0,1}|[\(]{0,1}|[\)]{0,1}){8,25}$/.test(this.model)){
								this.errors.push('Veuillez rentrer un numéro de téléphone valide.');
							}
						break;
					}
				}
			}
		}
	},
}
