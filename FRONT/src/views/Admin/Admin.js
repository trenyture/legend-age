import moment from "moment";
import { mapGetters } from "vuex";

import Notation from "@/components/Notation/Notation.vue";
import Modal from "@/components/Modal/Modal.vue";
import Form from "@/components/Form/Form.vue";
import Input from "@/components/Input/Input.vue";
import Button from "@/components/Button/Button.vue";

import Login from "./Login/Login.vue";

export default {
	components: { Login, Notation, Form, Input, Button, Modal },
	props: {
	},
	data() {
		return {
			form: null,
			comments: null,
			modalOpened: false,
		};
	},
	computed: {
		...mapGetters({
			isLoggedIn: 'isLoggedIn',
		}),
		isReady() {
			return this.comments   !== null;
		}
	},
	watch: {
		isReady: {
			deep: true, 
			immediate: true,
			handler(n ,o) {
				if(typeof o === "undefined") {
					this.loadComments();
				}
			}
		}
	},
	methods: {
		loggedIn(r) {
			if(r.user && r.user.user_id) {
				this.$store.dispatch("isLoggedIn", r.user.user_id).then(() => {
					this.$store.dispatch("setSuperAdmin", r.user).then(() => {
						this.$alert.swal({
							type: "success",
							title: "Connecté",
							message: "Vous êtes maintenant connecté",
							timer: 2,
						})
					});
				});
			}
		},
		loadComments() {
			this.$ajax({
				url: '/comment?validated=null',
				success: r => {
					this.comments = r;
				}
			})
		},
		editComment(commentId) {
			this.$ajax({
				url: `/comment/${commentId}/?validated=null`,
				success: r => {
					if(r && r.length > 0) {
						this.form = r[0];
						this.modalOpened = true;
					}
					else {
						this.loadComments();
					}
				}
			})
		},
		approveComment(commentId) {
			this.$ajax({
				url: `/comment/${commentId}`,
				method: 'PUT',
				data: {
					validated_date: new moment(new Date()).format('YYYY-MM-DD HH:mm:ss'),
				},
				success: r => {
					this.loadComments();
				}
			})
		},
		archiveComment(commentId) {
			this.$alert.swal({
				type: 'warning',
				title: 'Attention',
				message: "Cette action est irréversible, êtes-vous sûr de vouloir supprimer cet avis ?",
				cancel: "Annuler",
				confirm: "Supprimer",
				callback: r => {
					if(r.value) {
						this.$ajax({
							url: `/comment/${commentId}`,
							method: 'DELETE',
							success: r => {
								this.loadComments();
							}
						})
					}
				}
			})
		},
	},
}