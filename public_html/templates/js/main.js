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
      $form.addClass('was-validated');
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
/* harmony export */   validate: () => (/* binding */ validate)
/* harmony export */ });
const validate = elem => {
  if ($(elem).attr('pattern') === "[0-9]+") {
    if (elem.validationMessage === 'Please match the requested format.') {
      $(`#${$(elem).attr('id')} ~ .invalid-feedback`).text('Only numeric values are allowed');
    } else {
      $(`#${$(elem).attr('id')} ~ .invalid-feedback`).text('Field must not be empty');
    }
  }
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
      $form.addClass('was-validated');
      e.preventDefault();
    }
  };
  $form.on('submit', handleSubmit);
};

/***/ }),

/***/ "./src/script/rings.js":
/*!*****************************!*\
  !*** ./src/script/rings.js ***!
  \*****************************/
/***/ ((__unused_webpack___webpack_module__, __webpack_exports__, __webpack_require__) => {

/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   ringsForm: () => (/* binding */ ringsForm)
/* harmony export */ });
/* harmony import */ var _tSelectSettings_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./tSelectSettings.js */ "./src/script/tSelectSettings.js");

const ringsForm = (loader, removeLoader) => {
  // eslint-disable-next-line no-undef, no-unused-vars
  const tSelect = new TomSelect("#refSystem", (0,_tSelectSettings_js__WEBPACK_IMPORTED_MODULE_0__.tSelectRingsSettings)({
    searchField: 'system',
    valueField: 'system',
    labelField: 'system',
    plugins: ['dropdown_input'],
    endpoint: '/system/get/'
  }));
  const $form = $("#rings-form");
  const $table = $(".rings-table");
  removeLoader($table);
  const handleSubmit = e => {
    if (!$form.get(0).checkValidity()) {
      e.preventDefault();
      $form.addClass("was-validated");
    } else loader($form, $table);
  };
  $form.on("submit", handleSubmit);

  // fix for TomSelect label bug (id, for)
  $('.tselect-lbl-1').attr('for', 'refSystem');
  $('.tselect-lbl-1').removeAttr('id');
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
      $form.addClass('was-validated');
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
const shipsForm = (loader, removeLoader) => {
  const $form = $('#ships-form');
  const $table = $('.ships-table');
  // const shipSelectLabel = $('label[for=\'c-hiddenSelect\']').get(0);
  // const shipSelect = $('#c-hiddenSelect').get(0);
  removeLoader($table);
  const handleSubmit = e => {
    if (!$form.get(0).checkValidity()) {
      $form.addClass('was-validated');
      e.preventDefault();
    } else loader($form, $table);
  };
  $form.on('submit', handleSubmit);
};

/***/ }),

/***/ "./src/script/sortIcons.js":
/*!*********************************!*\
  !*** ./src/script/sortIcons.js ***!
  \*********************************/
/***/ ((__unused_webpack___webpack_module__, __webpack_exports__, __webpack_require__) => {

/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   getSortIcon: () => (/* binding */ getSortIcon)
/* harmony export */ });
const getSortIcon = icon => {
  const sortAsc = `
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi        bi-sort-up" viewBox="0 0 16 16">
    <path d="M3.5 12.5a.5.5 0 0 1-1 0V3.707L1.354 4.854a.5.5 0 1 1-.708-.708l2-1.999.007-.007a.5.5 0 0 1 .7.006l2 2a.5.5 0 1 1-.707.708L3.5 3.707zm3.5-9a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 0 1h-7a.5.5 0 0 1-.5-.5M7.5 6a.5.5 0 0 0 0 1h5a.5.5 0 0 0 0-1zm0 3a.5.5 0 0 0 0 1h3a.5.5 0 0 0 0-1zm0 3a.5.5 0 0 0 0 1h1a.5.5 0 0 0 0-1z"/>
    </svg>
    `;
  const sortDesc = `
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-sort-down" viewBox="0 0 16 16">
    <path d="M3.5 2.5a.5.5 0 0 0-1 0v8.793l-1.146-1.147a.5.5 0 0 0-.708.708l2 1.999.007.007a.497.497 0 0 0 .7-.006l2-2a.5.5 0 0 0-.707-.708L3.5 11.293zm3.5 1a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 0 1h-7a.5.5 0 0 1-.5-.5M7.5 6a.5.5 0 0 0 0 1h5a.5.5 0 0 0 0-1zm0 3a.5.5 0 0 0 0 1h3a.5.5 0 0 0 0-1zm0 3a.5.5 0 0 0 0 1h1a.5.5 0 0 0 0-1z"/>
    </svg>
    `;
  const hourGlass = `
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-hourglass" viewBox="0 0 16 16">
    <path d="M2 1.5a.5.5 0 0 1 .5-.5h11a.5.5 0 0 1 0 1h-1v1a4.5 4.5 0 0 1-2.557 4.06c-.29.139-.443.377-.443.59v.7c0 .213.154.451.443.59A4.5 4.5 0 0 1 12.5 13v1h1a.5.5 0 0 1 0 1h-11a.5.5 0 1 1 0-1h1v-1a4.5 4.5 0 0 1 2.557-4.06c.29-.139.443-.377.443-.59v-.7c0-.213-.154-.451-.443-.59A4.5 4.5 0 0 1 3.5 3V2h-1a.5.5 0 0 1-.5-.5m2.5.5v1a3.5 3.5 0 0 0 1.989 3.158c.533.256 1.011.791 1.011 1.491v.702c0 .7-.478 1.235-1.011 1.491A3.5 3.5 0 0 0 4.5 13v1h7v-1a3.5 3.5 0 0 0-1.989-3.158C8.978 9.586 8.5 9.052 8.5 8.351v-.702c0-.7.478-1.235 1.011-1.491A3.5 3.5 0 0 0 11.5 3V2z"/>
    </svg>
    `;
  switch (icon) {
    case 'asc':
      return sortAsc;
    case 'desc':
      return sortDesc;
    case 'hourGlass':
      return hourGlass;
    default:
      return hourGlass;
  }
};

