<?

require('rb/rb.php');

R::setup('mysql:host=localhost;dbname=guestbook', 'root', '');

if(isset($_POST['add']))
{
	$errors = array();

	if(empty($_POST['name']))
	{
		$errors[] = 'Enter your name';
	}

	if(empty($_POST['email']))
	{
		$errors[] = 'Enter your email';
	}

	if(empty($errors))
	{
		$guest = R::dispense('guests');

		$guest->name = $_POST['name'];
		$guest->email = $_POST['email'];
		$guest->text = $_POST['message'];
		$guest->date = date("m.d.Y");
		$guest->time = date("h:i");

		R::store($guest);
	}
	else
	{
		echo array_shift($errors);
	}
}

$guests = R::getAll('SELECT * FROM guests');

?>

<form action="<? $_SERVER['PHP_SELF'] ?>" method="POST">
	<p><input type="text" placeholder="Enter your name" name="name">
	<p><input type="text" placeholder="Enter your email" name="email">
	<p><textarea name="message" id="" cols="30" rows="10" maxlength="100" placeholder="Enter your message"></textarea>
	<p><input type="submit" name="add">
</form>

<?

foreach ($guests as $guest)
{
	echo $guest['date'] . ' ' . $guest['time'] . ' ' . $guest['name'] . '  ' . $guest['text'] . '<br>';
}

?>