<?php
namespace ColleiLang\Morphology;

use ColleiLang\Morphology\Person;
use ColleiLang\Morphology\NominalCase;
use ColleiLang\Morphology\Number;
use ColleiLang\Morphology\Nouns\Noun;
use ColleiLang\Contracts\Vowels;
use ColleiLang\Contracts\Persons;
use ColleiLang\Contracts\Cases;

/**
 *	Conjugation engine
 *
 *	@author Collei Inc. <collei@collei.com.br>
 *	@author Alarido <alarido.su@gmail.com>
 *	@since 2022-08-10
 */
class Declensor implements Vowels, Persons, Cases
{
	private const PERSON_DESINENCES = [
		'Front' => [
			'Singular' => [
				0 => [null, 't', 'n', 'nek', 'ker', 'ni', 've', 'no', 'le', 'to'],
				1 => [null, 'et', 'en', 'nek', 'ker', 'ni', 've', 'no', 'le', 'to']
			],
			'Plural' => [
				0 => [null, 'rat', 'nim', 'nekim', 'kerim', 'rani', 'rave', 'rano', 'rale', 'rato'],
				1 => [null, 'imet', 'enim', 'nekim', 'kerim', 'imni', 'imve', 'imno', 'imle', 'imto']
			]
		],
		'Back' => [
			'Singular' => [
				0 => [null, 't', 'n', 'nak', 'kar', 'ni', 've', 'no', 'le', 'to'],
				1 => [null, 'ot', 'en', 'nak', 'kar', 'ni', 've', 'no', 'le', 'to']
			],
			'Plural' => [
				0 => [null, 'rat', 'nim', 'nakim', 'karim', 'rani', 'rave', 'rano', 'rale', 'rato'],
				1 => [null, 'imot', 'enim', 'nakim', 'karim', 'imni', 'imve', 'imno', 'imle', 'imto']
			]
		]
	];

	private const PLURAL_PATTERNS = [
		'um' => 'a',
		'ra' => 'ri',
		'a' => 'ara',
		'e' => 'era',
		'i' => 'im',
		'o' => 'ora',
		'u' => 'ura',
		'' => 'im'
	];

	private const NUMBER_DESINENCES = [
		'Front' => [
			'Singular' => null,
			'Dual' => 'ler',
			'Plural' => self::PLURAL_PATTERNS
		],
		'Back' => [
			'Singular' => null,
			'Dual' => 'lar',
			'Plural' => self::PLURAL_PATTERNS
		]
	];

	private const POSSESSION_DESINENCES = [
		''
	];

	private const POSSESSION_EXCLUSIONS = [
		'nak' => ['nakom', 'nakod', 'nakya', 'nakanu', 'nakotok', 'nakyuk'],
		'nek' => ['nekem', 'neked', 'nekye', 'nekenu', 'nekitek', 'nekyuk'],
		'kar' => ['karom', 'karod', 'karya', 'karanu', 'karotok', 'karyuk'],
		'ker' => ['kerem', 'kered', 'kerye', 'kerenu', 'keritek', 'keryuk'],
		'ni' => ['nim', 'nid', 'niy', 'ninu', 'nitek', 'niyuk'],
	];

	private static function generateForm(
		Noun $noun,
		Number $number,
		NominalCase $case
	) {
		$base = (string)$noun;
		$harmony = $noun->getHarmony();
		$voweled = (\in_array($noun->last(), self::VOWELS, true) ? 0 : 1);
		//
		if ($case->is('Nominative') && $number->is('Plural')) {
			foreach (self::PLURAL_PATTERNS as $from => $to) {
				if (empty($from)) {
					return $baseNoun->asString() . $to;
				} else {
					$suffixLength = \strlen($from);
					if ($baseNoun->last($suffixLength) == $from) {
						return \substr(
							$baseNoun->asString(), 0, -$suffixLength
						) . $to;
					}
				}
			}
		}
		//
		if ($number->is('Dual')) {
			$base .= self::NUMBER_DESINENCES[(string)$harmony]['Dual'];
			$voweled = 1;
			$numberStr = 'Singular';
		} else {
			$numberStr = (string)$number;
		}
		//
		$caseId = \array_search((string)$case, self::CASES);
		//
		return self::PERSON_DESINENCES[(string)$harmony][$numberStr][$caseId] ?? '';
	}
	
	public static function decline(
		Noun $noun,
		Number $number,
		NominalCase $case
	) {
		return self::generateForm(
			$noun, $number, $case
		);
	}

}

