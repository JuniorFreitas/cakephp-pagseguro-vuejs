<style>
	nav {
		box-shadow: none !important;
	}
	body {
		background-color: #EFEFEF;
	}
   .input-field label {
     color: #29b6f6;
   }
   /* label focus color */
   .input-field input[type=text]:focus + label {
     color: #29b6f6;
   }
   /* label underline focus color */
   .input-field input[type=text]:focus {
     border-bottom: 1px solid #29b6f6;
     box-shadow: 0 1px 0 0 #29b6f6;
   }
   /* valid color */
   .input-field input[type=text].valid {
     border-bottom: 1px solid #29b6f6;
     box-shadow: 0 1px 0 0 #29b6f6;
   }
   /* invalid color */
   .input-field input[type=text].invalid {
     border-bottom: 1px solid #29b6f6;
     box-shadow: 0 1px 0 0 #29b6f6;
   }
   /* icon prefix focus color */
   .input-field .prefix.active {
     color: #29b6f6;
   }
</style>
<nav>
	<div class="nav-wrapper cyan lighten-1">
		<span style="padding-left: 20px;">Integração com pagamento transparente do pagseguro</span>
		<ul id="nav-mobile" class="right hide-on-med-and-down">
			<li><a href="sass.html">Sass</a></li>
			<li><a href="badges.html">Components</a></li>
			<li><a href="collapsible.html">JavaScript</a></li>
		</ul>
	</div>
</nav>
<div class="container" style="padding-top: 30px;">
	<div class="row">
		<div class="col s12">
			<form id="form" method="post">
				<h5 class="light-blue-text"><i class="tiny material-icons">shopping_basket</i> Nova ordem de pagamento</h5>
				<div class="card z-depth-0">
					<div class="card-content">
						<div class="row">
							<div class="col s12">
								<span class="card-title"> Informações sobre o produto</span>
							</div>
							<div class="col s1">
								<img v-bind:src="product[0].image" width="80" height="80" class="circle">
							</div>
							<div class="col s10">
								<p>{{product[0].name}}</p>
							</div>
						</div>
					</div>
				</div>
				<div class="card z-depth-0">
					<div class="card-content">
						<div class="row">
								<div class="col s12">
									<span class="card-title">Informações pessoais</span>
								</div>
								<div class="input-field col s3">
									<input placeholder="Ex: Renan Nogueira" id="userName" type="text" class="validate" v-model="userName">
									<label for="userName">Nome Completo</label>
								</div>
								<div class="input-field col s3">
									<input placeholder="CPF" id="cpf" type="text" class="validate" v-model="cpf">
									<label for="cpf">CPF</label>
								</div>
								<div class="input-field col s3">
									<input placeholder="Ex: renan.nogueira@solutudo.com.br" id="email" type="email" class="validate" v-model="email">
									<label for="email">Seu email</label>
								</div>
								<div class="input-field col s3">
									<input placeholder="99999 9999" id="phone" type="text" class="validate" v-model="phone">
									<label for="phone">Telefone</label>
								</div>
								<div class="col s12">
									<span class="card-title">Endereço</span>
								</div>
								<div class="input-field col s2">
									<input placeholder="Ex: 18606201" id="cep" type="text" class="validate" v-model="cep">
									<label for="cep">CEP</label>
								</div>
								<div class="input-field col s3">
									<input placeholder="Ex: Vila Assumpção" id="district" type="text" class="validate" v-model="district">
									<label for="district">Bairro</label>
								</div>
								<div class="input-field col s6">
									<input placeholder="Ex: Rua Amando de Barros" id="address" type="text" class="validate" v-model="address">
									<label for="address">Endereço</label>
								</div>
								<div class="input-field col s1">
									<input placeholder="Ex: 132" id="addressNumber" type="number" class="validate" v-model="addressNumber">
									<label for="addressNumber">Número</label>
								</div>
								<div class="input-field col s3">
									<input placeholder="Ex: Casa, Sobrado, Condominio" id="complement" type="text" class="validate" v-model="complement">
									<label for="complement">Complemento</label>
								</div>
								<div class="input-field col s3">
									<input placeholder="Ex: Botucatu" id="city" type="text" class="validate" v-model="city">
									<label for="number-card">Cidade</label>
								</div>
								<div class="input-field col s1">
									<input placeholder="Ex: SP" id="state" type="text" class="validate" v-model="state">
									<label for="number-card">Estado</label>
								</div>
						</div>
					</div>
					<!-- <pre>{{ $data | json }}</pre>	 -->
				</div>
				<div class="card z-depth-0">
					<div class="card-content">
						<div class="row">

							<div class="col s12">
								<span class="card-title">Pagamento</span>
							</div>
							<div class="input-field col s4">
								<input placeholder="Nome escrito no cartão" id="crdName" type="text" class="validate" v-model="crdName">
								<label for="crdName">Nome</label>
							</div>
							<div class="input-field col s4">
								<input placeholder="Número do cartão"  @blur="getCardToken" id="crdNumber" type="text" class="validate" v-model="crdNumber" @keyup="getCrdBrand">
								<label for="crdNumber">Número do cartão</label>
							</div>
							<div class="input-field col s1">
								<input placeholder="" id="crdExpMonth" @blur="getCardToken" type="text" class="validate" v-model="crdExpMonth">
								<label for="crdExpMonth">Mês de expiração</label>
							</div>
							<div class="input-field col s1">
								<input placeholder="" id="crdExpYear" @blur="getCardToken" type="text" class="validate" v-model="crdExpYear">
								<label for="crdExpYear">Ano de expiração</label>
							</div>
							<div class="input-field col s2">
								<input placeholder="Ex: 622" id="crdSecurity" @blur="getCardToken" type="text" class="validate" v-model="crdSecurity">
								<label for="crdSecurity">Código de segurança</label>
							</div>

						</div>
					</div>
					<div class="card-action">
						<a href="#" class="blue-text" @click="sndReq">Enviar</a>
					</div>
					<pre>{{ $data }}</pre>
				</div>
			</form>
			<!-- <div id="v-app">
				<h1 v-bind:style="{color: txtColor}">{{msg}}</h1>
				<input type="text" id="msgText"  v-model="msg">
			</div> -->
		</div>
	</div>
