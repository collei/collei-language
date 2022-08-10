<?php
namespace ColleiLang;

use ColleiLang\Morphology\Term;
use ColleiLang\Morphology\Person;
use ColleiLang\Morphology\VowelHarmony;
use ColleiLang\Morphology\Conjugator;
use ColleiLang\Morphology\Nouns\Noun;
use ColleiLang\Morphology\Verbs\Verb;
use ColleiLang\Morphology\Verbs\VerbTense;
use ColleiLang\Morphology\Verbs\VerbVoice;
use ColleiLang\Morphology\Verbs\VerbMode;
use ColleiLang\Morphology\Verbs\VerbPerson;
use ColleiLang\Morphology\Verbs\VerbDefiniteness;

/**
 *	Base engine for using Collei Language plugin capabilities
 *
 *	@author Collei Inc. <collei@collei.com.br>
 *	@author Alarido <alarido.su@gmail.com>
 *	@since 2022-08-08
 */
class Engine
{

	public static function definitenesses()
	{
		return VerbDefiniteness::asArray();
	}
	
	public static function voices()
	{
		return VerbVoice::asArray();
	}
	
	public static function modes()
	{
		return VerbMode::asArray();
	}
	
	public static function tenses()
	{
		return VerbTense::asArray();
	}
	
	public static function persons()
	{
		return VerbPerson::asArray();
	}

	public static function createNoun(string $content)
	{
		return new Noun($content);
	}

	public static function createVerb(string $content)
	{
		return new Verb($content);
	}

	public static function inflectVerb(
		Verb $verb,
		VerbPerson $person = null,
		VerbTense $tense = null,
		VerbMode $mode = null,
		VerbVoice $voice = null,
		VerbDefiniteness $definiteness = null
	) {
		return Conjugator::inflect(
			$verb, $person, $tense, $mode, $voice, $definiteness
		);
	}

}

