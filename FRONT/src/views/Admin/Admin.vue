<template>
	<main class="admin-container">
		<Login
			v-if="!isLoggedIn"
			@formSent="loggedIn"
		/>
		<template v-else-if="isReady">
			<table>
				<thead>
					<tr>
						<th>De</th>
						<th>Note</th>
						<th>Etat</th>
						<th>#</th>
					</tr>
				</thead>
				<tbody>
					<template v-if="comments.length > 0">
						<tr v-for="comment in comments">
							<td>{{comment.firstname}} {{comment.lastname}}</td>
							<td>
								<Notation :notation="parseInt(comment.notation)" />
							</td>
							<td class="state" v-if="comment.validated_date !== null">
								<span class="approved">Approuvé</span>
							</td>
							<td class="state" v-else>
								<span>En attente</span>
							</td>
							<td class="buttons">
								<Button
									class="button-orange"
									@click="editComment(comment.id)"
								>
									<span class="lnr-pencil"></span>
								</Button>
								<Button
									v-if="comment.validated_date === null"
									class="button-outline-orange"
									@click="approveComment(comment.id)"
								>
									<span class="lnr-thumbs-up"></span>
								</Button>
								<Button
									class="button-black"
									@click="archiveComment(comment.id)"
								>
									<span class="lnr-trash"></span>
								</Button>
							</td>
						</tr>
					</template>
					<tr v-else colspan="5">Aucun commentaire</tr>
				</tbody>
			</table>

			<Modal
				v-if="form !== null"
				:opened.sync="modalOpened"
				@modalClosed="form = null;"
			>
				<h2>Modifier un avis</h2>
				<Form
					:action="`/comment/${form.id}`"
					method="PUT"
					@formSent="loadComments(); modalOpened = false;"
				>
					<Input
						type="text"
						name="firstname"
						label="Prénom"
						:value="form.firstname"
					></Input>
					<Input
						type="text"
						name="lastname"
						label="Nom"
						:value="form.lastname"
					></Input>
					<Input
						type="textarea"
						name="message"
						label="Commentaire"
						:value="form.message"
					></Input>
					<label class="label">Note :</label>
					<Notation
						:notation="parseInt(form.notation)"
					/>
					<Input
						type="hidden"
						name="notation"
						:value="form.notation"
					></Input>
					<div class="buttons">
						<Button
							class="button-outline-black"
							@click="modalOpened = false"
						>Annuler</Button>
						<Button
							type="submit"
							class="button-orange"
						>Enregistrer</Button>
					</div>
				</Form>
			</Modal>
		</template>
	</main>
</template>

<style lang="scss">@import "./Admin.scss";</style>
<script src="./Admin.js"></script>