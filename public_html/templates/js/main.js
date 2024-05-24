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

/***/ "./src/script/Pagination.js":
/*!**********************************!*\
  !*** ./src/script/Pagination.js ***!
  \**********************************/
/***/ ((__unused_webpack___webpack_module__, __webpack_exports__, __webpack_require__) => {

/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   Pagination: () => (/* binding */ Pagination)
/* harmony export */ });
function Pagination(maxPageBtnQty, fetchData) {
  let paginationHTML = arguments.length > 2 && arguments[2] !== undefined ? arguments[2] : null;
  let table = arguments.length > 3 && arguments[3] !== undefined ? arguments[3] : null;
  this.fetchData = fetchData;
  this.maxPageBtnQty = maxPageBtnQty;
  this.paginationHTML = paginationHTML;
  this.data = null;
  this.table = table;
}
Pagination.prototype.getCurrentDataPage = function () {
  return $('li.active > a').attr('data-page');
};
Pagination.prototype.renderNewPageBtns = function (links, next, last, current, totalCount, limit, maxPageBtnQty) {
  const $pageNumBtns = $('li > .page-link');
  const pageBtnFirstNum = parseInt($pageNumBtns.eq(2).attr('data-page')) + 1;
  const pageBtnLastNum = parseInt($pageNumBtns.eq($pageNumBtns.length - 3).attr('data-page')) + 1;
  const clsBegin = next === 1 ? 'page-link disabled' : 'page-link';
  const clsEnd = next === last ? 'page-link disabled' : 'page-link';
  const pageBtnQty = maxPageBtnQty <= last ? maxPageBtnQty : last;
  let html = "<li class=\"page-item first\"><a class=\"".concat(clsBegin, "\" href=\"").concat(links.first, "\" data-page=\"0\">first</a></li>");
  html += "<li class=\"page-item prev-page\">\n                <a class=\"".concat(clsBegin, "\" href=\"").concat(links.prev, "\" data-page=\"").concat(next - 1, "\">\n                    <span aria-hidden=\"true\">\xAB</span>\n                </a>\n            </li>");
  for (let i = 0; i < pageBtnQty; i++) {
    const href = links.first.substring(0, links.first.length - 1);
    let pageNum;
    if (next > current) {
      if (next >= last - 1) {
        pageNum = last - (pageBtnQty - 1) + i;
      } else pageNum = pageBtnLastNum - next < 2 ? next - (pageBtnQty - 3) + i : pageBtnFirstNum + i;
    } else {
      if (next <= 2) {
        pageNum = 1 + i;
      } else pageNum = next - pageBtnFirstNum < 2 ? next - 2 + i : pageBtnFirstNum + i;
    }
    const cls = pageNum === next ? 'page-item active' : 'page-item';
    html += "<li class=\"".concat(cls, "\">\n                        <a class=\"page-link\" href=\"").concat(href).concat(pageNum, "\" data-page=\"").concat(pageNum - 1, "\">").concat(pageNum, "</a>\n                    </li>");
  }
  html += "<li class=\"page-item next-page\">\n                    <a class=\"".concat(clsEnd, "\" href=\"").concat(links.next, "\" data-page=\"").concat(next - 1, "\">\n                        <span aria-hidden=\"true\">\xBB</span>\n                    </a>\n                </li>");
  html += "<li class=\"page-item last\">\n                    <a class=\"".concat(clsEnd, "\" href=\"").concat(links.last, "\" data-page=\"").concat(last - 1, "\">last</a>\n                </li>");
  $('.pagination').html(html);
  $('.page-counter').text("".concat(this.getCurrentDataPage() * limit + 1, " \n       - ").concat(next * limit < totalCount ? next * limit : totalCount, " / ").concat(totalCount));
  this.setEventListeners();
};
Pagination.prototype.handleClick = async function (e) {
  e.preventDefault();
  if ($(e.currentTarget).parent().is('.active')) return;
  const data = await this.fetchData($(e.currentTarget).attr('href'));
  this.data = data;
  console.log('pagination', data);
  this.renderNewPageBtns(data.links, data.page + 1,
  // zero based next page received from backend + 1
  data.lastPage, this.getCurrentDataPage(),
  // zero based current page
  data.totalCount, data.limit,
  // qty per page
  this.maxPageBtnQty);
};
Pagination.prototype.resetPagination = function (limit, totalCount, links, lastPage) {
  $('.page-counter').text("".concat(0 * limit + 1, " - ").concat(1 * limit, " / ").concat(totalCount));
  this.renderNewPageBtns(links, 1,
  // zero based next page received from backend + 1
  lastPage, 0,
  // zero based current page
  totalCount, limit,
  // qty per page
  this.maxPageBtnQty);
  this.setEventListeners();
};
Pagination.prototype.setEventListeners = function () {
  $('.page-item > .page-link').on('click', e => this.handleClick(e));
};

