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
			<div class="card">
				<form id="form" method="post">
					<div class="card-content">
						<div class="row">
								<div class="col s12">
									<span class="card-title">Nova ordem de pagamento</span>
									<input type="hidden" v-model="sessionId">
								</div>
								<div class="input-field col s6">
									<input placeholder="Nome escrito no cartão" id="name" type="text" class="validate" v-model="name">
									<label for="name">Nome</label>
								</div>
								<div class="input-field col s6">
									<input placeholder="Número do cartão" id="number-card" type="text" class="validate" v-model="cardNumber">
									<label for="number-card">Número do cartão</label>
								</div>
								<div class="input-field col s12">
									<select>
										<option value="" disabled selected>Escolha o seu método de pagamento</option>
										<option value="1">Option 1</option>
										<option value="2">Option 2</option>
										<option value="3">Option 3</option>
									</select>
									<label>Método de pagamento</label>
								</div>

								{{ $data }}
						</div>
					</div>
					<div class="card-action">
						<a href="#" class="blue-text" @click="sndReq">Enviar</a>
					</div>
				</form>
			</div>
			<!-- <div id="v-app">
				<h1 v-bind:style="{color: txtColor}">{{msg}}</h1>
				<input type="text" id="msgText"  v-model="msg">
			</div> -->
		</div>
	</div>
</div>
<script>
	// var app = new Vue(
	// 	{
	// 		el: "#v-app",
	// 		data: {
	// 			msg: "New task",
	// 			txtColor: '#FF0000'
	// 		}
	// 	}
	// );

	$(document).ready(function() {
		$('select').material_select();
	});

	var form = new Vue(
		{
			el: "#form",
			data:
			{
				name: '',
				cardNumber: '',
				sessionId: '',
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
					Vue.http.options.emulateJSON = true;
					this.$http.post('transacao',
						{
							name: this.name,
							cardNumber: this.cardNumber,
						}
					).then(response => {
						response.status;
						response.statusText;
						response.headers.get('Expires');
						this.postData = response.body;
					}, response => {
					  // error callback
					});
				}
			},

			mounted: function()
			{
				this.getSessionId()
			}
		}
	);
</script>
