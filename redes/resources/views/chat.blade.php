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
			/*font-family: Helvetica;*/
			font-family: 'Catamaran';
			color: #fff;
			font-size: 12px;
		}
		p {
			margin: 0px;
		}

		#conteiner {
			position: absolute;
			width: 800px;
			height: 800px;
			z-index: 15;
			top: 50%;
			left: 50%;
			margin: -400px 0 0 -350px;
		}
		#top {
			height: 100px;
			background-color: #F4F4F4;
		}
		#left {
			height: 95%;
			width: 510px;
			background-color: #878787;
			float: left;
			margin-bottom: -100px;
			padding: 3px;
		}
		#right {
			width: 270px;
			display:block;
			background-color: #323232;
			height: 95%;
			margin-bottom: -100px;
			float:right;
			padding: 3px;
		}
		#bot {
			clear: right;
			background-color: #DCDCDC;
			position:absolute;
			bottom:0;
			width:100%;
			z-index: 100;
			margin-bottom: 0px;
		}

		#message {
			width: 99%;
		}

	</style>
</head>
<body>

	<div id="conteiner">
		<div id="left" style="overflow:scroll; height:95%;">
			<meta name="_token" content="{{ csrf_token() }}" />            
			{!! Form::open(['url'=>'messagesend','id'=>'chat'])!!}
			<div class="div2" id="div2">
				<h2>Mensagens:</h2><br/>
			</div>
		</div>

		<div id="right" style="overflow:scroll; height:95%;">
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
				// checkedValue = $("input[name='user']:checked").val();
				$.each(JSON.parse(result), function (key, data) {
					$("#div2").append(data);	 
					// $("#"+checkedValue).attr('checked', 'checked');
				});
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
							console.log(data);
							$("input[name='message']").val('')
						},
						error: function(data){
							console.log('Erro!');
							$("input[name='message']").val('')
						}
					})
				}
			});
		});


	</script>


</body>