/***/ }),

/***/ "./src/script/SortTable.js":
/*!*********************************!*\
  !*** ./src/script/SortTable.js ***!
  \*********************************/
/***/ ((__unused_webpack___webpack_module__, __webpack_exports__, __webpack_require__) => {

/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   SortTable: () => (/* binding */ SortTable)
/* harmony export */ });
function SortTable(cnt, fetchData) {
  let table = arguments.length > 2 && arguments[2] !== undefined ? arguments[2] : null;
  let pagination = arguments.length > 3 && arguments[3] !== undefined ? arguments[3] : null;
  this.cnt = cnt;
  this.pagination = pagination;
  this.fetchData = fetchData;
  this.data = null;
  this.table = table;
}
SortTable.prototype.handleClick = async function (e) {
  e.preventDefault();
  const data = await this.fetchData($(e.currentTarget).attr('href'));
  this.data = data;
  this.pagination && this.pagination.resetPagination.apply(this.pagination, [data.limit, data.totalCount, data.links, data.lastPage]);
  $('a.sort').removeClass(['asc', 'desc', 'sorted']);
  if (Object.values(data.attributeOrders)[0] === 4) {
    $(e.currentTarget).addClass(['sorted', 'asc']);
  } else $(e.currentTarget).addClass(['sorted', 'desc']);
  $(e.currentTarget).attr('href', data.sortUrl);
};
SortTable.prototype.setEventListeners = function () {
  $(this.cnt + ' .sort').on('click', e => this.handleClick(e));
};

/***/ }),

/***/ "./src/script/Table.js":
/*!*****************************!*\
  !*** ./src/script/Table.js ***!
  \*****************************/
/***/ ((__unused_webpack___webpack_module__, __webpack_exports__, __webpack_require__) => {

/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   Table: () => (/* binding */ Table)
/* harmony export */ });
function Table(cnt, columns) {
  this.cnt = cnt;
  this.columns = columns;
}
Table.prototype.getRows = function () {
  return $("#".concat(this.cnt, " tbody tr"));
};
Table.prototype.fillTable = function (data) {
  const actualColumns = [];
  this.columns.forEach(item => {
    if (item in data[0]) actualColumns.push(item);
  });
  this.getRows().each(function (rowIndex) {
    if (!data[rowIndex]) {
      $(this).hide();
      return;
    }
    if ($(this).is(":hidden")) $(this).show();
    $(this).find('td').each(function (cellIndex) {
      const newRowData = data[rowIndex][actualColumns[cellIndex]];
      if (typeof newRowData === 'object') {
        if ('url' in newRowData) {
          $(this).html("<a href=\"".concat(newRowData['url'], "\">\n                            ").concat(newRowData['text'], "</a>"));
        }
      } else $(this).text(newRowData);
    });
  });
};

/***/ }),

/***/ "./src/script/commodities.js":
/*!***********************************!*\
  !*** ./src/script/commodities.js ***!
  \***********************************/
/***/ ((__unused_webpack___webpack_module__, __webpack_exports__, __webpack_require__) => {

/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   commoditiesForm: () => (/* binding */ commoditiesForm)
/* harmony export */ });
/* harmony import */ var _Pagination_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./Pagination.js */ "./src/script/Pagination.js");
/* harmony import */ var _SortTable_js__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./SortTable.js */ "./src/script/SortTable.js");
/* harmony import */ var _Table_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./Table.js */ "./src/script/Table.js");



