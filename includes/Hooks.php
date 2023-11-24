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

use MediaWiki\Hook\SkinAfterBottomScriptsHook;
use MediaWiki\Hook\SkinBuildSidebarHook;
use MediaWiki\Hook\BeforePageDisplayHook;

use GlobalVarConfig;
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

	private GlobalVarConfig $config;

	/**
	 * @param GlobalVarConfig $config
	 */
	public function __construct(
		GlobalVarConfig $config
	) {
		$this->config = $config;
	}

	/**
	 * This hook is called prior to outputting a page.
	 *
	 * @param OutputPage $out
	 * @param Skin $skin
	 * @return void This hook must not abort, it must return no value
	 */
	public function onBeforePageDisplay( $out, $skin ): void {

		$_array = $this->config->get( "PcrGuiHeadItems" );
		if ( is_array( $_array ) && ( count( $_array ) > 0 ) ) {

			$i=0;
			foreach ( $_array as $value ) {
				$out->addHeadItem( "PCRGUIInserts_$i", $value );
				$i++;
			}
		}

		$_array = $this->config->get( "PcrGuiMetaItems" );
		if ( is_array( $_array ) && ( count( $_array ) > 0 ) ) {

			foreach ( $_array as $value ) {
				$out->addMeta( $value[0], $value[1] );
			}
		}

		$_string = $this->config->get( "PcrGuiDisplayBottom" );
		if ( !empty( $_string ) ) {
			$out->addHTML( $_string );
		}
	}

	/**
	 * This hook is called at the end of Skin::bottomScripts().
	 *
	 * @param Skin $skin
	 * @param string &$text BottomScripts text. Append to $text to add additional text/scripts after
	 *   the stock bottom scripts.
	 * @return bool|void True or no return value to continue or false to abort
	 */
	public function onSkinAfterBottomScripts( $skin, &$text ) {

		$_string = $this->config->get( "PcrGuiScripts" );
		if ( !empty( $_string ) ) {
			$text .= $_string;
		}
	}

	/**
	 * This hook is called at the end of Skin::buildSidebar().
	 *
	 * @param Skin $skin
	 * @param array &$bar Sidebar contents. Modify $bar to add or modify sidebar portlets.
	 * @return bool|void True or no return value to continue or false to abort
	 */
	public function onSkinBuildSidebar( $skin, &$bar ) {

		$_array = $this->config->get( "PcrGuiSidebarItems" );
		if ( is_array( $_array ) && ( count( $_array ) > 0 ) ) {
			foreach ( $_array as $value ) {
				$bar[$value[0]] = $value[1];
			}
		}
	}
}
