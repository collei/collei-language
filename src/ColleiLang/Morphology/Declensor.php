<?php
namespace ColleiLang\Morphology;

use ColleiLang\Morphology\Person;
use ColleiLang\Morphology\Case;
use ColleiLang\Morphology\Number;
use ColleiLang\Morphology\Nouns\Noun;

/**
 *	Conjugation engine
 *
 *	@author Collei Inc. <collei@collei.com.br>
 *	@author Alarido <alarido.su@gmail.com>
 *	@since 2022-08-10
 */
class Declensor
{

	private const VOWELS = [
		'a', 'A', 'e', 'E', 'i', 'I', 'o', 'O', 'u', 'U'
	];

	private const PERSON_INDEXES = [
		'Mi', 'Ti', 'On', 'Biz', 'Tiz', 'Onk'
	];

	private const PERSON_DESINENCES = [
		'Front' => [
			'Singular' => [
				null, 't', 'n', 'nek', 'ker', 'ni', 've', 'no', 'le', 'to', 
			],
			'Dual' => [
				'ler', 'lert', 'leren', 'lernek', 'lerker', 'lerni', 'lerve', 'lerno', 'lerle', 'lerto', 
			],
			'Plural' => [
				'ra', 'rat', 'nim', 'nekim', 'kerim', 'rani', 'rave', 'rano', 'rale', 'rato', 
			]
		],
		'Back' => [
			'Singular' => [
				null, 't', 'n', 'nak', 'kar', 'ni', 've', 'no', 'le', 'to', 
			],
			'Dual' => [
				'lar', 'lart', 'laren', 'larnak', 'larkar', 'larni', 'larve', 'larno', 'larle', 'larto', 
			],
			'Plural' => [
				'ra', 'rat', 'nim', 'nakim', 'karim', 'rani', 'rave', 'rano', 'rale', 'rato', 
			]
		]
	];

	private static function generateForm(
		Noun $noun
	) {
		return null;
	}
	
	public static function inflect(
		Noun $noun
	) {
		return self::generateForm(
			$noun
		);
	}

}

