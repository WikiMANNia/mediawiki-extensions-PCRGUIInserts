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

// Class aliases for multi-version compatibility.
// These need to be in global scope so phan can pick up on them,
// and before any use statements that make use of the namespaced names.
if ( version_compare( MW_VERSION, '1.41', '<' ) ) {
	class_exists( 'MediaWiki\Config\Config' ) or class_alias( '\Config', '\MediaWiki\Config\Config' );
	class_exists( 'MediaWiki\Output\OutputPage' ) or class_alias( '\OutputPage', '\MediaWiki\Output\OutputPage' );
}

if ( version_compare( MW_VERSION, '1.44', '<' ) ) {
	class_exists( 'MediaWiki\Skin\Skin' ) or class_alias( '\Skin', '\MediaWiki\Skin\Skin' );
}

use MediaWiki\Config\Config;
use MediaWiki\Output\OutputPage;
use MediaWiki\Skin\Skin;

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

	private Config $config;

	/**
	 * @param Config $config
	 */
	public function __construct(
		Config $config
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

			foreach ( $_array as $key => $value ) {
				$out->addMeta( $key, $value );
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
