<style>
	nav {
		box-shadow: none !important;
	}
	body {
		background-color: #EFEFEF;
	}
</style>
<nav>
	<div class="nav-wrapper red accent-3">
		<span style="padding-left: 20px;">Task simple app</span>
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
								</div>
								<div class="input-field col s6">
									<input placeholder="Nome escrito no cartão" id="name" type="text" class="validate">
									<label for="name">Nome</label>
								</div>
								<div class="input-field col s6">
									<input placeholder="Número do cartão" id="number-card" type="text" class="validate" v-model="cardNumber">
									<label for="number-card">Número do cartão</label>
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
	//Vue.http.options.emulateJSON = true; // send as
	var form = new Vue(
		{
			el: "#form",
			data:
			{
				cardNumber: '',
				ajaxRequest: false,
				postData: [],
			},
			methods:
			{
				sndReq: function()
				{
					this.ajaxRequest = true;
					this.$http.post('transacao', {
						cardNumber: this.cardNumber
					}, function (data, status, request) {
						this.postData = data;
						this.ajaxRequest = false;
					});
				}
			}
		}
	);
</script>
