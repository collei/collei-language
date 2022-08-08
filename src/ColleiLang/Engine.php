<?php
namespace ColleiLang;

use ColleiLang\Morphology\Term;
use ColleiLang\Morphology\Nouns\Noun;
use ColleiLang\Morphology\Verbs\Verb;
use ColleiLang\Morphology\Verbs\VerbTense;
use ColleiLang\Morphology\Verbs\VerbVoice;
use ColleiLang\Morphology\Verbs\VerbMode;
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
	
}

