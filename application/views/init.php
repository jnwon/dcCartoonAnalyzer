<html>
<head>
<style>
img {
    position: absolute;
    left: 25%;
    top: 10%;
}
</style>
</head>
<body>
	<img id='init' src='/init_img.gif' style="">
	<script>
		var mobileKeyWords = new Array('iPhone', 'iPod', 'BlackBerry', 'Android', 'Windows CE', 'LG', 'MOT', 'SAMSUNG', 'SonyEricsson','Windows Phone', 'Pixel');

		for (var word in mobileKeyWords){
			if (navigator.userAgent.match(mobileKeyWords[word]) != null){
				location.href = "/index.php/main/m_all/page1";
				break;
			}
			else{
				location.href = '/index.php/main/all';
			}
		}
	</script>
</body>
</html>