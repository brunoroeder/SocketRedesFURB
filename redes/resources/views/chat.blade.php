<!doctype html>
<html>
<head>
	<title>LARC :: FURB :: Chat</title>

	<meta charset="UTF-8">
	<link href="https://fonts.googleapis.com/css?family=Catamaran:100" rel="stylesheet" type="text/css">

	<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
	<style>


		body, html {
			height: 100%;
		}
		body {
			margin: 0px;
			font-family: 'Catamaran';
			color: #fff;
			font-size: 13px;
		}
		p {
			margin: 0px;
		}

		#conteiner {
			position: absolute;
			width: 800px;
			height: 550px;
			z-index: 15;
			top: 50%;
			left: 50%;
			margin: -400px 0 0 -350px;
		}
		#top {
			height: 100px;
			background-color: #fff;
		}
		#left {
			height: 93%;
			width: 510px;
			background-color: #878787;
			float: left;
			margin-bottom: -100px;
			padding: 3px;
			overflow-y: scroll;
			overflow-x: hidden;
		}
		#right {
			width: 270px;
			display:block;
			background-color: #323232;
			height: 93%;
			margin-bottom: -100px;
			float:right;
			padding: 3px;
			overflow-y: scroll;
			overflow-x: hidden;
		}
		#bot {
			clear: right;
			background-color: #fff;
			position:absolute;
			bottom:0;
			width:800px;
			z-index: 100;
			margin-bottom: 0px;
		}

		#message {
			width: 99%;
		}

		a {
		    color: #fff;
		}

		input[type="text"] {
			padding: 6px;
			border: solid 1px #dcdcdc;
			transition: box-shadow 0.3s, border 0.3s;
		}

	</style>
</head>
<body>

	<div id="top"></div>
	<div id="conteiner">
		<div id="left">
			<meta name="_token" content="{{ csrf_token() }}" />            
			{!! Form::open(['url'=>'messagesend','id'=>'chat'])!!}
			<div class="div2" id="div2">
				<h2>Mensagens:</h2><br/>
			</div>
		</div>

		<div id="right">
		<div style="float: right; color: #fff;"><a href="logout">logout</a></div>
			<h2>Usuários online</h2> 
			<div class="div1" id="div1"></div>
		</div>
		<div id="bot">
			{!! Form::text('message', null, ['id' => 'message', 'placeholder' => 'Escreva sua mensagem', 'autocomplete' => 'off'])!!}
			{!! Form::hidden('user', null, ['id' => 'user'])!!}
		</div>
	</div>

	{!! Form::close() !!}

	<script type="text/javascript">
		function listusers(){
			$.ajax({url: "listusers/", success: function(result){
				setTimeout(function(){
					listusers();
				}, 5000);
				checkedValue = $("input[name='userid']:checked").val();
				$("#div1").empty();
				$.each(JSON.parse(result), function (key, data) {
					$("#div1").append(data);	 
					$("#"+checkedValue).attr('checked', 'checked');
					$("#user").attr('value', checkedValue);
				});
			}});
		}

		listusers();

		function messageList(){
			$.ajax({url: "messagelist/", success: function(result){
				setTimeout(function(){
					messageList();
				}, 1000);
			
				message = JSON.parse(result);
				if(message != "")
				{
					var username = $("input[id='username-"+ message[0]+"']").val();
					if(username != null){
						message[0] = $("input[id='username-"+ message[0]+"']").val();
					}else{
						//usuarios offlines nao consigo pegar o nome, visto que o socket nao possui uma listagem de todos os usuarios, apenas dos online
						message[0] = message[0] + ' Offline';
					}
					$("#div2").append(message);	 
				}
			}});
		}

		messageList();

		$(function(){
			$('#chat').on('submit',function(e){
				$.ajaxSetup({
					header:$('meta[name="_token"]').attr('content')
				})
				e.preventDefault(e);
				checkedValue = $("input[name='userid']:checked").val();
				$("#user").attr('value', checkedValue);
				user = $("input[name='user']").val();
				if(user ==  '')
				{
					alert("Selecione algum usuário online para enviar a mensagem");

				}else{
					$.ajax({
						type:"POST",
						url:'/messagesend',
						data:$(this).serialize(),
						dataType: 'json',
						success: function(data){
							$("#div2").append($("input[name='message']").val());
							$("input[name='message']").val('');
						},
						error: function(data){
							$("#div2").append("Eu: " + $("input[name='message']").val() + "<br/>")
							$("input[name='message']").val('')
						}
					})
				}
			});
		});


	</script>


</body>