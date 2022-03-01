<html>
<head><title> result page </title>

<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

		<style>
			.result
			{
				margin-left:10%;margin-right:25%;margin-top:12px;
			}
			.form-control{
				-webkit-border-radius: 50px;
				-moz-border-radius: 50px;
				border-radius: 50px;
				background: url("img/sicon.jpg") top left     no-repeat;
				height:30px;
				padding-left:25px;
			}
			.form-control:hover{
			 -webkit-box-shadow: 3px 6px 7px -3px #ccc;
			}
			.row{
				border-bottom: 0.5px solid #DCDCDC;
			}
			.input-group{
				margin-bottom:8px;
				margin-top:12px;
			}
		</style>
</head>

 <body style="width: 100%; height: 100%;">

    <!-- <div style="top: 50%; left: 50%; position: absolute;"> -->

<div class ="container-fluid">
	<form action="result.php" method="get">
		<div class ="row">
			<div class="col-sm-1">
			<img src="img/se.jpg" class ="img-fluid" alt="Search" style="width:76px;height:50px;">
	<!-- #image to be inserted of over -->
			</div>
			<div class="col-sm-6" style=margin-left:15px>
				<div class="input-group">
					<input type="text" id="s" class="form-control" name="search" placeholder="Search.."  required>
					<span class="input-group-btn">
						<input class="btn btn-secondary" type="submit" name="searchbutton" value="search">
					</span>
				</div>
		</div>
	</form>
</div>

		<div class="result">
			<?php
			require('tf_idf.php');

				 $con = mysqli_connect("localhost","root","","search");
				 echo $con;

				if(isset($_GET['searchbutton']))
				{
					$search=$_GET['search'];

					if($search!="")
					{
						echo '<script>';
    					echo 'var name = ' . json_encode($search) . ';';
    					echo '</script>';

						queryCheck($search);
					}

				}

			?>
		</div>

<script type="text/javascript">
	document.getElementByName('search').value=name;
</script>

<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
</body>

</html>
