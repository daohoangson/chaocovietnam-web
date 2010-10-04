<html>
	<head>
    <title>404 Not Found</title>
</head>
<body>
	<h1>Your request can not be served</h1>
	<div style="text-align: center">
		<?php
			$sets = array(
				array(
					'src' => 'bike.jpg',
					'text' => 'Too bad, my bike went down the hole when I was processing your request!',
				),
				array(
					'src' => 'bridge.jpg',
					'text' => 'Your request is too BAD. I will never serve that one!',
				),
				array(
					'src' => 'bus.jpg',
					'text' => 'I just can\' handle your request. Okie, I admit, I give up...',
				),
				array(
					'src' => 'heart.jpg',
					'text' => 'I love you but I just could find the file you want. Sorry mate.',
				),
				array(
					'src' => 'pig.jpg',
					'text' => 'My thought at this exact moment. Screwed!',
				),
			);
			$key = array_rand($sets);
			$src = 'http://chaocovietnam.net/404/' . $sets[$key]['src'];
			$text = $sets[$key]['text'];
		?>
		<img src="<?php echo $src; ?>" alt="Image"/>
		<div><?php echo $text; ?></div>
		<div><a href="http://chaocovietnam.net/">Chao Co Viet Nam</a></div>
	</div>
</body>
</html>