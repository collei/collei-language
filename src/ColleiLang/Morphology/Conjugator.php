<?php
namespace ColleiLang\Morphology;

use ColleiLang\Morphology\Verbs\Verb;
use ColleiLang\Morphology\Verbs\VerbTense;
use ColleiLang\Morphology\Verbs\VerbVoice;
use ColleiLang\Morphology\Verbs\VerbMode;
use ColleiLang\Morphology\Verbs\VerbPerson;
use ColleiLang\Morphology\Verbs\VerbDefiniteness;

/**
 *	Conjugation engine
 *
 *	@author Collei Inc. <collei@collei.com.br>
 *	@author Alarido <alarido.su@gmail.com>
 *	@since 2022-08-08
 */
class Conjugator
{

	private const PERSON_INDEXES = [
		'Mi', 'Ti', 'On', 'Biz', 'Tiz', 'Onk'
	];

	private const PERSON_DESINENCES = [
		'Front' = [
			'Indefinite' => ['u', 'š', null, 'me', 'te', 'ech'],
			'Definite' => ['em', 'ed', 'e', 'enu', 'itek', 'uk'],
		],
		'Back' = [
			'Indefinite' => ['u', 'š', null, 'me', 'te', 'ech'],
			'Definite' => ['om', 'od', 'a', 'onu', 'otok', 'uk'],
		],
	];

	private const TENSE_DESINENCES = [
		'Front' => [
			'Imperfect' => 'y',
			'Perfect' => 't',
		],
		'Back' => [
			'Imperfect' => 'y',
			'Perfect' => 't',
		],
	];

	private const VOICE_DESINENCES = [
		'Front' => [
			'Active' => null,
			'Medial' => 'er',
			'Passive' => 'i',
		],
		'Back' => [
			'Active' => null,
			'Medial' => 'or',
			'Passive' => 'i',
		],
	];

	private static function generateForm(
		Verb $verb,
		VerbPerson $person,
		VerbTense $tense,
		VerbMode $mode,
		VerbVoice $voice,
		VerbDefiniteness $definiteness
	) {
		$stem = $verb->getStem();
		$vowelType = (string)$verb->getHarmony();
		$pIndex = \array_search((string)$person, self::PERSON_INDEXES, true);
		$pIndex = $pIndex ?: 0;
		//
		$base = $stem
			. self::TENSE_DESINENCES[$vowelType][(string)$tense]
			. self::PERSON_DESINENCES[$vowelType][(string)$definiteness][$pIndex]
			. self::VOICE_DESINENCES[$vowelType][(string)$voice];
		//
		return $base;
	}
	
	public static function inflect(
		Verb $verb,
		VerbPerson $person = null,
		VerbTense $tense = null,
		VerbMode $mode = null,
		VerbVoice $voice = null,
		VerbDefiniteness $definiteness = null
	) {
		return self::generateForm(
			$verb,
			$person ?? VerbPerson::new('Mi'),
			$tense ?? VerbTense::new('Imperfect'),
			$mode ?? VerbMode::new('Factual'),
			$voice ?? VerbVoice::new('Active'),
			$definiteness ?? VerbDefiniteness::new('Indefinite')
		);
	}

}

