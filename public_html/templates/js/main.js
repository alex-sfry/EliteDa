/******/ (() => { // webpackBootstrap
/******/ 	"use strict";
/******/ 	var __webpack_modules__ = ({

/***/ "./src/styles/scss/style.scss":
/*!************************************!*\
  !*** ./src/styles/scss/style.scss ***!
  \************************************/
/***/ (() => {

// extracted by mini-css-extract-plugin


/***/ }),

/***/ "./src/script/commodities.js":
/*!***********************************!*\
  !*** ./src/script/commodities.js ***!
  \***********************************/
/***/ ((__unused_webpack___webpack_module__, __webpack_exports__, __webpack_require__) => {

/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   commoditiesForm: () => (/* binding */ commoditiesForm)
/* harmony export */ });
const commoditiesForm = (loader, removeLoader) => {
  const $form = $('#c-form');
  const $table = $('.c-table');
  removeLoader($table);
  const handleSubmit = e => {
    if (!$form.get(0).checkValidity()) {
      e.preventDefault();
    } else loader($form, $table);
  };
  $form.on('submit', handleSubmit);
};

/***/ }),

/***/ "./src/script/cookiesConsent.js":
/*!**************************************!*\
  !*** ./src/script/cookiesConsent.js ***!
  \**************************************/
/***/ ((__unused_webpack___webpack_module__, __webpack_exports__, __webpack_require__) => {

/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   cookiesConsent: () => (/* binding */ cookiesConsent)
/* harmony export */ });
const cookiesConsent = () => {
  const cookieBox = document.querySelector(".cookies-consent-wrapper");
  const acceptBtn = cookieBox.querySelector("button");
  acceptBtn.addEventListener('click', () => {
    //setting cookie for 1 month, after one month it'll be expired automatically
    document.cookie = "CookieBy=ELIDA; max-age=" + 60 * 60 * 24 * 30;
    if (document.cookie) {
      //if cookie is set
      cookieBox.classList.add("hide"); //hide cookie box
    } else {
      //if cookie not set then alert an error
      alert("Cookie can't be set! Please unblock this site from the cookie setting of your browser.");
    }
  });
  const checkCookie = document.cookie.indexOf("CookieBy=ELIDA"); //checking our cookie
  //if cookie is set then hide the cookie box else show it
  checkCookie === -1 ? cookieBox.classList.remove("hide") : cookieBox.classList.add("hide");
};

/***/ }),

/***/ "./src/script/isValidated.js":
/*!***********************************!*\
  !*** ./src/script/isValidated.js ***!
  \***********************************/
/***/ ((__unused_webpack___webpack_module__, __webpack_exports__, __webpack_require__) => {

/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   isValidated: () => (/* binding */ isValidated)
/* harmony export */ });
const isValidated = (elem, elemLabel) => {
  if (!elem.checkValidity()) {
    setInvalid(elem, elemLabel);
  } else {
    setValid(elem, elemLabel);
  }
};
const setInvalid = (elem, elemLabel) => {
  if ($(elem).attr('pattern') === "[0-9]+") {
    if (elem.validationMessage === 'Please match the requested format.') {
      $("#".concat($(elem).attr('id'), " ~ .invalid-feedback")).text('Only numeric values are allowed');
    } else {
      $("#".concat($(elem).attr('id'), " ~ .invalid-feedback")).text('Field must not be empty');
    }
  }
  $(elemLabel).addClass('text-danger is-invalid');
  $(elem).removeClass('border-dark');
  $(elem).addClass('is-invalid border-2 border-danger');
};
const setValid = (elem, elemLabel) => {
  $(elemLabel).removeClass('text-danger is-invalid');
  $(elem).addClass('border-dark');
  $(elem).removeClass('is-invalid border-2 border-danger');
};

/***/ }),

/***/ "./src/script/matTraders.js":
/*!**********************************!*\
  !*** ./src/script/matTraders.js ***!
  \**********************************/
/***/ ((__unused_webpack___webpack_module__, __webpack_exports__, __webpack_require__) => {

/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   matTraders: () => (/* binding */ matTraders)
/* harmony export */ });
const matTraders = () => {
  const $form = $('#mt-form');
  const handleSubmit = e => {
    if (!$form.get(0).checkValidity()) {
      e.preventDefault();
    }
  };
  $form.on('submit', handleSubmit);
};

/***/ }),

/***/ "./src/script/shipModules.js":
/*!***********************************!*\
  !*** ./src/script/shipModules.js ***!
  \***********************************/