/***/ }),

/***/ "./src/script/tSelectSettings.js":
/*!***************************************!*\
  !*** ./src/script/tSelectSettings.js ***!
  \***************************************/
/***/ ((__unused_webpack___webpack_module__, __webpack_exports__, __webpack_require__) => {

/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   tSelectRingsSettings: () => (/* binding */ tSelectRingsSettings)
/* harmony export */ });
const tSelectRingsSettings = config => {
  return {
    searchField: config.searchField,
    valueField: config.valueField,
    labelField: config.labelField,
    plugins: config.plugins,
    sortField: [{
      field: '$order'
    }, {
      field: '$score'
    }],
    loadThrottle: 500,
    hideSelected: true,
    highlight: false,
    shouldLoad: query => query.length < 2 ? false : true,
    load: async function (query, callback) {
      console.log(query);
      this.clearOptions();
      try {
        const response = await fetch(`${config.endpoint}${query}`);
        if (response.ok) {
          callback(await response.json());
        } else {
          console.log('fetch error');
        }
      } catch (error) {
        console.log(error.message);
        callback();
      }
    }
  };
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
const tradeRouteForm = (validate, loader, removeLoader) => {
  const $form = $('#tr-form');
  const $trRoute = $('.tr-route');
  removeLoader($trRoute);
  const handleSubmit = e => {
    const cargoSpace = $('#cargo').get(0);
    const profit = $('#profit').get(0);
    if (!$form.get(0).checkValidity()) {
      $('#tr-form').addClass('was-validated');
      e.preventDefault();
    } else loader($form, $trRoute);
    validate(cargoSpace);
    validate(profit);
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
/* harmony import */ var _rings_js__WEBPACK_IMPORTED_MODULE_8__ = __webpack_require__(/*! ./rings.js */ "./src/script/rings.js");
/* harmony import */ var _sortIcons_js__WEBPACK_IMPORTED_MODULE_9__ = __webpack_require__(/*! ./sortIcons.js */ "./src/script/sortIcons.js");

// import '../styles/bootstrapSCSS/bootstrap.scss';









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
  if ($('#ships-form').length) (0,_ships_js__WEBPACK_IMPORTED_MODULE_4__.shipsForm)(loader, removeLoader);
  if ($('#tr-form').length) (0,_tradeRoutes_js__WEBPACK_IMPORTED_MODULE_5__.tradeRouteForm)(_isValidated_js__WEBPACK_IMPORTED_MODULE_1__.validate, loader, removeLoader);
  if ($('#mt-form').length) (0,_matTraders_js__WEBPACK_IMPORTED_MODULE_6__.matTraders)();
  if ($('#rings-form').length) (0,_rings_js__WEBPACK_IMPORTED_MODULE_8__.ringsForm)(loader, removeLoader);
  $('#accordionForm .accordion-button').on('click', function () {
    if ($(this).text().trim() === 'Close form') {
      $(this).text('Open form');
    } else if ($(this).text().trim() === 'Open form') {
      $(this).text('Close form');
    }
  });
  $('table th.sortable > a').each(function () {
    const $elem = $(this);
    $elem.hasClass('asc') && $elem.append((0,_sortIcons_js__WEBPACK_IMPORTED_MODULE_9__.getSortIcon)('asc'));
    $elem.hasClass('desc') && $elem.append((0,_sortIcons_js__WEBPACK_IMPORTED_MODULE_9__.getSortIcon)('desc'));
    !$elem.hasClass('asc') && !$elem.hasClass('desc') && $elem.append((0,_sortIcons_js__WEBPACK_IMPORTED_MODULE_9__.getSortIcon)('hourGlass'));
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
/******/ })()
;
//# sourceMappingURL=main.js.map