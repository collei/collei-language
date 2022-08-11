<?php
namespace ColleiLang\Morphology;

use ColleiLang\Morphology\Verbs\Verb;
use ColleiLang\Morphology\Verbs\VerbTense;
use ColleiLang\Morphology\Verbs\VerbVoice;
use ColleiLang\Morphology\Verbs\VerbMode;
use ColleiLang\Morphology\Verbs\VerbPerson;
use ColleiLang\Morphology\Verbs\VerbDefiniteness;
use ColleiLang\Contracts\Vowels;
use ColleiLang\Contracts\Persons;

/**
 *	Conjugation engine
 *
 *	@author Collei Inc. <collei@collei.com.br>
 *	@author Alarido <alarido.su@gmail.com>
 *	@since 2022-08-08
 */
class Conjugator implements Vowels, Persons
{
	private const INDEFINITES = [
		'Imperfect' => [
			0 => ['yu', 'yš', 'y', 'yme', 'yte', 'yche'],
			1 => ['u', 'iš', 'e', 'ime', 'ite', 'ech']
		],
		'Perfect' => [
			0 => ['tu', 'tiš', 'te', 'time', 'tite', 'tche'],
			1 => ['tu', 'tiš', 'te', 'time', 'tite', 'tche']
		],
		'Imperative' => [
			0 => [null, 'c', null, 'moc', 'toc', null],
			1 => [null, 'ic', null, 'emme', 'ette', null]
		]
	];

	private const PERSON_DESINENCES = [
		'Front' => [
			'Imperfect' => [
				'Indefinite' => self::INDEFINITES['Imperfect'],
				'Definite' => ['yem', 'yed', 'ye', 'yenu', 'yene', 'yuk']
			],
			'Perfect' => [
				'Indefinite' => self::INDEFINITES['Perfect'],
				'Definite' => ['tem', 'ted', 'te', 'tenu', 'tene', 'tuk']
			]
		],
		'Back' => [
			'Imperfect' => [
				'Indefinite' => self::INDEFINITES['Imperfect'],
				'Definite' => ['yom', 'yod', 'ya', 'yonu', 'yana', 'yuk']
			],
			'Perfect' => [
				'Indefinite' => self::INDEFINITES['Perfect'],
				'Definite' => ['tom', 'tod', 'ta', 'tonu', 'tana', 'tuk']
			]
		]
	];

	private const PERSON_IMPERATIVES = [
		'Front' => [
			'Indefinite' => self::INDEFINITES['Imperative'],
			'Definite' => [null, 'ched', null, 'chenu', 'chene', null]
		],
		'Back' => [
			'Indefinite' => self::INDEFINITES['Imperative'],
			'Definite' => [null, 'chod', null, 'chonu', 'chana', null]
		]
	];

	private const VOICE_DESINENCES = [
		'Front' => [
			'Active' => null,
			'Medial' => 'er',
			'Passive' => 'i'
		],
		'Back' => [
			'Active' => null,
			'Medial' => 'or',
			'Passive' => 'i'
		]
	];

	private const MODE_PARTICLES = [
		'Factual' => null,
		'Desiderative' => 'na'
	];

	private static function generateForm(
		Verb $verb,
		VerbPerson $person,
		VerbTense $tense,
		VerbMode $mode,
		VerbVoice $voice,
		VerbDefiniteness $definiteness
	) {
		$base = $verb->getStem();
		$harmony = (string)$verb->getHarmony();
		$personIndex = \array_search(
			(string)$person, self::PERSONS, true
		) ?: 0;
		//
		if ($mode->is('Imperative')) {
			if ($definiteness->is('Indefinite')) {
				$vowelful = $verb->endsInVowel() ? 0 : 1;
				$base .= self::PERSON_IMPERATIVES[$harmony]['Indefinite'][$vowelful][$personIndex];
			} elseif ($definiteness->is('Definite')) {
				$base .= self::PERSON_IMPERATIVES[$harmony]['Definite'][$personIndex];
			}
			//
			return $base;
		}
		//
		if ($definiteness->is('Indefinite')) {
			$vowelful = $verb->endsInVowel() ? 0 : 1;
			$base .= self::PERSON_DESINENCES[$harmony][(string)$tense]['Indefinite'][$vowelful][$personIndex];
		} elseif ($definiteness->is('Definite')) {
			$base .= self::PERSON_DESINENCES[$harmony][(string)$tense]['Definite'][$personIndex];
		}
		//
		$baseEnding = \substr($base, -1);
		//
		if (!$voice->is('Active')) {
			$base = $base
				. (\in_array($baseEnding, self::VOWELS) ? 'r' : '')
				. self::VOICE_DESINENCES[$harmony][(string)$voice];
		}
		//
		if ($mode->is('Desiderative')) {
			$base = self::MODE_PARTICLES['Desiderative'] . ' ' . $base;
		}
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