const commoditiesForm = (loader, removeLoader, fetchData) => {
  const $form = $('#c-form');
  const $table = $('.c-table');
  const $pagination = $('.pagination');
  removeLoader($table);
  const handleSubmit = e => {
    if (!$form.get(0).checkValidity()) {
      e.preventDefault();
    } else loader($form, $table);
  };
  $form.on('submit', handleSubmit);
  const table = new _Table_js__WEBPACK_IMPORTED_MODULE_2__.Table('c-table', ['commodity', 'station', 'type', 'pad', 'system', 'distance_ly', 'distance_ls', 'stock', 'demand', 'sell_price', 'buy_price', 'time_diff']);
  const proxyHandler = {
    set(target, prop, val) {
      if (prop === "data") {
        table.fillTable(val.data);
        return true;
      }
      return true;
    }
  };
  const pagination = $pagination.length ? new Proxy(new _Pagination_js__WEBPACK_IMPORTED_MODULE_0__.Pagination(7, fetchData, $pagination.html(), table), proxyHandler) : null;
  const sortTable = $pagination.length ? new Proxy(new _SortTable_js__WEBPACK_IMPORTED_MODULE_1__.SortTable('.c-table', fetchData, table, pagination), proxyHandler) : new Proxy(new _SortTable_js__WEBPACK_IMPORTED_MODULE_1__.SortTable('.c-table', fetchData, table), proxyHandler);
  pagination && pagination.setEventListeners();
  sortTable && sortTable.setEventListeners();
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

/***/ "./src/script/fetchData.js":
/*!*********************************!*\
  !*** ./src/script/fetchData.js ***!
  \*********************************/
/***/ ((__unused_webpack___webpack_module__, __webpack_exports__, __webpack_require__) => {

/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   fetchData: () => (/* binding */ fetchData)
/* harmony export */ });
const fetchData = async function (url) {
  let method = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : 'GET';
  let body = arguments.length > 2 && arguments[2] !== undefined ? arguments[2] : null;
  let loaderCnt = arguments.length > 3 && arguments[3] !== undefined ? arguments[3] : null;
  loaderCnt && enableLoader(loaderCnt);
  try {
    const res = await fetch(url, {
      method: method,
      mode: 'cors',
      // this cannot be 'no-cors'
      headers: {
        'Accept': 'application/json',
        'Content-Type': 'application/json'
      },
      body: body
    });
    if (res.ok) {
      return await res.json();
    } else {
      console.log('fetch error');
    }
  } catch (error) {
    console.log(error.message);
  } finally {
    loaderCnt && disableLoader(loaderCnt);
  }
};
function enableLoader(loaderCnt) {
  if (loaderCnt !== '') {
    $(loaderCnt).addClass('opacity-25');
  }
}
function disableLoader(loaderCnt) {
  $(loaderCnt).removeClass('opacity-25');
}

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
  elemLabel.classList.add('text-danger', 'is-invalid');
  elem.classList.remove('border-dark');
  elem.classList.add('is-invalid', 'border-2', 'border-danger');
};
const setValid = (elem, elemLabel) => {
  elemLabel.classList.remove('text-danger', 'is-invalid');
  elem.classList.add('border-dark');
  elem.classList.remove('is-invalid', 'border-2', 'border-danger');
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
/* harmony import */ var _Pagination_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./Pagination.js */ "./src/script/Pagination.js");
/* harmony import */ var _SortTable_js__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./SortTable.js */ "./src/script/SortTable.js");
/* harmony import */ var _Table_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./Table.js */ "./src/script/Table.js");



const shipModulesForm = (loader, removeLoader, fetchData) => {
  const $form = $('#mod-form');
  const $table = $('.mod-table');
  const $pagination = $('.pagination');
  removeLoader($table);
  const handleSubmit = e => {
    if (!$form.get(0).checkValidity()) {
      e.preventDefault();
    } else loader($form, $table);
  };
  $form.on('submit', handleSubmit);
  const table = new _Table_js__WEBPACK_IMPORTED_MODULE_2__.Table('mod-table', ['module', 'station', 'type', 'pad', 'system', 'distance_ly', 'distance_ls', 'price', 'time_diff']);
  const proxyHandler = {
    set(target, prop, val) {
      if (prop === "data") {
        table.fillTable(val.data);
        return true;
      }
      return true;
    }
  };
  const pagination = $pagination.length ? new Proxy(new _Pagination_js__WEBPACK_IMPORTED_MODULE_0__.Pagination(7, fetchData, $pagination.html(), table), proxyHandler) : null;
  const sortTable = $pagination.length ? new Proxy(new _SortTable_js__WEBPACK_IMPORTED_MODULE_1__.SortTable('.mod-table', fetchData, table, pagination), proxyHandler) : new Proxy(new _SortTable_js__WEBPACK_IMPORTED_MODULE_1__.SortTable('.mod-table', fetchData, table), proxyHandler);
  pagination && pagination.setEventListeners();
  sortTable && sortTable.setEventListeners();
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
/* harmony import */ var _Pagination_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./Pagination.js */ "./src/script/Pagination.js");
/* harmony import */ var _SortTable_js__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./SortTable.js */ "./src/script/SortTable.js");
/* harmony import */ var _Table_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./Table.js */ "./src/script/Table.js");



