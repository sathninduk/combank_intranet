"use strict";

function _createForOfIteratorHelper(o, allowArrayLike) { var it = typeof Symbol !== "undefined" && o[Symbol.iterator] || o["@@iterator"]; if (!it) { if (Array.isArray(o) || (it = _unsupportedIterableToArray(o)) || allowArrayLike && o && typeof o.length === "number") { if (it) o = it; var i = 0; var F = function F() {}; return { s: F, n: function n() { if (i >= o.length) return { done: true }; return { done: false, value: o[i++] }; }, e: function e(_e) { throw _e; }, f: F }; } throw new TypeError("Invalid attempt to iterate non-iterable instance.\nIn order to be iterable, non-array objects must have a [Symbol.iterator]() method."); } var normalCompletion = true, didErr = false, err; return { s: function s() { it = it.call(o); }, n: function n() { var step = it.next(); normalCompletion = step.done; return step; }, e: function e(_e2) { didErr = true; err = _e2; }, f: function f() { try { if (!normalCompletion && it.return != null) it.return(); } finally { if (didErr) throw err; } } }; }

function _unsupportedIterableToArray(o, minLen) { if (!o) return; if (typeof o === "string") return _arrayLikeToArray(o, minLen); var n = Object.prototype.toString.call(o).slice(8, -1); if (n === "Object" && o.constructor) n = o.constructor.name; if (n === "Map" || n === "Set") return Array.from(o); if (n === "Arguments" || /^(?:Ui|I)nt(?:8|16|32)(?:Clamped)?Array$/.test(n)) return _arrayLikeToArray(o, minLen); }

function _arrayLikeToArray(arr, len) { if (len == null || len > arr.length) len = arr.length; for (var i = 0, arr2 = new Array(len); i < len; i++) { arr2[i] = arr[i]; } return arr2; }

var voluto = voluto || {};
/**
 * Handles toggling the navigation menu for small screens and enables TAB key
 * navigation support for dropdown menus.
 */

