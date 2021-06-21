<!DOCTYPE html>
<html lang="en">
<?php include "menu.php"; ?>
<form>

			<input type="radio" name="fancy" autofocus value="start" id="start" />
			<input type="radio" name="fancy" value="article1" id="article1" />
			<input type="radio" name="fancy" value="article2" id="article2" />
			<input type="radio" name="fancy" value="article3" id="article3" />			
            <label for="article1"><img src="image_mignone1.png" alt="Product"></label>
            <label for="article2"><img src="bague1.png" alt="Product"></label>
            <label for="article3"> <img src="collier1.png" alt="Product"></label>
			<label for="article3"> <img src="lunette1.png" alt="Product"></label>
			

			<div class="keys">Naviguez avec les flèches du clavier</div>
	</form>
</body>
</html>

<style>
    * {
	box-sizing: border-box;
}

body {
	font-family: sans-serif;
	overflow: hidden;
}


form {
	position: absolute;
	
	white-space: nowrap;
}
input {
	position: absolute; 
   width: 0;
}

.keys {
	position: fixed;
	z-index: 10;
	bottom: 0;
	left: 0;
	right: 0;
	padding: 1rem;
	color: black;
	text-align: center;
	transition: all 300ms linear;
	opacity: 0;
}

input:focus ~ .keys {
	opacity: 0.8;
}

input:nth-of-type(1):checked ~ label:nth-of-type(1), 
input:nth-of-type(2):checked ~ label:nth-of-type(2),
input:nth-of-type(3):checked ~ label:nth-of-type(3),
input:nth-of-type(4):checked ~ label:nth-of-type(4){
   z-index: 0;
}

input:nth-of-type(1):checked ~ label {
	transform: translate3d(0, 0, 0);
}

input:nth-of-type(2):checked ~ label {
	transform: translate3d(-100%, 0, 0);
}

input:nth-of-type(3):checked ~ label {
	transform: translate3d(-200%, 0, 0);
}

input:nth-of-type(4):checked ~ label {
	transform: translate3d(-300%, 0, 0);
}

label {
	font-size: 3rem;
    color: black;
	transition: transform 400ms ease-out;
	display: inline-block;
     min-height: 100%;
	width: 100vw;
	height: 100vh;
	position: relative;
	z-index: 1;
	text-align: center;
	line-height: 100vh;
}

label img{
    width: 100%;
    height: 100%;
}


label:before,
label:after {
	color: black;
	display: block;
	background: rgba(255,255,255,0.2);
	position: absolute;
	padding: 1rem;
	font-size: 3rem;
	height: 10rem;
	line-height: 10rem;
	top: 50%;
	transform: translate3d(0, -50%, 0);
	cursor: pointer;
}

label:before {
	content: "\276D";
	right: 100%;
	border-top-left-radius: 50%;
	border-bottom-left-radius: 50%;
}

label:after {
	content: "\276C";
	left: 100%;
	border-top-right-radius: 50%;
	border-bottom-right-radius: 50%;
}



</style>