/***/ ((__unused_webpack___webpack_module__, __webpack_exports__, __webpack_require__) => {

/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   shipModulesForm: () => (/* binding */ shipModulesForm)
/* harmony export */ });
const shipModulesForm = (loader, removeLoader) => {
  const $form = $('#mod-form');
  const $table = $('.mod-table');
  removeLoader($table);
  const handleSubmit = e => {
    if (!$form.get(0).checkValidity()) {
      e.preventDefault();
    } else loader($form, $table);
  };
  $form.on('submit', handleSubmit);
};

/***/ }),

/***/ "./src/script/ships.js":
/*!*****************************!*\
  !*** ./src/script/ships.js ***!
  \*****************************/
/***/ ((__unused_webpack___webpack_module__, __webpack_exports__, __webpack_require__) => {

/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   shipsForm: () => (/* binding */ shipsForm)
/* harmony export */ });
const shipsForm = (isValidated, loader, removeLoader) => {
  const $form = $('#ships-form');
  const $table = $('.ships-table');
  const shipSelectLabel = $('label[for=\'c-hiddenSelect\']').get(0);
  const shipSelect = $('#c-hiddenSelect').get(0);
  removeLoader($table);
  const handleSubmit = e => {
    if (!$form.get(0).checkValidity()) {
      e.preventDefault();
    } else loader($form, $table);
    isValidated(shipSelect, shipSelectLabel);
  };
  $form.on('submit', handleSubmit);
};

/***/ }),

/***/ "./src/script/tradeRoutes.js":
/*!***********************************!*\
  !*** ./src/script/tradeRoutes.js ***!
  \***********************************/
/***/ ((__unused_webpack___webpack_module__, __webpack_exports__, __webpack_require__) => {

/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   tradeRouteForm: () => (/* binding */ tradeRouteForm)
/* harmony export */ });
const tradeRouteForm = (isValidated, loader, removeLoader) => {
  const $form = $('#tr-form');
  const $trRoute = $('.tr-route');
  removeLoader($trRoute);
  const handleSubmit = e => {
    const cargoSpaceLabel = $('label[for=\'cargo\']').get(0);
    const cargoSpace = $('#cargo').get(0);
    const profitLabel = $('label[for=\'profit\']').get(0);
    const profit = $('#profit').get(0);
    if (!$form.get(0).checkValidity()) {
      e.preventDefault();
    } else loader($form, $trRoute);
    isValidated(cargoSpace, cargoSpaceLabel);
    isValidated(profit, profitLabel);
  };
  $('.btn-copy').on('click', function () {
    navigator.clipboard.writeText($(this).siblings('.table-link-tr').text());
    $(this).text('copied').addClass('btn-copy-active');
    $(".btn-copy:contains('copied')").not(this).text('copy').removeClass('btn-copy-active');
  });
  $form.on('submit', e => handleSubmit(e));
};

/***/ })

/******/ 	});
/************************************************************************/
/******/ 	// The module cache
/******/ 	var __webpack_module_cache__ = {};
/******/ 	
/******/ 	// The require function
/******/ 	function __webpack_require__(moduleId) {
/******/ 		// Check if module is in cache
/******/ 		var cachedModule = __webpack_module_cache__[moduleId];
/******/ 		if (cachedModule !== undefined) {
/******/ 			return cachedModule.exports;
/******/ 		}
/******/ 		// Create a new module (and put it into the cache)
/******/ 		var module = __webpack_module_cache__[moduleId] = {
/******/ 			// no module.id needed
/******/ 			// no module.loaded needed
/******/ 			exports: {}
/******/ 		};
/******/ 	
/******/ 		// Execute the module function
/******/ 		__webpack_modules__[moduleId](module, module.exports, __webpack_require__);
/******/ 	
/******/ 		// Return the exports of the module
/******/ 		return module.exports;
/******/ 	}
/******/ 	
/************************************************************************/
/******/ 	/* webpack/runtime/define property getters */
/******/ 	(() => {
/******/ 		// define getter functions for harmony exports
/******/ 		__webpack_require__.d = (exports, definition) => {
/******/ 			for(var key in definition) {
/******/ 				if(__webpack_require__.o(definition, key) && !__webpack_require__.o(exports, key)) {
/******/ 					Object.defineProperty(exports, key, { enumerable: true, get: definition[key] });
/******/ 				}
/******/ 			}
/******/ 		};
/******/ 	})();
/******/ 	
/******/ 	/* webpack/runtime/hasOwnProperty shorthand */
/******/ 	(() => {
/******/ 		__webpack_require__.o = (obj, prop) => (Object.prototype.hasOwnProperty.call(obj, prop))
/******/ 	})();
/******/ 	
/************************************************************************/
var __webpack_exports__ = {};
// This entry need to be wrapped in an IIFE because it need to be isolated against other modules in the chunk.
(() => {
/*!****************************!*\
  !*** ./src/script/main.js ***!
  \****************************/
/* harmony import */ var _styles_scss_style_scss__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ../styles/scss/style.scss */ "./src/styles/scss/style.scss");
/* harmony import */ var _isValidated_js__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./isValidated.js */ "./src/script/isValidated.js");
/* harmony import */ var _commodities_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./commodities.js */ "./src/script/commodities.js");
/* harmony import */ var _shipModules_js__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! ./shipModules.js */ "./src/script/shipModules.js");
/* harmony import */ var _ships_js__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! ./ships.js */ "./src/script/ships.js");
/* harmony import */ var _tradeRoutes_js__WEBPACK_IMPORTED_MODULE_5__ = __webpack_require__(/*! ./tradeRoutes.js */ "./src/script/tradeRoutes.js");
/* harmony import */ var _matTraders_js__WEBPACK_IMPORTED_MODULE_6__ = __webpack_require__(/*! ./matTraders.js */ "./src/script/matTraders.js");
/* harmony import */ var _cookiesConsent_js__WEBPACK_IMPORTED_MODULE_7__ = __webpack_require__(/*! ./cookiesConsent.js */ "./src/script/cookiesConsent.js");

