<?php
/*
 * Copyright (c) 2012 David Negrier
 * 
 * See the file LICENSE.txt for copying permission.
 */
namespace Mouf\Html\Template\Menus;

use \Mouf\Html\HtmlElement\HtmlElementInterface;
use \Mouf\Html\Widgets\Menu\MenuItemInterface;

/**
 * This class is in charge of rendering a menu. It contains a menu and can transform it in HTML using the toHtml() method.
 * <p>The rendering is performed according to Twitter Bootstrap markup.</p>
 * 
 * @Component
 */
class BootstrapMenuRenderer implements HtmlElementInterface {
	
	/**
	 * The menu to render
	 *
	 * @Property
	 * @Compulsory
	 * @var MenuInterface
	 */
	public $menu;
	
	/**
	 * The whole CSS class to apply to the UL element.
	 * 
	 * @Property
	 * @Compulsory
	 * @var string
	 */
	public $cssClass = "menu";
	
	/**
	 * Initialize the object, optionnally with the array of menu items to be displayed.
	 *
	 * @param array<MenuItemInterface> $menuItems
	 */
	public function __construct($menu = null) {
		$this->menu = $menu;
	}
	
	public function toHtml() {
		if ($this->menu && !$this->menu->isHidden()) {
			echo '<ul class="'.$this->cssClass.'">';
			
			$menuItems = $this->menu->getChildren();
			if (is_array($menuItems)) {
				foreach ($menuItems as $item) {
					$this->renderHtmlMenuItem($item);
				}
			}
				
			echo '</ul>';
		}
	}
	
	private function renderHtmlMenuItem(MenuItemInterface $menuItem) {
		if (!$menuItem->isHidden()) {
			echo '<li ';
			$menuCssClass = $menuItem->getCssClass();
			if (!empty($menuCssClass) || $menuItem->isActive() || $menuItem->isExtended()) {
				echo 'class="';
				echo $menuCssClass;
				if ($menuItem->isActive()) {
					echo ' active';
				}
				echo '"';
			}
			echo '>';
			$url = $menuItem->getLink();
			if ($url) {
				echo '<a href="'.$url.'" >';
			}
			echo $menuItem->getLabel();
			if ($url) {
				echo '</a>';
			}
			$children = $menuItem->getChildren();
			if ($children) {
				echo '<ul>';
				foreach ($children as $child) {
					/* @var $child MenuItemInterface */
					$this->renderHtmlMenuItem($child);
				}
				echo '</ul>';
			}
			
			echo '</li>';
		}
	}
	
}
?>