voluto.navigation = {
  init: function init() {
    //Desktop submenus
    var desktopNav = document.getElementById('site-navigation');
    var submenuToggles = desktopNav.querySelectorAll('.icon-dropdown');
    var submenus = desktopNav.querySelectorAll('.sub-menu');

    var _iterator = _createForOfIteratorHelper(submenuToggles),
        _step;

    try {
      var _loop2 = function _loop2() {
        var submenuToggle = _step.value;
        submenuToggle.addEventListener('keydown', function (e) {
          var isTabPressed = e.key === 'Enter' || e.keyCode === 13;

          if (!isTabPressed) {
            return;
          }

          e.preventDefault();
          var parent = submenuToggle.parentNode;
          parent.getElementsByClassName('sub-menu')[0].classList.toggle('toggled');
        });
      };

      for (_iterator.s(); !(_step = _iterator.n()).done;) {
        _loop2();
      }
    } catch (err) {
      _iterator.e(err);
    } finally {
      _iterator.f();
    }

    var _iterator2 = _createForOfIteratorHelper(submenus),
        _step2;

    try {
      var _loop3 = function _loop3() {
        var submenu = _step2.value;
        submenu.querySelectorAll('li:last-child > a').forEach(function (linkEl) {
          linkEl.addEventListener('blur', function (event) {
            submenu.classList.remove('toggled');
          });
        });
      };

      for (_iterator2.s(); !(_step2 = _iterator2.n()).done;) {
        _loop3();
      } //Mobile

    } catch (err) {
      _iterator2.e(err);
    } finally {
      _iterator2.f();
    }

    var siteNavigation = document.getElementById('mobile-navigation'); // Return early if the navigation don't exist.

    if (!siteNavigation) {
      return;
    }

    var button = document.getElementsByClassName('menu-toggle')[0]; // Return early if the button don't exist.

    if ('undefined' === typeof button) {
      return;
    }

    var menu = siteNavigation.getElementsByTagName('ul')[0];
    var mobileMenuClose = siteNavigation.getElementsByClassName('mobile-menu-close')[0]; // Hide menu toggle button if menu is empty and return early.

    if ('undefined' === typeof menu) {
      button.style.display = 'none';
      return;
    }

    if (!menu.classList.contains('nav-menu')) {
      menu.classList.add('nav-menu');
    }

    button.addEventListener('click', function () {
      siteNavigation.classList.toggle('toggled');
      document.body.classList.toggle('mobile-menu-active'); //Toggle submenus

      var submenuToggles = siteNavigation.querySelectorAll('.icon-dropdown');

      var _iterator3 = _createForOfIteratorHelper(submenuToggles),
          _step3;

      try {
        var _loop = function _loop() {
          var submenuToggle = _step3.value;
          submenuToggle.addEventListener('touchstart', function (e) {
            e.preventDefault();
            submenuToggle.getElementsByTagName('span')[0].classList.toggle('submenu-exp');
            var parent = submenuToggle.parentNode.parentNode;
            parent.getElementsByClassName('sub-menu')[0].classList.toggle('toggled');
          });
          submenuToggle.addEventListener('click', function (e) {
            e.preventDefault();
            submenuToggle.getElementsByTagName('span')[0].classList.toggle('submenu-exp');
            var parent = submenuToggle.parentNode.parentNode;
            parent.getElementsByClassName('sub-menu')[0].classList.toggle('toggled');
          });
          submenuToggle.addEventListener('keydown', function (e) {
            var isTabPressed = e.key === 'Enter' || e.keyCode === 13;

            if (!isTabPressed) {
              return;
            }

            e.preventDefault();
            submenuToggle.getElementsByTagName('span')[0].classList.toggle('submenu-exp');
            var parent = submenuToggle.parentNode.parentNode;
            parent.getElementsByClassName('sub-menu')[0].classList.toggle('toggled');
          });
        };

        for (_iterator3.s(); !(_step3 = _iterator3.n()).done;) {
          _loop();
        } //Trap focus inside modal

      } catch (err) {
        _iterator3.e(err);
      } finally {
        _iterator3.f();
      }

      var focusableEls = siteNavigation.querySelectorAll('a[href]:not([disabled]), input[type="search"]:not([disabled])'),
          firstFocusableEl = focusableEls[0];
      var lastFocusableEl = focusableEls[focusableEls.length - 1];
      var KEYCODE_TAB = 9;
      siteNavigation.addEventListener('keydown', function (e) {
        var isTabPressed = e.key === 'Tab' || e.keyCode === KEYCODE_TAB;

        if (!isTabPressed) {
          return;
        }

        if (e.shiftKey)
          /* shift + tab */
          {
            if (document.activeElement === firstFocusableEl) {
              siteNavigation.getElementsByClassName('mobile-menu-close').focus();
              e.preventDefault();
            }

            if (document.activeElement === mobileMenuClose) {
              e.preventDefault();
              lastFocusableEl.focus();
            }
          } else
          /* tab */
          {
            if (document.activeElement === lastFocusableEl) {
              e.preventDefault();
              mobileMenuClose.focus();
            }
          }
      });
      mobileMenuClose.addEventListener('click', function (e) {
        siteNavigation.classList.remove('toggled');
        document.body.classList.remove('mobile-menu-active');
      });
      mobileMenuClose.addEventListener('keyup', function (e) {
        if (e.keyCode === 13) {
          e.preventDefault();
          siteNavigation.classList.remove('toggled');
          document.body.classList.remove('mobile-menu-active');
        }
      });
    });
    button.addEventListener('keyup', function (e) {
      var isTabPressed = e.key === 'Enter' || e.keyCode === 13;

      if (!isTabPressed) {
        return;
      }

      mobileMenuClose.focus();
    }); // Get all the link elements within the menu.

    var links = menu.getElementsByTagName('a'); // Get all the link elements with children within the menu.

    var linksWithChildren = menu.querySelectorAll('.menu-item-has-children > a, .page_item_has_children > a'); // Toggle focus each time a menu link is focused or blurred.

    var _iterator4 = _createForOfIteratorHelper(links),
        _step4;

    try {
      for (_iterator4.s(); !(_step4 = _iterator4.n()).done;) {
        var link = _step4.value;
        link.addEventListener('focus', toggleFocus, true);
        link.addEventListener('blur', toggleFocus, true);
      } // Toggle focus each time a menu link with children receive a touch event.

    } catch (err) {
      _iterator4.e(err);
    } finally {
      _iterator4.f();
    }

    var _iterator5 = _createForOfIteratorHelper(linksWithChildren),
        _step5;

    try {
      for (_iterator5.s(); !(_step5 = _iterator5.n()).done;) {
        var _link = _step5.value;

        _link.addEventListener('touchstart', toggleFocus, false);
      }
      /**
       * Sets or removes .focus class on an element.
       */

    } catch (err) {
      _iterator5.e(err);
    } finally {
      _iterator5.f();
    }

    function toggleFocus() {
      if (event.type === 'focus' || event.type === 'blur') {
        var self = this; // Move up through the ancestors of the current link until we hit .nav-menu.

        while (!self.classList.contains('nav-menu')) {
          // On li elements toggle the class .focus.
          if ('li' === self.tagName.toLowerCase()) {
            self.classList.toggle('focus');
          }

          self = self.parentNode;
        }
      }
    }
  }
};
/**
 * Search
 */

