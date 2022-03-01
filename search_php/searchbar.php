<html>
<head>
	<title> search engin </title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
	<!-- <link href="styles/newstyle.css" rel="stylesheet" type="text/css" /> -->
	<style type="text/css">
		.form-control{

		 -webkit-border-radius: 50px;
		 -moz-border-radius: 50px;
		 border-radius: 50px;
		}
		.form-control:hover{
		 -webkit-box-shadow: 3px 6px 7px -3px #ccc;
		}

	</style>
</head>
<body onload="ld()" style="margin:19%;">
	<script>
		function ld()
		{
			document.searchbox.search.focus();
		}
	</script>

<form name="searchbox" action="result.php" method="get">
	<center>
	<img src="img/searchhub.jpg" class ="img-responsive" alt="Search" style="width:500px;height:400px;">


	<input type="text" class="form-control" name="search" style="width:60%;margin-top:20px" placeholder="Search a url..">
	<input type="submit"  class="btn btn-outline-primary" value="search now" name="searchbutton" style="margin-top:20px;">

	</center>
</form>

<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>

</body>
</html>
