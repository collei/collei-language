<?php

include 'src\ColleiLang\Engine.php';
include 'src\ColleiLang\ColleiEnum.php';
include 'src\ColleiLang\Morphology\Term.php';
include 'src\ColleiLang\Morphology\Verbs\Verb.php';
include 'src\ColleiLang\Morphology\Verbs\VerbTense.php';
include 'src\ColleiLang\Morphology\Verbs\VerbMode.php';
include 'src\ColleiLang\Morphology\Verbs\VerbVoice.php';
include 'src\ColleiLang\Morphology\Verbs\VerbPerson.php';
include 'src\ColleiLang\Morphology\Verbs\VerbDefiniteness.php';
include 'src\ColleiLang\Morphology\Nouns\Noun.php';

use ColleiLang\Engine;
use ColleiLang\Morphology\Verbs\VerbTense;

$term = $_REQUEST['term'] ?? '';
$action = $_REQUEST['for'] ?? '';

$infos = [];

?>
<!doctype html>
<html>
<head>
	<style>
#divided {
	white-space: nowrap !important;
	width: 97.5%;
}
#divided fieldset {
	vertical-align: top !important;
	display: inline-block !important;
	height: 160px;
	margin: 0;
}
#divided fieldset.s20 {
	min-width: 24.5% !important;
	max-width: 24.5% !important;
}
#divided fieldset.s40 {
	min-width: 40% !important;
	max-width: 40% !important;
}
#logbelow {
	max-height: 70vh !important;
}
.autosiz {
	overflow-x: scroll !important;
	overflow-y: scroll !important;
}

	</style>
	<script>
function showside(sel)
{
	let pd = sel.options[sel.selectedIndex].getAttribute('datapack');
	let display = document.getElementById('showsider');
	display.innerHTML = pd;
}
	</script>
</head>
<body>
<hr>
<div id="divided">
	<fieldset class="s20">
		<form action="./" method="post">
			<input type="hidden" name="for" value="conjugate">
			<p>
				Fill the verb in and hit <b>CONJUGATE</b>.
			</p>
			<p>
				<input type="text" name="term" />
				&nbsp; &nbsp;
				<input type="submit" name="conjugate" value="CONJUGATE" />
			</p>
		</form>
	</fieldset>
	<fieldset class="s20">
		<form action="./" method="post">
			<input type="hidden" name="for" value="makedeclension">
			<p>
				Fill the noun in and hit <b>MAKE DECLENSION</b>.
			</p>
			<p>
				<input type="text" name="term" />
				&nbsp; &nbsp;
				<input type="submit" name="makedeclension" value="MAKE DECLENSION" />
			</p>
		</form>
	</fieldset>
	<fieldset class="s20">
		<form action="./" method="post">
			<input type="hidden" name="for" value="makedeclension">
			<p>
				Choose all and hit <b>MAKE DECLENSION</b>.
			</p>
			<p>
				<input type="text" name="term" />
			</p>
			<p>
<?php
$lists = [
	'tenses' => Engine::tenses(),
	'modes' => Engine::modes(),
	'voices' => Engine::voices(),
	'defins' => Engine::definitenesses(),
];
$tempo = VerbTense::new('perfect');
$verdade = VerbTense::new('perfect') == VerbTense::new('PERFECT');
$falso = VerbTense::new('perfect') == VerbTense::new('Imperfect');
//
foreach ($lists as $n => $list) {
	echo "\r\n<select name=\"{$n}\">";
	echo "\r\n\t<option value=\"0\">-- Select {$n} --</option>";
	foreach ($list as $i => $val) {
		echo "\r\n\t<option value=\"{$i}\">{$val}</option>";
	}
	echo "\r\n</select>";
}
//
?>
			</p>
			<p>
				Há uma coisa que diria <?=($tempo)?> cujo <?=($verdade ? 'V' : 'F')?> é <?=($falso ? 'V' : 'F')?>.
			</p>
			<p>
				<input type="submit" name="makedeclension" value="MAKE DECLENSION" />
			</p>
		</form>
	</fieldset>
</div>
<hr>
<div id="logbelow" class="autosiz">
	<pre>
<?php

################################################################
####	my own practice workspace, also serves as example	####
################################################################


if (!empty($term) && !empty($action))
{
	if ($action == 'conjugate')
	{
		if (install_package($git_package))
			echo "- Package $git_package installed successfully. $nl";
		else
			echo "- Error occurred while installing $git_package. Please verify. $nl";
	}
	elseif ($git_action == 'makedeclension')
	{
		if (remove_package($git_package))
			echo "- Package $git_package removed successfully. $nl";
		else
			echo "- Error occurred while removing $git_package. Please verify. $nl";
	}
}
elseif (1 == 2)
{

}



?>
	</pre>
</div>
</body>
</html>