</div>
<script>
	var form = new Vue(
		{
			el: "#form",
			data:
			{
				sessionId: '',
				userHash: '',
				userName: '',
				cpf: '',
				email: '',
				phone: '',
				cep: '',
				district: '',
				address: '',
				addressNumber: '',
				complement: '',
				city: '',
				state: '',
				crdBrand: '',
				crdName: '',
				crdNumber: '',
				crdExpiration: '',
				crdSecurity: '',
				crdExpMonth: '',
				crdExpYear: '',
				crdToken: '',
				product:
				[
					{
						'id': '01',
						'image': 'https://http2.mlstatic.com/boneco-do-fofo-anjo-brinquedos-D_NQ_NP_692421-MLB20759434263_062016-F.jpg',
						'name': 'Boneco Fofão',
						'pricePerUnity': 52.00,
						'quantity': 25,

					}
				]
			},
			methods:
			{
				getSessionId: function()
				{
					this.$http.get('session').then(response => {
						this.sessionId = response.body;
						this.getPayments();
					});
				},
				getCrdBrand: function()
				{

					if (this.crdNumber.length < 5) {
						this.crdBrand = '';
						return;
					}
					PagSeguroDirectPayment.getBrand({
						cardBin: this.crdNumber,
						success: function(response) {
							this.crdBrand = response.brand.name;
						}.bind(this),
						error: function(response) {
							this.crdBrand = '';
						}.bind(this)
					});
				},
				getCardToken: function()
				{
					if (this.crdNumber && this.crdSecurity && this.crdExpMonth && this.crdExpYear) {
						var params = {
							cardNumber: this.crdNumber,
							cvv: this.crdSecurity,
							expirationMonth: this.crdExpMonth,
							expirationYear: this.crdExpYear,
							success: function(response) {
								this.crdToken = response.card.token;
								console.log(response);
							}.bind(this),
							error: function(response) {
								console.log(response);
								//tratamento do erro
							}.bind(this),
							complete: function(response) {
								//tratamento comum para todas chamadas
							}
						}
						PagSeguroDirectPayment.createCardToken(params);
					}

				},
				getUserHash: function()
				{
					this.userHash = PagSeguroDirectPayment.getSenderHash();
				},
				getPayments: function()
				{
					PagSeguroDirectPayment.setSessionId(this.sessionId);
					PagSeguroDirectPayment.getPaymentMethods({
						amount: 500.00,
						success: function(response) {
							//meios de pagamento disponíveis
							console.log(response);
						},
						error: function(response) {
							//tratamento do erro
							console.log(response);
						},
						complete: function(response) {
							console.log(response);
							//tratamento comum para todas chamadas
						}
					});
				},
				sndReq: function()
				{
					this.getUserHash();
					Vue.http.options.emulateJSON = true;
					this.$http.post('transacao',
						{
							sessionId: this.sessionId,
							userHash: this.userHash,
							userName: this.userName,
							cpf: this.cpf,
							email: this.email,
							phone: this.phone,
							cep: this.cep,
							district: this.district,
							address: this.address,
							addressNumber: this.addressNumber,
							complement: this.complement,
							city: this.city,
							state: this.state,
							crdBrand: this.crdBrand,
							crdName: this.crdName,
							crdNumber: this.crdNumber,
							crdExpiration: this.crdExpiration,
							crdSecurity: this.crdSecurity,
							crdExpMonth: this.crdExpMonth,
							crdExpYear: this.crdExpYear,
							crdToken: this.crdToken,
							product: this.product,
						}
					).then(response => {
						response.status;
						response.statusText;
						response.headers.get('Expires');
						console.log(response.body);
						//this.postData = response.body;
					}, response => {
					  // error callback
					});
				}
			},

			mounted: function()
			{
				this.getSessionId(),
				$('select').material_select()
			}
		}
	);
</script>