// import '../styles/bootstrapSCSS/bootstrap.scss';
// import { fetchData } from './fetchData.js';







// import {getDataFromDom} from './addToDb.js';

(0,_cookiesConsent_js__WEBPACK_IMPORTED_MODULE_7__.cookiesConsent)();
const initHeader = () => {
  $('.menu__link').each(function () {
    if ($(this).attr('href') === window.location.pathname) {
      $(this).addClass('active');
      $(this).closest('.menu__item').children('.menu__link').addClass('active');
    } else {
      $(this).removeClass('active');
      $(this).closest('.menu__link').removeClass('active');
    }
  });
};
const initFooter = () => {
  $('.footer__link').each(function () {
    if ($(this).attr('href') === window.location.pathname || window.location.pathname.includes($(this).attr('href'))) {
      $(this).addClass('active');
    } else {
      $(this).removeClass('active');
    }
  });
};
const loader = ($insertElem, $hideElem) => {
  $insertElem.after("<div class='c-loading my-0 mx-auto text-light bg-info rounded-2 px-3 py-1 fw-bold'>" + "Loading . . .</div>");
  if ($hideElem.length) {
    $hideElem.addClass('d-none');
    $('.c-pagination-cnt').addClass('d-none');
    $('.c-result-legend').addClass('d-none');
  }
};
const removeLoader = $elem => {
  if ($elem.length) {
    const $loadingPlaceholder = $('.c-loading');
    $loadingPlaceholder.length && $loadingPlaceholder.remove();
  }
};
document.addEventListener('DOMContentLoaded', () => {
  initHeader();
  initFooter();
  if ($('#c-form').length) (0,_commodities_js__WEBPACK_IMPORTED_MODULE_2__.commoditiesForm)(loader, removeLoader);
  if ($('#mod-form').length) (0,_shipModules_js__WEBPACK_IMPORTED_MODULE_3__.shipModulesForm)(loader, removeLoader);
  if ($('#ships-form').length) (0,_ships_js__WEBPACK_IMPORTED_MODULE_4__.shipsForm)(_isValidated_js__WEBPACK_IMPORTED_MODULE_1__.isValidated, loader, removeLoader);
  if ($('#tr-form').length) (0,_tradeRoutes_js__WEBPACK_IMPORTED_MODULE_5__.tradeRouteForm)(_isValidated_js__WEBPACK_IMPORTED_MODULE_1__.isValidated, loader, removeLoader);
  if ($('#mt-form').length) (0,_matTraders_js__WEBPACK_IMPORTED_MODULE_6__.matTraders)();
  $('#accordionForm .accordion-button').on('click', function () {
    if ($(this).text().trim() === 'Close form') {
      $(this).text('Open form');
    } else if ($(this).text().trim() === 'Open form') {
      $(this).text('Close form');
    }
  });
  if ($('#w0'.length > 0)) {
    const $filterBtns = $('.filters .btn');
    $filterBtns.on('click', function () {
      $filterBtns.prev().trigger('change.yiiGridView');
    });
    $('.filters input').on('change', function () {
      return false;
    });
  }

  // if ($('.add-to-db').length) getDataFromDom(fetchData);
});
})();

/******/ })()
;
//# sourceMappingURL=main.js.map