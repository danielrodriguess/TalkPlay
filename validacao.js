function validar(){
	if(document.cadastrar.nome.value == ""){
		alert("Por favor preencha o campo nome");
		document.cadastrar.nome.focus();
		return false;
	}
	else if(document.cadastrar.email.value == "" || document.cadastrar.email.value.indexOf('@') ==-1 || document.cadastrar.email.value.indexOf('.') ==-1){
		alert("Digite um e-mail válido");
		document.cadastrar.email.focus();
		return false;
	}
	else if(document.cadastrar.senha.value == "" || document.cadastrar.senha.value == "12345678" || document.cadastrar.senha.value == "012345678"){
		alert("Por favor defina uma senha/Sua senha é muito fraca");
		document.cadastrar.senha.focus();
		return false;
	}
	else if(document.cadastrar.senha1.value == ""){
		alert("Por favor confirme sua senha");
		document.cadastrar.senha1.focus();
		return false;
	}
	else if(document.cadastrar.data.value == ""){
		alert("Por favor coloque sua data de nascimento");
		document.cadastrar.data.focus();
		return false;
	}
	else if(document.cadastrar.opcao.value == ""){
		alert("Por favor escolha uma pergunta de segurança");
		document.cadastrar.opcao.focus();
		return false;
	}
	else if(document.cadastrar.resposta.value == ""){
		alert("Por favor defina uma resposta para sua pergunta");
		document.cadastrar.resposta.focus();
		return false;
	}else{
		if(document.cadastrar.senha.value.length < 8){
			alert("A senha deve conter no mínimo oito caracteres");
			document.cadastrar.senha.focus();
			return false;
		}
		else if(document.cadastrar.senha.value.length > 12){
			alert("A senha não pode conter mais de doze caracteres");
			document.cadastrar.senha.focus();
			return false;
		}
		else if(document.cadastrar.senha.value != document.cadastrar.senha1.value){
			alert("Senhas não conferem");
			document.cadastrar.senha.focus();
			return false;
		}
	}
}