const shipsForm = (isValidated, loader, removeLoader, fetchData) => {
  const $form = $('#ships-form');
  const $table = $('.ships-table');
  const $pagination = $('.pagination');
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
  const table = new _Table_js__WEBPACK_IMPORTED_MODULE_2__.Table('ships-table', ['ship', 'station', 'type', 'pad', 'system', 'distance_ly', 'distance_ls', 'price', 'time_diff']);
  const proxyHandler = {
    set(target, prop, val) {
      if (prop === "data") {
        table.fillTable(val.data);
        return true;
      }
      return true;
    }
  };
  const pagination = $pagination.length ? new Proxy(new _Pagination_js__WEBPACK_IMPORTED_MODULE_0__.Pagination(7, fetchData, $pagination.html(), table), proxyHandler) : null;
  const sortTable = $pagination.length ? new Proxy(new _SortTable_js__WEBPACK_IMPORTED_MODULE_1__.SortTable('.ships-table', fetchData, table, pagination), proxyHandler) : new Proxy(new _SortTable_js__WEBPACK_IMPORTED_MODULE_1__.SortTable('.ships-table', fetchData, table), proxyHandler);
  pagination && pagination.setEventListeners();
  sortTable && sortTable.setEventListeners();
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
  $form.on('submit', e => handleSubmit(e));

  // const observer = new MutationObserver(handleSelectedSysChange);
  // observer.observe(selectedSys, {childList: true});
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
/* harmony import */ var _fetchData_js__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./fetchData.js */ "./src/script/fetchData.js");
/* harmony import */ var _isValidated_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./isValidated.js */ "./src/script/isValidated.js");
/* harmony import */ var _commodities_js__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! ./commodities.js */ "./src/script/commodities.js");
/* harmony import */ var _shipModules_js__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! ./shipModules.js */ "./src/script/shipModules.js");
/* harmony import */ var _ships_js__WEBPACK_IMPORTED_MODULE_5__ = __webpack_require__(/*! ./ships.js */ "./src/script/ships.js");
/* harmony import */ var _tradeRoutes_js__WEBPACK_IMPORTED_MODULE_6__ = __webpack_require__(/*! ./tradeRoutes.js */ "./src/script/tradeRoutes.js");
/* harmony import */ var _matTraders_js__WEBPACK_IMPORTED_MODULE_7__ = __webpack_require__(/*! ./matTraders.js */ "./src/script/matTraders.js");
/* harmony import */ var _cookiesConsent_js__WEBPACK_IMPORTED_MODULE_8__ = __webpack_require__(/*! ./cookiesConsent.js */ "./src/script/cookiesConsent.js");

// import '../styles/bootstrapSCSS/bootstrap.scss';








// import {getDataFromDom} from './addToDb.js';

(0,_cookiesConsent_js__WEBPACK_IMPORTED_MODULE_8__.cookiesConsent)();
const initHeader = () => {
  $('.menu__link').each(function () {
    if ($(this).attr('href') === window.location.pathname || window.location.pathname.includes($(this).attr('href'))) {
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
      // $(this).closest('.menu__item').children('.menu__link').addClass('active');
    } else {
      $(this).removeClass('active');
      // $(this).closest('.menu__link').removeClass('active');
    }
  });
};
const loader = ($insertElem, $hideElem) => {
  $insertElem.after("<div class='c-loading my-0 mx-auto text-light bg-light-orange rounded-2 px-3 py-1 fw-bold'>" + "Loading . . .</div>");
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
  if ($('#c-form').length) (0,_commodities_js__WEBPACK_IMPORTED_MODULE_3__.commoditiesForm)(loader, removeLoader, _fetchData_js__WEBPACK_IMPORTED_MODULE_1__.fetchData);
  if ($('#mod-form').length) (0,_shipModules_js__WEBPACK_IMPORTED_MODULE_4__.shipModulesForm)(loader, removeLoader, _fetchData_js__WEBPACK_IMPORTED_MODULE_1__.fetchData);
  if ($('#ships-form').length) (0,_ships_js__WEBPACK_IMPORTED_MODULE_5__.shipsForm)(_isValidated_js__WEBPACK_IMPORTED_MODULE_2__.isValidated, loader, removeLoader, _fetchData_js__WEBPACK_IMPORTED_MODULE_1__.fetchData);
  if ($('#tr-form').length) (0,_tradeRoutes_js__WEBPACK_IMPORTED_MODULE_6__.tradeRouteForm)(_isValidated_js__WEBPACK_IMPORTED_MODULE_2__.isValidated, loader, removeLoader);
  if ($('#mt-form').length) (0,_matTraders_js__WEBPACK_IMPORTED_MODULE_7__.matTraders)();
  $('#accordionForm .accordion-button').on('click', function () {
    if ($(this).text().trim() === 'Close form') {
      $(this).text('Open form');
    } else if ($(this).text().trim() === 'Open form') {
      $(this).text('Close form');
    }
  });
  if ($("[role='tablist']").length) {
    $('.nav-link').on('click', function () {
      $('.nav-link.active').removeClass('active');
      $(this).addClass('active');
      $('.tab-pane.active').removeClass('active');
      $("#".concat($(this).attr('data-bs-toggle'))).addClass('active');
    });
  }

  // if ($('.add-to-db').length) getDataFromDom(fetchData);
});
})();

/******/ })()
;
//# sourceMappingURL=main.js.map