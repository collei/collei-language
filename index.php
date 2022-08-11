<?php

include 'src\ColleiLang\Engine.php';
include 'src\ColleiLang\ColleiEnum.php';
include 'src\ColleiLang\Contracts\Vowels.php';
include 'src\ColleiLang\Contracts\Persons.php';
include 'src\ColleiLang\Contracts\Cases.php';
include 'src\ColleiLang\Morphology\NominalCase.php';
include 'src\ColleiLang\Morphology\Conjugator.php';
include 'src\ColleiLang\Morphology\Declensor.php';
include 'src\ColleiLang\Morphology\Term.php';
include 'src\ColleiLang\Morphology\NominalTerm.php';
include 'src\ColleiLang\Morphology\Person.php';
include 'src\ColleiLang\Morphology\VowelHarmony.php';
include 'src\ColleiLang\Morphology\Nouns\Noun.php';
include 'src\ColleiLang\Morphology\Verbs\Verb.php';
include 'src\ColleiLang\Morphology\Verbs\VerbTense.php';
include 'src\ColleiLang\Morphology\Verbs\VerbMode.php';
include 'src\ColleiLang\Morphology\Verbs\VerbVoice.php';
include 'src\ColleiLang\Morphology\Verbs\VerbPerson.php';
include 'src\ColleiLang\Morphology\Verbs\VerbDefiniteness.php';

use ColleiLang\Engine;

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
.blockisa {
	display: inline-block !important;
	width: 20vw !important;
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
		$verb = Engine::createVerb($term);
		$persons = Engine::persons();
		$tenses = Engine::tenses();
		$modes = Engine::modes();
		$voices = Engine::voices();
		$defines = Engine::definitenesses();
		//
		foreach ($modes as $mode) {
			if ($mode->is('Imperative')) {
				foreach ($defines as $define) {
					echo '<fieldset class="blockisa"><legend>' . $mode . ' ' . $voice . ' ' . $tense . ' ' . $define . '</legend>';
					foreach ($persons as $person) {
						if (in_array((string)$person, ['Mi','On','Onk'], true)) {
							echo '<div> &nbsp; &mdash; </div>'; 
						} else {
							$form = $verb->conjugate($person, $tense, $mode, $voice, $define);
							//
							echo '<div>' . $person . ' ' . $form . '</div>'; 
						}
					}
					echo '</fieldset>';
				}
				echo '<hr>';
			} else {
				foreach ($voices as $voice) {
					foreach ($tenses as $tense) {
						foreach ($defines as $define) {
							echo '<fieldset class="blockisa"><legend>' . $mode . ' ' . $voice . ' ' . $tense . ' ' . $define . '</legend>';
							foreach ($persons as $person) {
								$form = $verb->conjugate($person, $tense, $mode, $voice, $define);
								//
								echo '<div>' . $person . ' ' . $form . '</div>'; 
							}
							echo '</fieldset>';
						}
					}
					echo '<hr>';
				}
			}
		}		
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
