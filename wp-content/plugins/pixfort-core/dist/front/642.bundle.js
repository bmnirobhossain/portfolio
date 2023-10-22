"use strict";(self.webpackChunkpixfort_core=self.webpackChunkpixfort_core||[]).push([[642],{642:(e,r,n)=>{n.r(r);var o=n(379),t=n.n(o),i=n(616);t()(i.Z,{insert:"head",singleton:!1}),i.Z.locals,function(){$(".pix-custom-cursor").length||$("body").append('<div class="pix-custom-cursor"><div class="pix-cursor-inner"></div></div>');const e=document.querySelector(".pix-custom-cursor");PIX_JS_OPTIONS.hasOwnProperty("CURSOR_COLOR")&&($(".pix-custom-cursor .pix-cursor-inner").addClass(`bg-${PIX_JS_OPTIONS.CURSOR_COLOR}`),"exclusion"===PIX_JS_OPTIONS.CURSOR_COLOR&&$(".pix-custom-cursor").addClass("bg-exclusion"),1==PIX_JS_OPTIONS.DISABLE_DEFAULT_CURSOR&&$("body").addClass("pix-disable-default-cursor"));let r=!1;window.addEventListener("mousemove",(r=>{const n=r.clientY,o=r.clientX;e.style.transform=`translateX(${o}px) translateY(${n}px) translateZ(100px)`})),window.addEventListener("mouseout",(function(r){e.classList.add("hide-cursor")})),window.addEventListener("mouseenter",(function(r){e.classList.remove("hide-cursor")})),$("body").mouseover((function(){r||e.classList.remove("hide-cursor")})),$("body").on("mouseover","a, .btn, button, .video-play-btn, .jconfirm-closeIcon",(function(r){e.classList.add("cursor-focus")})),$("body").on("mouseout","a, .btn, button, .video-play-btn, .jconfirm-closeIcon",(function(r){e.classList.remove("cursor-focus")})),$("body").on("mouseover","iframe, .embed-responsive",(function(n){r=!0,e.classList.add("hide-cursor")})),$("body").on("mouseout","iframe, .embed-responsive",(function(n){r=!1,e.classList.add("hide-cursor")}))}()},616:(e,r,n)=>{n.d(r,{Z:()=>i});var o=n(645),t=n.n(o)()((function(e){return e[1]}));t.push([e.id,"body.pix-disable-default-cursor{cursor:none !important}body.pix-disable-default-cursor a,body.pix-disable-default-cursor *{cursor:none !important}.pix-custom-cursor{z-index:9999999999999;pointer-events:none;position:fixed;top:0;left:0;will-change:transform}.pix-custom-cursor.bg-exclusion{mix-blend-mode:exclusion}.pix-custom-cursor .pix-cursor-inner{width:72px;height:72px;margin-top:-50%;margin-left:-50%;border-radius:50%;transform-origin:center;transform:scale(0.25);will-change:transform,opacity;transform-style:flat;transition:opacity .2s ease-in-out,transform .2s ease-in-out;background-color:#fff}.pix-custom-cursor .pix-cursor-inner:not(.bg-exclusion){opacity:.3}.pix-custom-cursor .pix-cursor-inner.bg-default{background:#000;background:radial-gradient(circle, rgba(255, 255, 255, 0.2) 10%, rgba(0, 0, 0, 0.5) 100%)}.pix-custom-cursor.hide-cursor{opacity:0}.pix-custom-cursor.cursor-focus .pix-cursor-inner{transform:scale(1)}.pix-custom-cursor.cursor-focus .pix-cursor-inner:not(.bg-exclusion){opacity:.2}",""]);const i=t},645:e=>{e.exports=function(e){var r=[];return r.toString=function(){return this.map((function(r){var n=e(r);return r[2]?"@media ".concat(r[2]," {").concat(n,"}"):n})).join("")},r.i=function(e,n,o){"string"==typeof e&&(e=[[null,e,""]]);var t={};if(o)for(var i=0;i<this.length;i++){var s=this[i][0];null!=s&&(t[s]=!0)}for(var c=0;c<e.length;c++){var a=[].concat(e[c]);o&&t[a[0]]||(n&&(a[2]?a[2]="".concat(n," and ").concat(a[2]):a[2]=n),r.push(a))}},r}},379:(e,r,n)=>{var o,t=function(){var e={};return function(r){if(void 0===e[r]){var n=document.querySelector(r);if(window.HTMLIFrameElement&&n instanceof window.HTMLIFrameElement)try{n=n.contentDocument.head}catch(e){n=null}e[r]=n}return e[r]}}(),i=[];function s(e){for(var r=-1,n=0;n<i.length;n++)if(i[n].identifier===e){r=n;break}return r}function c(e,r){for(var n={},o=[],t=0;t<e.length;t++){var c=e[t],a=r.base?c[0]+r.base:c[0],u=n[a]||0,d="".concat(a," ").concat(u);n[a]=u+1;var l=s(d),f={css:c[1],media:c[2],sourceMap:c[3]};-1!==l?(i[l].references++,i[l].updater(f)):i.push({identifier:d,updater:v(f,r),references:1}),o.push(d)}return o}function a(e){var r=document.createElement("style"),o=e.attributes||{};if(void 0===o.nonce){var i=n.nc;i&&(o.nonce=i)}if(Object.keys(o).forEach((function(e){r.setAttribute(e,o[e])})),"function"==typeof e.insert)e.insert(r);else{var s=t(e.insert||"head");if(!s)throw new Error("Couldn't find a style target. This probably means that the value for the 'insert' parameter is invalid.");s.appendChild(r)}return r}var u,d=(u=[],function(e,r){return u[e]=r,u.filter(Boolean).join("\n")});function l(e,r,n,o){var t=n?"":o.media?"@media ".concat(o.media," {").concat(o.css,"}"):o.css;if(e.styleSheet)e.styleSheet.cssText=d(r,t);else{var i=document.createTextNode(t),s=e.childNodes;s[r]&&e.removeChild(s[r]),s.length?e.insertBefore(i,s[r]):e.appendChild(i)}}function f(e,r,n){var o=n.css,t=n.media,i=n.sourceMap;if(t?e.setAttribute("media",t):e.removeAttribute("media"),i&&"undefined"!=typeof btoa&&(o+="\n/*# sourceMappingURL=data:application/json;base64,".concat(btoa(unescape(encodeURIComponent(JSON.stringify(i))))," */")),e.styleSheet)e.styleSheet.cssText=o;else{for(;e.firstChild;)e.removeChild(e.firstChild);e.appendChild(document.createTextNode(o))}}var p=null,m=0;function v(e,r){var n,o,t;if(r.singleton){var i=m++;n=p||(p=a(r)),o=l.bind(null,n,i,!1),t=l.bind(null,n,i,!0)}else n=a(r),o=f.bind(null,n,r),t=function(){!function(e){if(null===e.parentNode)return!1;e.parentNode.removeChild(e)}(n)};return o(e),function(r){if(r){if(r.css===e.css&&r.media===e.media&&r.sourceMap===e.sourceMap)return;o(e=r)}else t()}}e.exports=function(e,r){(r=r||{}).singleton||"boolean"==typeof r.singleton||(r.singleton=(void 0===o&&(o=Boolean(window&&document&&document.all&&!window.atob)),o));var n=c(e=e||[],r);return function(e){if(e=e||[],"[object Array]"===Object.prototype.toString.call(e)){for(var o=0;o<n.length;o++){var t=s(n[o]);i[t].references--}for(var a=c(e,r),u=0;u<n.length;u++){var d=s(n[u]);0===i[d].references&&(i[d].updater(),i.splice(d,1))}n=a}}}}}]);