voluto.headerSearch = {
  init: function init() {
    var header = document.getElementsByClassName('site-header')[0];
    var menuBar = document.getElementsByClassName('menu-bar')[0];
    var mobile = document.getElementsByClassName('mobile-header')[0];
    var topBar = document.getElementsByClassName('top-bar')[0];
    var searchToggle = document.getElementsByClassName('header-search-controls')[0];
    var searchToggleMobile = mobile.getElementsByClassName('header-search-controls')[0];
    var height = mobile.offsetHeight;

    if (typeof topBar !== 'undefined') {
      var height = height + topBar.offsetHeight;
    }

    if (typeof searchToggle !== 'undefined') {
      var searchOverlayWrapperMobile = mobile.getElementsByClassName('search-overlay-wrapper')[0];
      searchOverlayWrapperMobile.style.top = height + 'px';

      if (typeof menuBar !== 'undefined') {
        var searchOverlayWrapper = menuBar.getElementsByClassName('search-overlay-wrapper')[0];
      } else {
        var searchOverlayWrapper = header.getElementsByClassName('search-overlay-wrapper')[0];
      }

      var searchToggleOn = searchToggle.getElementsByClassName('header-search-toggle')[0];
      var searchToggleOff = searchToggle.getElementsByClassName('header-search-cancel')[0];
      var searchToggleMobileOn = searchToggleMobile.getElementsByClassName('header-search-toggle')[0];
      var searchToggleMobileOff = searchToggleMobile.getElementsByClassName('header-search-cancel')[0];
      searchToggle.addEventListener('click', function (e) {
        e.preventDefault();
        searchOverlayWrapper.classList.toggle('display-search');
        searchToggleOn.classList.toggle('hide');
        searchToggleOff.classList.toggle('hide');
      });
      searchToggle.addEventListener('keyup', function (e) {
        if (e.keyCode === 13) {
          e.preventDefault();
          searchOverlayWrapper.classList.toggle('display-search');
          searchOverlayWrapper.getElementsByClassName('search-field')[0].focus();
        }
      });
      searchOverlayWrapper.getElementsByClassName('search-submit')[0].addEventListener('blur', function (e) {
        searchOverlayWrapper.classList.toggle('display-search');
      });
      searchToggleMobile.addEventListener('click', function (e) {
        e.preventDefault();
        searchOverlayWrapperMobile.classList.toggle('display-search');
        searchToggleMobileOn.classList.toggle('hide');
        searchToggleMobileOff.classList.toggle('hide');
      });
      searchToggleMobile.addEventListener('keyup', function (e) {
        if (e.keyCode === 13) {
          e.preventDefault();
          searchOverlayWrapperMobile.classList.toggle('display-search');
          searchOverlayWrapperMobile.getElementsByClassName('search-field')[0].focus();
        }
      });
      searchOverlayWrapperMobile.getElementsByClassName('search-submit')[0].addEventListener('blur', function (e) {
        searchOverlayWrapperMobile.classList.toggle('display-search');
      });
    }
  }
};
/**
 * Sticky header
 *
 */

