<template>
	<main class="product-container">
		<article>
			<div class="carousel-container">
				<div class="carousel" :style="`transform: translate3d(-${activeSlide * 100 + activeSlide * 1}%, 0, 0);`">
					<img alt="Produit - Legend Age" src="/assets/images/product.png">
					<img alt="Avant Après - Legend Age" src="/assets/images/av_ap_portrait.jpg">
					<img alt="Baume - Legend Age" src="/assets/images/baume.jpg">
				</div>
				<ul class="dots">
					<li :class="{'actived' : activeSlide == 0}" @click="activeSlide = 0"></li>
					<li :class="{'actived' : activeSlide == 1}" @click="activeSlide = 1"></li>
					<li :class="{'actived' : activeSlide == 2}" @click="activeSlide = 2"></li>
				</ul>
			</div>
			<div>
				<h2>Soin des lèvres</h2>
				<div
					class="notation-container"
					v-if="moyenne != null"
				>
					<Notation
						:notation="parseFloat(moyenne)"
					/> &nbsp;<a href="#avis">({{avis.length}} avi{{avis.length > 1 ? "s" : ""}})</a>
				</div>
				<blockquote>Un baume à lèvre, mille couleurs !</blockquote>
				<div class="content-datas">
					<div class="infos">
						<p>Grâce à sa formule riche en <strong>cire d'abeille, vitamine E, huiles végétales et extrait des fraises des bois</strong>, ce baume <strong>prévient le dessèchement et gercement, hydrate et répare instantanément les lèvres, régénère la peau</strong>.</p>
						<p><strong>Coloration Thermosensible</strong> : En fonction du PH et la température des lèvres, il colorie les lèvres naturellement.</p>
						<p><strong><i>Excellente tenue !</i></strong></p>
						<p><strong>Poids</strong> : 3.8 grammes</p>
					</div>
					<Form
						:preventSend="true"
						@formSent="buyProduct"
					>
						<p id="price">
							<template v-if="isPromo !== null">
								<span id="normal-price">{{ normalPrice }} €</span>
								<span>{{ finalPrice }} €</span>
								<span v-if="isBlackFriday" id="promo">Black Friday</span>
								<span v-else id="promo">Promotion de Noël</span>
							</template>
							<template v-else>
								<span>{{ normalPrice }} €</span>
							</template>
							<!-- Prix toutes taxes comprises (TTC) -->
							<template v-if="!isBlackFriday">
								<br>Livraison offerte
							</template>
						</p>
						<Input
							type="number"
							label="Quantité"
							name="quantity"
							:min="1"
							:value="quantity"
							@change="quantity = $event"
						/>
						<Input
							v-if="false"
							type="checkbox"
							name="by-four"
							:required="false"
							:choices="[{
								value: 1,
								label: 'Achat par lots de 4 exemplaires',
							}]"
							@change="byFour = $event.length > 0">
							(<b>-15%</b> de réduction)
						</Input>
						<Button
							class="button-orange"
							type="submit"
						>Ajouter au panier</button>
					</Form>
				</div>
			</div>
		</article>
		<section id="composition">
			<ul>
				<li id="ingredients">
					<h3>Ingrédients</h3>
					<p><strong>Cire d’abeille, Vitamine E, Huile de noyaux de cerises</strong>, extrait de fraise de bois, Huile de ricin, Beurre de cacao, Lanoline, Alcool stéarylique, Cire de candelilla, Huile d’olive, Mica, Dioxyde de titane, Acide citrique, Methylparaben, Tartrazine.</p>
				</li>
				<li>
					<img src="/assets/images/cire-abeille.png" alt="Cire d'abeille - Legend Age">
					<h3>Cire d’abeille</h3>
					<p>Hydratante, nourrissante, apaisante et cicatrisante.</p>
				</li>
				<li>
					<img src="/assets/images/huile-cerise.png" alt="Huile de noyaux de cerises - Legend Age">
					<h3>Huile de noyaux de cerises</h3>
					<p>Huile cosmétique anti-rides par excellence. Elle prévient le vieillissement cutané.</p>
				</li>
				<li>
					<img src="/assets/images/vitamine-e.png" alt="Vitamine E - Legend Age">
					<h3>Vitamine E</h3>
					<p>Protège des radicaux libres, hydratante et antioxydante.</p>
				</li>
			</ul>
		</section>
		<section id="bienfaits">
			<h3>Les Bienfaits</h3>
			<p>Le savant mélange de tous ces ingrédients procure à ce baume à lèvres des <em>effets Anti-rides, antivieillissement de la peau, anti-oxydant</em>.<br>Il <em>ravive le teint, hydrate en profondeur, nourrit, régénère et adoucit la peau. Il protège également des UV et du froid</em>.</p>
			<p><em>Réparer 6 problèmes de lèvres :</em></p>
			<ol>
				<li order="1">
					<span>Des lèvres noircies</span>
				</li>
				<li order="2">
					<span>Rides des lèvres</span>
				</li>
				<li order="3">
					<span>Dessèchement</span>
				</li>
				<li order="4">
					<span>Gercement</span>
				</li>
				<li order="5">
					<span>Des lèvres blanchies</span>
				</li>
				<li order="6">
					<span>Tâches</span>
				</li>
			</ol>
		</section>
		<section id="conseil">
			<h3>Conseils d'utilisations</h3>
			<ul>
				<li>Pour une hydratation efficace, appliquer sur les lèvres, après chaque repas et avant le coucher.</li>
				<li>Sortir le baume d’1 cm maximum pour ne pas le fragiliser.</li>
				<li>Pour une couleur plus vive, appliquer plusieurs couches.</li>
				<li>Si le baume devient mou à cause de la chaleur, le laisser au réfrigérateur pendant 5 minutes avant l’application.</li>
				<li>A conserver de préférence à l’abri de la lumière, dans un endroit sec et frais.</li>
				<li>Cesser immédiatement d'utiliser le produit et consulter un dermatologue en présence de rougeurs ou en cas d'inconfort.</li>
			</ul>
		</section>
		<section id="avis" v-if="randomAvis && randomAvis.length > 0">
			<h3>Avis</h3>
			<ul>
				<li v-for="avis in randomAvis" :key="`avis-${avis.id}`">
					<Notation :notation="parseInt(avis.notation)" />
					<p>{{avis.message}}</p>
					<small>par <strong>{{ avis.firstname }} {{ avis.lastname }}</strong>, le {{ printDate(avis.created_date) }}</small>
				</li>
			</ul>
		</section>
		<Modal
			id="added-modal"
			:opened.sync="modalOpened"
		>
			<img alt="Produit - Legend Age" src="/assets/images/product.png">
			<div>
				<h3>Ce produit a été ajouté à votre panier !</h3>
				<table>
					<thead>
						<tr>
							<th>Soin des lèvres</th>
							<th>Total</th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td>{{quantity}} {{byFour ? `lot${quantity > 1 ? 's' : ''} de 4 exemplaires` : `exemplaire${quantity > 1 ? 's' : ''}`}}</td>
							<td>{{finalPrice}} €</td>
						</tr>
					</tbody>
				</table>
				<div class="buttons">
					<button class="back" @click="modalOpened = false">Poursuivre mes achats</button>
					<router-link :to="{name: 'basket'}">Voir le panier</router-link>
				</div>
			</div>
		</Modal>
	</main>
</template>

<script src="./Product.js"></script>
<style lang="scss">@import "./Product.scss";</style>