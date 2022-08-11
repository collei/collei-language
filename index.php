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
include 'src\ColleiLang\Morphology\Number.php';
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
fieldset.blockisa {
	display: inline-block !important;
	width: 20vw !important;
}
fieldset.declension {
	width: 40vw !important;
}
fieldset.declension > div {
	display: block !important;
	white-space: nowrap !important;
	width: 100% !important;
}
fieldset.declension > div > div {
	display: inline-block !important;
	width: 25% !important;
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
	elseif ($action == 'makedeclension')
	{
		$noun = Engine::createNoun($term);
		$persons = Engine::listOf('noun:person');
		$numbers = Engine::listOf('noun:number');
		$cases = Engine::listOf('noun:cases');
		//
		?>
		<fieldset class="declension">
			<legend>Declension of <i><?=($noun)?></i></legend>
			<div>
				<div>&nbsp;</div>
		<?php
		//
		foreach ($numbers as $number) {
			echo "\r\n\t\t\t\t<div><b>{$number}</b></div>";
		}
		//
		?>
			</div>
		<?php
		//
		foreach ($cases as $case) {
			echo "\r\n\t\t\t<div>\r\n\t\t\t\t<div><b>{$case}</b></div>";
			//
			foreach ($numbers as $number) {
				$form = $noun->decline($number, $case);
				//
				echo "\r\n\t\t\t\t<div>{$form}</div>";
			}
			//
			echo "\r\n\t\t\t</div>";
		}
		//
		?>
			<hr>
			<div><b>Nominative Possessive System</b></div>
		<?php
		//
		foreach ($persons as $person) {
			echo "\r\n\t\t\t<div>\r\n\t\t\t\t<div><b>{$person}</b></div>";
			//
			foreach ($numbers as $number) {
				$form = $noun->possessive($person, $number);
				//
				echo "\r\n\t\t\t\t<div>{$form}</div>";
			}
			//
			echo "\r\n\t\t\t</div>";
		}
		//
		?>
		</fieldset>
		<?php
		//
	}
}
//
?>
</div>
</body>
</html>
