<!DOCTYPE html>
<html>
<head>
	<title>Things to do</title>
	<meta charset="utf-8">
	<link rel="stylesheet" type="text/css" href="css.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
	<script src="jqui.js" type="text/javascript"></script>
</head>
<body>
	<header>
		<div id="container" class="login">
			<div id="formcontainer" class="loginform">
				<?php
					session_start();
					if (!isset($_SESSION['log'])){
						echo '
							<button id="login" class="login">Sign In</button>
							<div id="logintooltip" class="tooltip">
								<form id="loginform" name="loginform" class="loginform">
									<label>E-mail: <input id="loglog" class="login" type="text" name="login"></label>
									<label>Password: <input id="logpass" class="login" type="password" name="password"></label>
								<button class="regbtn" id="login">Sign In</button>
								
								</form>
								<span  class="close">&times;</span>
							</div>
							<button id="reg" class="login">Sign Up</button>
							<div id="regtooltip" class="tooltip">

								<form id="regform" name="regform" class="loginform">
								<label>E-mail: <input id="reglog" class="login" type="text" name="login"></label>
								<label>Password: <input id="regpass" class="login" type="password" name="password"></label>
								<button class="regbtn" id="login">Sign Up</button>
								
								</form>
								<span  class="close">&times;</span>
							</div>';
						}	
					else{
						echo '<a href="scripts/logout.php"><button class="btn">Logout</button></a>
								<a href="scripts/del.php"><button  class="btn">Delete account</button></a>';
					}			
					?>
		</div>

		<h1>Things to do:</h1>

	</header>
	<section>
		<div class="container">
			<ul id="list" class="list"> 
			
			</ul>
		</div>
		<div class="container pole">
				<form id="listform" class="list" name="list" action="#">
					<input id="todo" class='send' type="text" name="todo" autofocus="true" minlength="3">
					<button class="btn" id="submit">Add</button>
						
				</form>	
				<?php
						
						if(isset($_SESSION['log'])){

							echo  "<button id=synchro class='btn synchro'>Synchronize</button>";
						}	

					?>

				

		</div>
	</section>
	<script type="text/javascript">
		
		$(document).ready(function(){
		
		const list = document.getElementById('list');
		const list_collection = document.getElementsByClassName('list');
		const li = document.getElementsByTagName('li');	
		const submit = document.getElementById('submit');
		const tooltip = $('button.login');
		const buttons = $('.regbtn');
		
		var del = document.getElementsByClassName('del');
		var log = $('.synchro');
		var check = false;
		
	
		const ajax = [

		function(){
			$("#loginform").submit(function (event) {
    			event.preventDefault(); 
    			$.post(
   					 "scripts/login.php",
    				{
        				login: document.getElementById('loglog').value,
        				password: document.getElementById('logpass').value
    				},function(data){
        				if(data == 'true'){
        					document.getElementById('formcontainer').innerHTML = '<a href="scripts/logout.php"><button class="btn">Logout</button></a><a href="scripts/del.php"><button  class="btn">Delete account</button></a>';
        						log = true;
        						
        						location.reload();
        						
        						synchro  = document.getElementById('synchro');

        				}
        				else
        				{
        					let element = document.createElement('div');
    						let parent = document.getElementsByTagName('header')[0];
    						element.classList.add('info');
        					element.textContent = "Something was wrong. Please try again!";
        					parent.appendChild(element);
        					$(element).fadeIn('slow');
        						setTimeout(function(){
        							$(element).fadeOut('slow');
        							setTimeout(function(){
        								element.remove();	
        							},500);
        					},1200);	
        				}
    				}
				);
			});
		},
		function(){
			$("#regform").submit(function (event) {
    			event.preventDefault(); 
    			$.post(
   					 "scripts/reg.php",
    				{
        				login: document.getElementById('reglog').value,
        				password: document.getElementById('regpass').value
    				},function(data){
    					let element = document.createElement('div');
    					let parent = document.getElementsByTagName('header')[0];
    					element.classList.add('info');
        				if (data == 'true') {
        					
        					element.textContent = 'You are registered successfully! Please check your email and activate account!';
        					
        				}
        				else if(data =='false'){
        					element.textContent = 'Something was wrong. Please try again!';
        				}
        				parent.appendChild(element);
        				$(element).fadeIn('slow');
        				setTimeout(function(){
        					$(element).fadeOut('slow');
        					setTimeout(function(){
        						element.remove();	
        					},500);
        					
        				},1200);

    				}
				);
			});
		}];

		function synchronize(){

			var liArray = [];
			if (list_collection.length) {
			
				for (let i = 0; i< li.length; i++){
					liArray[i] = li[i].textContent;
					
				}

			$.post(
    			"scripts/synchronize.php",
    			{
       			 list: liArray
    			},
    			function(data){
    					
    				var base_array = [];
    				var li_array = [];	
    				cell_text = document.getElementsByClassName('cell');

        			let a = Object.keys(data).map(function(key) { return data[key] });
        			let b = document.getElementsByClassName('cell');
        			for (let i = 0; i<a.length;i++){
        				base_array[i] = a[i].noteText
        
        			}

        			for (let i = 0; i<cell_text.length;i++ ){
        				li_array[i] = cell_text[i].textContent;
        		
        			}
	  				
        			var diff = arr_diff(base_array,li_array)

	        	

        			for (let i = 0; i<a.length;i++){

        				createBody(diff[i]);
        				
        			
        			}
        		
    				
    				saveData();
    					
    			}	
				);
    				}
			}
		function arr_diff (a1, a2) {

    		var a = [], diff = [];

    		for (var i = 0; i < a1.length; i++) {
        		a[a1[i]] = true;
    		}

    		for (var i = 0; i < a2.length; i++) {
        		if (a[a2[i]]) {
            		delete a[a2[i]];
        		} else {
            	a[a2[i]] = true;
        		}
    		}

    		for (var k in a) {
        		diff.push(k);
    		}

    			return diff;
			}	



		function addData(value){
			
			if(value !=''){
			
				$.post(
    				"scripts/addData.php",
    				{
        				todo: value
    				});

			}

		}

		function deleteData(e){

			
			var delete_data = e.target.previousSibling.textContent;
		
			$.post(
    				"scripts/deleteData.php",
    				{
        				del: delete_data
    				});

		}

		function getData(text) {
			
			this.data = text;

		}

		function saveData(){

			var listArray = [];
			if (typeof li[0] != 'undefined') {
			
				for (let i = 0; i< li.length; i++){
					let reg = /\,/g;
					listArray[i] = li[i].textContent.replace(reg,'|');
					
				}
			
				localStorage.setItem('todo',listArray);			
			}
			
			else
			{	
			
				localStorage.clear();
			}
	
		}

		function loadData(){


			var retrievedObject = localStorage.getItem('todo');
			if (retrievedObject != null){
				let array = retrievedObject.split(",");
				
				
				for (let i = 0; i < array.length;i++){
					createBody(array,i);	

				}
			}
			else
				return;
		}

		function createBody(arg1,arg2){
				let row = document.createElement('li');	
				let leftcell = document.createElement('span');
				leftcell.classList.add('cell')
				let rightcell = document.createElement('img');
				rightcell.src = 'X.png';

				rightcell.classList.add('cell');
				rightcell.classList.add('del');
				
				

				if (typeof arg2 != 'undefined' ) {
					var reg = /\|/g;
					leftcell.textContent = arg1[arg2].replace(reg,',');
									}
				else{
					leftcell.textContent = arg1.replace(reg,',');
				
				}
		
				if (leftcell.textContent !=''){
					row.appendChild(leftcell);
					row.appendChild(rightcell);
					list.appendChild(row);	
					addEvent();
				}
		}
		function addEvent(){
			
			for (var i = 0; i<del.length;i++){
				del[i].addEventListener('click', deleteInfo);
				del[i].addEventListener('click', function(e){

					deleteData(e);
				})
		
			}	
		}



		function deleteInfo(){
			
			this.parentNode.remove();
			del = document.getElementsByClassName('del');
			
			saveData();
		}

		function addEventToBtns(){

			for (let i=0; i< buttons.length;i++){
				buttons[i].addEventListener('click', ajax[i]);
			}
			
		}
		

		
		
		function isDouble(input){

			var cell = document.getElementsByClassName('cell');
			
			if(typeof cell[0] == 'undefined'){

				check = true;
			}
			else{
				if (input.value.length <= 2){

					return false;
				}
				for (let i=0; i<cell.length;i++){

					if (input.value == cell[i].textContent) {
						
						return false;
					}
					else
					{
					
						check=true;
					}
				}
			}
			return check;
			
		}
		addEventToBtns();


		$("#listform").submit(function (event) {
    		event.preventDefault(); 
			submit.addEventListener('click', function (){
				let input = document.getElementById('todo');
				check = isDouble(input);
				if (check === true) {
					
					if (log.length){
						addData(input.value);
					}
					object = new getData(input.value);
					createBody(object.data);
				
				}
				input.value ='';
				saveData();
				check = false;
			},false);
		});
			

		

    	loadData();
	
		$('.synchro').click(function(){
			synchronize();
		});
	
		$(tooltip[0]).click(function(){
			
			$('#logintooltip').fadeIn('slow');
			$('#regtooltip').css('display','none');
			$('#logintooltip').css('display','flex');

		});
		$(tooltip[1]).click(function(){
			$('#regtooltip').fadeIn('slow');
			$('#logintooltip').css('display','none');
			$('#regtooltip').css('display','flex');
		});
		$('.close').click(function(){
			$(this.parentNode).fadeOut('slow');
		});
	});	
	</script>
</body>
</html>