<template>
	<main class="product-container">
		<article>
			<img alt="Produit - Legend Age" src="/assets/images/product.png">
			<div>
				<h2>Soin des lèvres</h2>
				<blockquote>Un baume à lèvre, mille couleurs !</blockquote>
				<p>Grâce à sa formule riche en <strong>cire d'abeille, vitamine E, huiles végétales et extrait des fraises des bois</strong>, ce baume <strong>prévient le dessèchement et gercement, hydrate et répare instantanément les lèvres, régénère la peau</strong>.</p>
				<p><strong>Coloration Thermosensible</strong> : En fonction du PH et la température des lèvres, il colorie les lèvres naturellement.</p>
				<p><strong><i>Excellente tenue !</i></strong></p>
				<p><strong>Poids</strong> : 3.8 grammes</p>
				<Form
					:preventSend="true"
					@formSent="buyProduct"
				>
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
					<p :id="promo !== null ? 'normal-price' : 'price'"><span>{{ promo !== null ? normalPrice : finalPrice }} €</span> {{promo !== null ? '' : 'Prix toutes taxes comprises (TTC)'}}</p>
					<template v-if="promo !== null">
						<p id="price">Promotion de Noël : <span>{{ finalPrice }} €</span> Prix toutes taxes comprises (TTC)</p>
					</template>
					<Button
						class="button-orange"
						type="submit"
					>Acheter</button>
				</Form>
			</div>
		</article>
		<section id="composition">
			<h3>Composition</h3>
			<ul>
				<li>
					<img src="/assets/images/cire-abeille.png" alt="Cire d'abeille - Legend Age">
					<h4>Cire d’abeille</h4>
					<p>Hydratante, nourrissante, apaisante et cicatrisante.</p>
				</li>
				<li>
					<img src="/assets/images/huile-cerise.png" alt="Huile de noyaux de cerises - Legend Age">
					<h4>Huile de noyaux de cerises</h4>
					<p>Huile cosmétique anti-rides par excellence. Elle prévient le vieillissement cutané.</p>
				</li>
				<li>
					<img src="/assets/images/vitamine-e.png" alt="Vitamine E - Legend Age">
					<h4>Vitamine E</h4>
					<p>Protège des radicaux libres, hydratante et antioxydante.</p>
				</li>
				<li id="ingredients">
					<h4>Ingrédients</h4>
					<p><strong>Cire d’abeille, Vitamine E, Huile de noyaux de cerises</strong>, extrait de fraise de bois, Huile de ricin, Beurre de cacao, Lanoline, Alcool stéarylique, Cire de candelilla, Huile d’olive, Mica, Dioxyde de titane, Acide citrique, Methylparaben, Tartrazine.</p>
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
				<li>Appliquer sur les lèvres après nettoyage, minimum 4 fois par jours, après chaque repas et avant le couché.</li>
				<li>Sortir seulement 1cm de baume, pour ne pas fragiliser le baume.</li>
				<li>Si souhaiter avoir une couleur plus vive, appliquer plusieurs couches.</li>
				<li>Si le soin à lèvres devient mou à cause de la chaleur, laisser le baume au réfrigérateur pendant 5mins avant l’application.</li>
				<li>Tenir à l'écart de la lumière directe du soleil, à l’abri de la lumière, dans un endroit sec et frais.</li>
				<li>Cesser immédiatement d'utiliser le produit et consulter un dermatologue en présence de rougeurs ou en cas d'inconfort.</li>
				<li>Mettre le baume debout, logo vers le haut.</li>
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