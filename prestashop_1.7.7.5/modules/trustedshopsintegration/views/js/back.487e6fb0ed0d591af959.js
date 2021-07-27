/******/ (function(modules) { // webpackBootstrap
/******/ 	// The module cache
/******/ 	var installedModules = {};
/******/
/******/ 	// The require function
/******/ 	function __webpack_require__(moduleId) {
/******/
/******/ 		// Check if module is in cache
/******/ 		if(installedModules[moduleId]) {
/******/ 			return installedModules[moduleId].exports;
/******/ 		}
/******/ 		// Create a new module (and put it into the cache)
/******/ 		var module = installedModules[moduleId] = {
/******/ 			i: moduleId,
/******/ 			l: false,
/******/ 			exports: {}
/******/ 		};
/******/
/******/ 		// Execute the module function
/******/ 		modules[moduleId].call(module.exports, module, module.exports, __webpack_require__);
/******/
/******/ 		// Flag the module as loaded
/******/ 		module.l = true;
/******/
/******/ 		// Return the exports of the module
/******/ 		return module.exports;
/******/ 	}
/******/
/******/
/******/ 	// expose the modules object (__webpack_modules__)
/******/ 	__webpack_require__.m = modules;
/******/
/******/ 	// expose the module cache
/******/ 	__webpack_require__.c = installedModules;
/******/
/******/ 	// identity function for calling harmony imports with the correct context
/******/ 	__webpack_require__.i = function(value) { return value; };
/******/
/******/ 	// define getter function for harmony exports
/******/ 	__webpack_require__.d = function(exports, name, getter) {
/******/ 		if(!__webpack_require__.o(exports, name)) {
/******/ 			Object.defineProperty(exports, name, {
/******/ 				configurable: false,
/******/ 				enumerable: true,
/******/ 				get: getter
/******/ 			});
/******/ 		}
/******/ 	};
/******/
/******/ 	// getDefaultExport function for compatibility with non-harmony modules
/******/ 	__webpack_require__.n = function(module) {
/******/ 		var getter = module && module.__esModule ?
/******/ 			function getDefault() { return module['default']; } :
/******/ 			function getModuleExports() { return module; };
/******/ 		__webpack_require__.d(getter, 'a', getter);
/******/ 		return getter;
/******/ 	};
/******/
/******/ 	// Object.prototype.hasOwnProperty.call
/******/ 	__webpack_require__.o = function(object, property) { return Object.prototype.hasOwnProperty.call(object, property); };
/******/
/******/ 	// __webpack_public_path__
/******/ 	__webpack_require__.p = "";
/******/
/******/ 	// Load entry module and return exports
/******/ 	return __webpack_require__(__webpack_require__.s = 5);
/******/ })
/************************************************************************/
/******/ ([
/* 0 */
/***/ (function(module, exports, __webpack_require__) {

"use strict";
/**
* 2016-2021 Trusted Shops GmbH
*
* NOTICE OF LICENSE
*  @author    PrestaShop SA <contact@prestashop.com>
*  @copyright 2016-2021 Trusted Shops GmbH SA
*  @license   http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
*
*
* Don't forget to prefix your containers with your own identifier
* to avoid any conflicts with others containers.
*/



__webpack_require__(4);

/**
 * Trial modal and Trial expired modal
 *
 * Open/close trial modal on click on element with 'data-toggle-modal' attribute.
 * Also remove potential errors.
 */
$(document).on('click', '[data-toggle-trial]', function (e) {
  $('[data-sign-in]').toggle();
  $('[data-trial]').toggle();
  $('.alert.alert-danger').remove();
});

$(document).on('click', '[data-toggle-expired]', function (e) {
  $('[data-sign-in]').toggle();
  $('[data-expired]').toggle();
});

/**
 * Toggle features
 */
$(document).on('change', '[data-toggle]', function () {
  var toggleAttr = $(this).data('toggle');
  if (toggleAttr == 'tooltip') {
    return;
  }

  $('[data-' + toggleAttr + ']').toggle();
});

/**
 * Toggle expert blocks
 *
 * data-toggle-advanced="trustbadge"
 * data-trustbadge-advanced="on"
 * data-trustbadge-advanced="off"
 */
$(document).on('change', '[data-toggle-advanced]', function () {
  var inputName = $(this).find('input').first().attr('name');
  var inputValue = parseInt($('input[name=' + inputName + ']:checked').val());

  var toggleAttr = $(this).data('toggle-advanced');
  var $elementOn = $('[data-' + toggleAttr + '-advanced="on"]');
  var $elementOff = $('[data-' + toggleAttr + '-advanced="off"]');

  if (!!inputValue) {
    $elementOn.show();
    $elementOff.hide();
  } else {
    $elementOn.hide();
    $elementOff.show();
  }
});

/**
 * When user changes config ('My shop' select), redirect him to the proper page.
 */
$(document).on('change', '#id_ts_config', function () {
  var url = document.URL + '&id_ts_config=' + $(this).val();
  window.location.href = url;
});

/**
 * Toggle bootstrap tooltips
 */
$(document).on('ready', function () {
  $('[data-toggle="tooltip"]').tooltip();
});

/**
 * Wizard
 * for trial users, when hovering a feature overview, we hilight the associated menu button.
 */
$(document).on({
  mouseenter: function mouseenter() {
    var targetAttr = $(this).data('toggle-wizard');
    if (!targetAttr) {
      console.warn('data-toggle-wizard require a value.');
      return;
    }

    // Highlight target element.
    var $targetEl = $('[data-wizard="' + targetAttr + '"]');
    $targetEl.addClass('highlighted');
  },

  mouseleave: function mouseleave() {
    //  Set back to normal highlited item(s).
    $('[data-main-menu]').find('.highlighted').removeClass('highlighted');
  }
}, '[data-toggle-wizard]');$;

/***/ }),
/* 1 */,
/* 2 */
/***/ (function(module, exports) {

// removed by extract-text-webpack-plugin

/***/ }),
/* 3 */
/***/ (function(module, exports) {

// removed by extract-text-webpack-plugin

/***/ }),
/* 4 */
/***/ (function(module, exports, __webpack_require__) {

"use strict";
/**
* 2016-2021 Trusted Shops GmbH
*
* NOTICE OF LICENSE
*  @author    PrestaShop SA <contact@prestashop.com>
*  @copyright 2016-2021 Trusted Shops GmbH SA
*  @license   http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
*
*
* Don't forget to prefix your containers with your own identifier
* to avoid any conflicts with others containers.
*/

/**
 * Trigger history back on click on previous step buttons
 */


$(document).on('click', '[data-history-back]', function (event) {
  event.preventDefault();
  var value = $(this).data('history-back');
  $('[name="invites_step"]').val(value);
  $(this).closest('form').submit();
});

/**
 * Select all inputs
 */
$(document).on('change', '[data-select-all]', function () {
  var isChecked = !!this.checked;
  var $inputs = $(this).closest('form').find('[data-input-to-select]');

  $inputs.each(function () {
    if (this.checked != isChecked) {
      this.checked = isChecked;
      $(this).trigger('change');
    }
  });
});

$(document).on('change', '[data-input-to-select]', function () {
  var selectedInputCount = 0;
  var inputNumber = $('[data-input-to-select]').length;

  $('[data-input-to-select]').each(function () {
    var isChecked = !!this.checked;
    if (isChecked) {
      selectedInputCount++;
    }
  });

  if (selectedInputCount != inputNumber) {
    $('[data-select-all]').removeAttr('checked');
  } else {
    $('[data-select-all]').attr('checked', 'checked');
  }
});

/**
 * Dynamic order number
 */
var invitesNb = 0;
$(document).ready(function () {
  invitesNb = parseInt($('[data-invites-number]').html());
});

$(document).on('change', '[data-invites]', function () {
  var $number = $('[data-invites-number]');
  if (!$number.length) {
    return;
  }

  if ($(this).attr('checked') == 'checked') {
    invitesNb++;
  } else {
    invitesNb--;
  }

  $number.html(invitesNb);
});

/**
 * Progress bar animation
 */
var $breadcrumb = undefined;
var breadcrumbOffset = undefined;
var $progressBar = undefined;

$(document).ready(function () {
  $breadcrumb = $('.breadcrumb-block');
  $progressBar = $('.progress-bar');

  if (!$breadcrumb.length && !$progressBar.length) {
    return;
  }

  $(window).on('resize', resizeProgressBar);

  breadcrumbOffset = $breadcrumb.position().left;
  var $previousStep = $breadcrumb.find('.item.active').prev();
  var previousPos = $previousStep.length ? getProgressBarPos($previousStep) : 0;

  $progressBar.css({ 'width': previousPos });

  var $currentStep = $breadcrumb.find('.item.active');
  var currentPos = getProgressBarPos($currentStep);
  $progressBar.delay(500).animate({ 'width': currentPos }, 1000, function () {});
});

function getProgressBarPos($el) {
  if (!$el.length) {
    return;
  }
  breadcrumbOffset = $breadcrumb.position().left;
  var pos = $el.position().left - breadcrumbOffset + $el.width() / 2 + 20;

  return pos;
}

function resizeProgressBar() {
  var $currentStep = $breadcrumb.find('.item.active');
  if (!$currentStep.length) {
    return;
  }
  $progressBar.stop().dequeue().css({ 'width': getProgressBarPos($currentStep) });
}

/**
 * Set iframe src on click on mail preview button.
 */
$(document).on('click', '[data-iframe-src]', function () {
  var src = $(this).data('iframe-src');
  $('[data-preview-iframe]').attr('src', 'about:blank');
  setTimeout(function () {
    $('[data-preview-iframe]').attr('src', src);
  }, 100);
});

/***/ }),
/* 5 */
/***/ (function(module, exports, __webpack_require__) {

__webpack_require__(0);
__webpack_require__(2);
module.exports = __webpack_require__(3);


/***/ })
/******/ ]);
//# sourceMappingURL=back.487e6fb0ed0d591af959.js.map

$(function(){
  $('input[name="enable_rich_snippets"]').change(function(event) {
    console.log(typeof $(this).val());
    if ($(this).val() === '1') {
      console.log('testtesttest1');
      $('#richsnippets_pages input[type="checkbox"]').each(function(index, el) {
        $(this).removeAttr('disabled');
      });
    } else {
      console.log('testtesttest2');
      $('#richsnippets_pages input[type="checkbox"]').each(function(index, el) {
        $(this).attr({
          'disabled': 'disabled',
          'checked': false
        });
      });
    }
  });

  if ($('input[name="enable_rich_snippets"]').val() === 0) {
    $('#richsnippets_pages input[type="checkbox"]').each(function(index, el) {
      $(this).attr('disabled', 'disabled');
    });
  }
})