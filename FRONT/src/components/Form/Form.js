//Renvoie tous les enfants qui sont des inputs
function returnChildrenInputs(children) {
	let inputs = [];
	//Pour chaque enfant trouvé
	for(var i = 0, len = children.length; i < len; i++){
		//Si c'est un input et qu'il n'est pas disabled on le garde en mémoire 
		if(children[i].canSend && !children[i].disabled) {
			inputs.push(children[i]);
		}
		//Sinon on va voir si parmi les enfants il y a d'autres inputs
		else {
			let inps = returnChildrenInputs(children[i].$children);
			if(inps.length > 0) {
				inputs = [...inputs, ...inps];
			}
		}
	}
	return inputs;
}

export default {
	props: {
		disabled: {
			type: Boolean,
			default: false,
		},
		action: {
			type: String,
		},
		method: {
			type: String,
			default: 'GET',
			validator: value => {
				return ['GET', 'POST', 'PUT', 'PATCH', 'DELETE'].includes(value);
			}
		},
		preventSend: {
			type: Boolean,
			default: false,
		},
	},
	data() {
		return {
			isDisabled: null,
		};
	},
	computed: {
		isReady() {
			return this.isDisabled != null;
		}
	},
	watch: {
		disabled:{
			immediate: true,
			handler(nVal, oVal) {
				this.isDisabled = nVal 
			}
		}
	},
	methods: {
		submit(event) {
			event.stopImmediatePropagation();
			event.preventDefault();

			this.isDisabled = true;

			let errors = [];
			//On va chercher les inputs enfants du Form
			let inputs = returnChildrenInputs(this.$children);

			//Puis on va créer notre FormData
			var fd = new FormData();
			for(var i = 0, len = inputs.length; i < len; i++) {
				inputs[i].checkValidity();
				if(inputs[i].errors.length > 0) {
					errors = [...errors, ...inputs[i].errors.map(e => { return inputs[i].label + " : " + e; })];
				}
				else {
					//SI ON EST SUR UN INPUT DE TYPE FILE
					if(inputs[i].type === 'file') {
						for(let j = 0, leng = inputs[i].model.length; j < leng; j++) {
							fd.append(inputs[i].name, inputs[i].model[j], inputs[i].model[j].name);
						}
						fd.append('json-' + inputs[i].name, JSON.stringify(inputs[i].model.map(e => { return {filename: e.name, asset: e.assetId || null}; })));
					}
					//SINON ON REGARDE SI LE MODELE EST UN TABLEAU
					else if(inputs[i].model instanceof Array){
						for(let j = 0, count = inputs[i].model.length; j < count; j++){
							fd.append(inputs[i].name, inputs[i].model[j] != null ? inputs[i].model[j] : '');
						}
					}
					//SINON ON EST SUR UN INPUT A VALEUR UNIQUE
					else {
						fd.append(inputs[i].name, inputs[i].model);
					}
				}
			}
			if(errors.length > 0) {
				let error = new Error("Problème de formulaire");
				error.details = errors;
				this.$error(error);
				this.isDisabled = false;
			}
			else {
				if(this.preventSend) {
					this.$emit('formSent');
					this.isDisabled = false;
				}
				else {
					this.$ajax({
						url: this.action,
						method: this.method,
						data: fd,
						success: resp => {
							this.$emit('formSent', resp);
						},
						always: () => {
							this.isDisabled = false;
						}
					});
				}
			}

			return false;
		}
	},
}