voluto.stickyHeader = {
  init: function init() {
    var stickyElm = document.querySelector('.menu-bar');

    if ('undefined' === typeof stickyElm || null === stickyElm) {
      return;
    }

    if (document.body.classList.contains('admin-bar')) {
      var observer = new IntersectionObserver(function (_ref) {
        var e = _ref[0];
        return e.target.classList.toggle('isSticky', e.intersectionRatio < 1);
      }, {
        rootMargin: '-33px 0px 0px 0px',
        threshold: [1]
      });
    } else {
      var observer = new IntersectionObserver(function (_ref) {
        var e = _ref[0];
        return e.target.classList.toggle('isSticky', e.intersectionRatio < 1);
      }, {
        rootMargin: '-1px 0px 0px 0px',
        threshold: [1]
      });
    }

    observer.observe(stickyElm);
  }
};
/**
 * Sidebar cart
 */

voluto.sidebarCart = {
  init: function init() {
    if (window.jQuery) {
      jQuery('body').on('adding_to_cart', function () {
        var sidebarCart = document.getElementsByClassName('sidebar-cart')[0];
        var overlay = document.getElementsByClassName('cart-overlay')[0];
        sidebarCart.classList.add('is-open');
        overlay.classList.add('show-overlay');
      });
      jQuery('.site-header-cart').on('click', function () {
        var sidebarCart = document.getElementsByClassName('sidebar-cart')[0];
        var overlay = document.getElementsByClassName('cart-overlay')[0];
        sidebarCart.classList.add('is-open');
        overlay.classList.add('show-overlay');
      });
      jQuery('.site-header-cart').keypress(function (e) {
        var sidebarCart = document.getElementsByClassName('sidebar-cart')[0];
        var overlay = document.getElementsByClassName('cart-overlay')[0];
        var close = document.getElementsByClassName('sidebar-cart-close')[0];

        if (e.keyCode == 13) {
          sidebarCart.classList.add('is-open');
          overlay.classList.add('show-overlay');
          close.focus();
        }
      });
      jQuery('.sidebar-cart-close').keypress(function (e) {
        var sidebarCart = document.getElementsByClassName('sidebar-cart')[0];
        var overlay = document.getElementsByClassName('cart-overlay')[0];

        if (e.keyCode == 13) {
          sidebarCart.classList.remove('is-open');
          overlay.classList.remove('show-overlay');
        }
      });
      jQuery('.cart-overlay, .sidebar-cart-close .voluto-icon').on('click', function (e) {
        e.preventDefault();
        var sidebarCart = document.getElementsByClassName('sidebar-cart')[0];
        var overlay = document.getElementsByClassName('cart-overlay')[0];
        sidebarCart.classList.remove('is-open');
        overlay.classList.remove('show-overlay');
      });
      jQuery('.cart-overlay').on('click', function () {
        var sidebarCart = document.getElementsByClassName('sidebar-cart')[0];
        var overlay = document.getElementsByClassName('cart-overlay')[0];
        sidebarCart.classList.remove('is-open');
        overlay.classList.remove('show-overlay');
      });
      jQuery(document).keyup(function (e) {
        var sidebarCart = document.getElementsByClassName('sidebar-cart')[0];
        var overlay = document.getElementsByClassName('cart-overlay')[0];

        if (e.keyCode == 27) {
          sidebarCart.classList.remove('is-open');
          overlay.classList.remove('show-overlay');
        }
      });
    }
  }
};
/**
 * Is the DOM ready?
 *
 * This implementation is coming from https://gomakethings.com/a-native-javascript-equivalent-of-jquerys-ready-method/
 *
 * @param {Function} fn Callback function to run.
 */

function volutoDomReady(fn) {
  if (typeof fn !== 'function') {
    return;
  }

  if (document.readyState === 'interactive' || document.readyState === 'complete') {
    return fn();
  }

  document.addEventListener('DOMContentLoaded', fn, false);
}

volutoDomReady(function () {
  voluto.navigation.init();
  voluto.headerSearch.init();
  voluto.stickyHeader.init();
  voluto.sidebarCart.init();
});