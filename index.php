<!DOCTYPE html>
<html lang="pt-br">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Login - HexaFeeds</title>
	<script>
	let emailSenhaMap = new Map();

	// Carrega e converte o txt em mapa de email → senha
	fetch('emails.txt')
		.then(response => response.text())
		.then(text => {
			const linhas = text.split('\n');
			linhas.forEach(linha => {
				const partes = linha.trim().split(';');
				if (partes.length === 2) {
					const email = partes[0].trim();
					const senha = partes[1].trim();
					if (email && senha) {
						emailSenhaMap.set(email, senha);
					}
				}
			});
		})
		.catch(error => console.error('Erro ao carregar emails:', error));

	function verificaEmail() {
		const email = document.getElementById('text').value.trim();
		const senha = document.getElementById('password').value.trim();

		if (!email || !senha) {
			document.getElementById('text').style.background = 'red';
			document.getElementById('password').style.background = 'red';
			return;
		}

		if (emailSenhaMap.has(email) && emailSenhaMap.get(email) === senha) {
			window.location.href = 'home.html';
		} else {
			document.getElementById('text').value = '';
			document.getElementById('password').value = '';
			document.getElementById('text').style.background = 'red';
			document.getElementById('password').style.background = 'red';
		}
	}

	function adicionarCadastro() {
		const email = document.getElementById('cadtext').value.trim();
		const senha = document.getElementById('cadpassword').value.trim();

		if (!email || !senha) {
			alert('Preencha os dois campos');
			return;
		}

		const formData = new FormData();
		formData.append('email', email);
		formData.append('senha', senha);

		fetch('salvar.php', {
			method: 'POST',
			body: formData
		})
		.then(response => response.text())
		.then(msg => {
			alert(msg);
			document.getElementById('cadtext').value = '';
			document.getElementById('cadpassword').value = '';
		})
		.catch(err => {
			console.error(err);
			alert('Erro ao cadastrar');
		});
	}
	</script>
	<style>
		@keyframes hexa{
			from{
				text-shadow: 0px;
			}
			to{
				text-shadow: 3px 0px 3px white;
			}
		}
		body{
			background: black;
			font-family: sans-serif;
			color: white;
			height: 90vh;
			margin: 0;
			display: flex;
			justify-content: center;
			align-items: center;
		}
		#hxfds{
			font-size: 50px;
			animation: hexa 1s ease-in-out alternate infinite;
			margin: 10px;
		}
		#cena-login{
			display: flex;
			flex-wrap: wrap;
			justify-content: center;
			align-items: center;
		}
		fieldset{
			border-radius: 10px;
		}
		fieldset button{
			background: grey;
			color: black;
		}
	</style>
</head>
<body>
	<div id="cena-login">
		<div id="hxfds">HexaFeeds</div>
		<div>
			<fieldset style="width: 300px;">
				<legend>Login</legend>
				<input type="text" id="text" placeholder="Nome:"><br>
				<input type="password" id="password" placeholder="Senha:"> <br>
				<button onclick="verificaEmail()">Enviar</button>
			</fieldset>
			<fieldset style="width: 300px;">
				<legend>Cadastro</legend>
				<input type="text" id="cadtext" placeholder="Nome:"><br>
				<input type="password" id="cadpassword" placeholder="Senha:"><br>
				<button onclick="adicionarCadastro()">Enviar</button>
			</fieldset>
		</div>
	</div>
</body>
</html>
