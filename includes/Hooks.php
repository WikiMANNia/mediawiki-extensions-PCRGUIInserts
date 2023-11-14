<?php
/**
 * Hooks for PCR GUI Inserts extension
 *
 * @author David Dernoncourt (Patheticcockroach)
 *
 * @license https://creativecommons.org/licenses/by-sa/4.0/ CC-BY-SA-4.0
 *
 * @file
 * @ingroup Extensions
 */

namespace MediaWiki\Extension\PCRGUIInserts;

use MediaWiki\Hook\SkinAfterBottomScriptsHook
use MediaWiki\Hook\SkinBuildSidebarHook;
use MediaWiki\Hook\BeforePageDisplayHook;

use OutputPage;
use Skin;

/**
 * PHPMD will warn us about these things here but since they're hooks,
 * we really don't have much choice.
 *
 * @SuppressWarnings(PHPMD.CamelCaseMethodName)
 * @SuppressWarnings(PHPMD.UnusedFormalParameter)
 * @SuppressWarnings(PHPMD.CouplingBetweenObjects)
 *
 * @phpcs:disable MediaWiki.NamingConventions.LowerCamelFunctionsName.FunctionName
 */
class Hooks implements
	SkinAfterBottomScriptsHook,
	SkinBuildSidebarHook,
	BeforePageDisplayHook
{

	private array $inserts;

	/**
	 * @param GlobalVarConfig $config
	 */
	public function __construct(
		GlobalVarConfig $config
	) {
		$this->inserts = $config->get( "PCRguii_Inserts" );
	}

	/**
	 * This hook is called prior to outputting a page.
	 *
	 * @since 1.35
	 *
	 * @param OutputPage $out
	 * @param Skin $skin
	 * @return void This hook must not abort, it must return no value
	 */
	public function onBeforePageDisplay( $out, $skin ): void {

		if ( $this->inserts['addHeadItem']['on'] ) {

			$i=0;
			foreach ( $this->inserts['addHeadItem']['content'] as $value ) {
				$out->addHeadItem('PCRGUIInserts'.$i,$value);
				$i++;
			}
		}
		if ( $this->inserts['BeforePageDisplay']['on'] ) {
			$out->addHTML( $this->inserts['BeforePageDisplay']['content'] );
		}
	}

	/**
	 * This hook is called at the end of Skin::bottomScripts().
	 *
	 * @since 1.35
	 *
	 * @param Skin $skin
	 * @param string &$text BottomScripts text. Append to $text to add additional text/scripts after
	 *   the stock bottom scripts.
	 * @return bool|void True or no return value to continue or false to abort
	 */
	public function onSkinAfterBottomScripts( $skin, &$text ) {

		if ( $this->inserts['SkinAfterBottomScripts']['on'] ) {
			$text .= $this->inserts['SkinAfterBottomScripts']['content'];
		}
	}

	/**
	 * This hook is called at the end of Skin::buildSidebar().
	 *
	 * @since 1.35
	 *
	 * @param Skin $skin
	 * @param array &$bar Sidebar contents. Modify $bar to add or modify sidebar portlets.
	 * @return bool|void True or no return value to continue or false to abort
	 */
	public function onSkinBuildSidebar( $skin, &$bar ) {

		if ( $this->inserts['SkinBuildSidebar']['on'] ) {
			foreach ( $this->inserts['SkinBuildSidebar']['content'] as $value )
			$bar[$value[0]] = $value[1];
		}
	}
}
